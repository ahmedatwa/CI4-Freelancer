<?php

namespace Catalog\Libraries;

use Config\Services;

class Template
{
    protected $title = '';
    protected $description = '';
    protected $keywords = '';
    protected $links = [];
    protected $styles = [];
    protected $scripts = [];
    protected $functions_safe = ['csrf_field', 'csrf_token', 'csrf_hash'];

    public function __construct()
    {
        log_message('info', 'Template class initialized');
    }
    /**
     *
     * @return void
     * @param   string  $title
     */
    public function setTitle(string $title): void
    {
        /**
        * if lang() failed to locate the lang string value
        * will try to look for the lang string value inside the .list array
        * so will eliminate the lang() to return the lang text string
        * otherwise will be ignored.
        */
        if (strpos($title, '/')) {
            $explode = explode('.', $title);
            $title = lang(str_replace($explode[0], $explode[0] . '.list.', $explode[0]) . $explode[1]);
        }
        $this->title = $title;
    }
    /**
     *
     *
     * @return  string
     */
    public function getTitle(): string
    {
        return service('registry')->get('config_name') . ' | ' . (string) $this->title;
    }

    /**
     *
     *
     * @param   string  $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     *
     * @param   string  $description
     * @return  string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     *
     * @return void
     * @param   string  $keywords
     */
    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }

    /**
     *
     *
     * @return  string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }
    
    /**
     *
     * @return void
     * @param   string  $href
     * @param   string  $rel
     */
    public function addLink(string $href, string $rel): void
    {
        $this->links[$href] = [
            'href' => $href,
            'rel'  => $rel
        ];
    }

    /**
     *
     *
     * @return  array
     */
    public function getLinks(): array
    {
        return esc($this->links);
    }
    /**
     *
     * @return void
     * @param   string  $href
     * @param   string  $rel
     * @param   string  $media
     */
    public function addStyle(string $href, string $rel = 'stylesheet', string $media = 'screen'): void
    {
        $this->styles[$href] = [
            'href'  => $href,
            'rel'   => $rel,
            'media' => $media
        ];
    }

    /**
     *
     *
     * @return  array
     */
    public function getStyles(): array
    {
        return esc($this->styles, 'html');
    }
    /**
     *
     * @param   string  $src
     * @param   string  $postion
     */
    public function addScript(string $src, string $postion = 'footer'): void
    {
        $this->scripts[$postion][$src] = $src;
    }
    /**
     *
     * @param   string  $postion
     * @return  array
     */
    public function getScripts(string $postion = 'footer'): array
    {
        if (isset($this->scripts[$postion])) {
            return esc($this->scripts[$postion], 'html');
        } else {
            return [];
        }
    }

    // Generating Final Template Output
    public function output(string $name, array $data = [])
    {
        // merge the langData if sent from controller
        $primaryLang = lang(config('App')->defaultLocale . '.list');
        if (isset($data['langData'])) {
            if (is_array($primaryLang)) {
                $all = array_merge($data['langData'], $primaryLang);
            }
            $data = array_merge($all, $data);
        }

        if (config('Config')->templateEngine == 'twig') {
            // specify where to look for templates
            $loader = new \Twig\Loader\FilesystemLoader(config('paths')->viewDirectory);
            // initialize Twig environment
            $config = [
                'charset'     => 'utf-8',
                'autoescape'  => false,
                'debug'       => ENVIRONMENT !== 'production',
                'auto_reload' => true,
                'cache'       => config('paths')->writableDirectory . '/cache/',
            ];

            $twig  = new \Twig\Environment($loader, $config);
            // Safe csrf PHP function
            foreach ($this->functions_safe as $value) {
                if (function_exists($value)) {
                    $twig->addFunction(
                        new \Twig\TwigFunction((string) $value, $value, ['is_safe' => ['html']])
                    );
                }
            }

            $data['header']         = view_cell('\Catalog\Controllers\Common\Header::index');
            $data['menu']           = view_cell('\Catalog\Controllers\Common\Menu::index');
            $data['column_left']    = view_cell('\Catalog\Controllers\Common\Column_left::index');
            $data['column_right']   = view_cell('\Catalog\Controllers\Common\Column_right::index');
            $data['content_top']    = view_cell('\Catalog\Controllers\Common\Content_top::index');
            $data['content_bottom'] = view_cell('\Catalog\Controllers\Common\Content_bottom::index');
            $data['footer']         = view_cell('\Catalog\Controllers\Common\Footer::index');

            echo $twig->render(service('registry')->get('config_theme') . '/' . $name . '.twig', $data);
        } else {
            // Renderer
            $renderer = \Config\Services::renderer();
            // Parts
            $data['header']         = view_cell('\Catalog\Controllers\Common\Header::index');
            $data['menu']           = view_cell('\Catalog\Controllers\Common\Menu::index');
            $data['column_left']    = view_cell('\Catalog\Controllers\Common\Column_left::index');
            $data['column_right']   = view_cell('\Catalog\Controllers\Common\Column_right::index');
            $data['content_top']    = view_cell('\Catalog\Controllers\Common\Content_top::index');
            $data['content_bottom'] = view_cell('\Catalog\Controllers\Common\Content_bottom::index');
            $data['footer']         = view_cell('\Catalog\Controllers\Common\Footer::index');

            echo $renderer->setData($data)->render(service('registry')->get('config_theme') . '/' . $name);
        }
    }

    // --------------------------------------------------------------------------------------------------
}
