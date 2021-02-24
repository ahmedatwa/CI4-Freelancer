<?php

namespace Catalog\Libraries;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\TwigFunction;

class Twig {
  /**
   * @var array Paths to Twig templates
   */
  private $paths = [];

  /**
   * @var array Twig Environment Options
   * @see http://twig.sensiolabs.org/doc/api.html#environment-options
   */
  private $config = [];

  /**
   * @var array Functions to add to Twig
   */
  private $functions_asis = [
    'base_url', 'site_url',
  ];

  /**
   * @var array Functions with `is_safe` option
   * @see http://twig.sensiolabs.org/doc/advanced.html#automatic-escaping
   */
  private $functions_safe = ['csrf_token', 'csrf_hash'
    // 'form_open_multipart', 'form_upload', 'form_submit', 'form_dropdown',
    // 'set_radio', 'set_select', 'set_checkbox',
  ];

  /**
   * @var bool Whether functions are added or not
   */
  private $functions_added = false;

  /**
   * @var Environment
   */
  private $twig;

  /**
   * @var FilesystemLoader
   */
  private $loader;

  public function __construct($params = []) {
    if (isset($params['functions'])) {
      $this->functions_asis =
        array_unique(
          array_merge($this->functions_asis, $params['functions'])
        );
      unset($params['functions']);
    }
    if (isset($params['functions_safe'])) {
      $this->functions_safe =
        array_unique(
          array_merge($this->functions_safe, $params['functions_safe'])
        );
      unset($params['functions_safe']);
    }

    if (isset($params['paths'])) {
      $this->paths = $params['paths'];
      unset($params['paths']);
    } else {
      $this->paths = config('paths')->viewDirectory;
    }

    // default Twig config
    $this->config = [
      'cache' => config('Paths')->writableDirectory.'/cache',
      'debug' => ENVIRONMENT !== 'production',
      'autoescape' => 'html',
    ];

    $this->config = array_merge($this->config, $params);
  }

  protected function resetTwig() {
    $this->twig = null;
    $this->createTwig();
  }

  protected function createTwig() {
    // $this->twig is singleton
    if ($this->twig !== null) {
      return;
    }

    if ($this->loader === null) {
      $this->loader = new FilesystemLoader($this->paths);
    }

    $twig = new Environment($this->loader, $this->config);

    if ($this->config['debug']) {
      $twig->addExtension(new DebugExtension());
    }

    $this->twig = $twig;
  }

  protected function setLoader($loader) {
    $this->loader = $loader;
  }

  /**
   * Registers a Global
   *
   * @param string $name  The global name
   * @param mixed  $value The global value
   */
  public function addGlobal($name, $value) {
    $this->createTwig();
    $this->twig->addGlobal($name, $value);
  }

  /**
   * Renders Twig Template and Set Output
   *
   * @param string $view   Template filename without `.twig`
   * @param array  $params Array of parameters to pass to the template
   */
  public function display($view, $params = []) {
    echo $this->render($view, $params);
  }

  /**
   * Renders Twig Template and Returns as String
   *
   * @param string $view   Template filename without `.twig`
   * @param array  $params Array of parameters to pass to the template
   * @return string
   */
  public function render($view, $params = []) {
    $this->createTwig();
    // We call addFunctions() here, because we must call addFunctions()
    // after loading CodeIgniter functions in a controller.
    $this->addFunctions();

    $view = $view.'.twig';

    return $this->twig->render($view, $params);
  }

  protected function addFunctions() {
    // Runs only once
    if ($this->functions_added) {
      return;
    }

    // as is functions
    foreach ($this->functions_asis as $function) {
      
      if (function_exists($function)) {
        $this->twig->addFunction(
          new TwigFunction(
            $function,
            $function
          )
        );
      }
    }

    // safe functions
    foreach ($this->functions_safe as $function) {
      var_dump( function_exists($function) );
      if (function_exists($function)) {
        $this->twig->addFunction(
          new TwigFunction(
            $function,
            $function,
            ['is_safe' => ['html']]
          )
        );
      }
    }

    // customized functions
    if (function_exists('anchor')) {
      $this->twig->addFunction(
        new TwigFunction(
          'anchor',
          [$this, 'safe_anchor'],
          ['is_safe' => ['html']]
        )
      );
    }

    $this->functions_added = true;
  }

  /**
   * @param string $uri
   * @param string $title
   * @param array  $attributes [changed] only array is acceptable
   * @return string
   */
  public function safe_anchor($uri = '', $title = '', $attributes = []) {
    $uri = esc($uri);
    $title = esc($title);

    $new_attr = [];
    foreach ($attributes as $key => $val) {
      $new_attr[esc($key)] = esc($val);
    }

    return anchor($uri, $title, $new_attr);
  }

  /**
   * @return Environment
   */
  public function getTwig() {
    $this->createTwig();

    return $this->twig;
  }
}