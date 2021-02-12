<?php

namespace Install\Libraries;

use Config\Services;

class Document
{
    protected $title;
    protected $description;
    protected $keywords;
    protected $links = [];
    protected $styles = [];
    protected $scripts = [];
    protected $language = [];

    public function __construct()
    {
        log_message('info', 'Install Document class initialized');

        $loader = Services::locator(true);
        // Getting the Current Url Segment
        $uri = new \CodeIgniter\HTTP\URI((string) current_url(true));

        $totalSegments = $uri->getTotalSegments();
        
        if ($totalSegments) {
            if (uri_string() == '/') {
                $route = 'step_1';
            } else {
                $route = $uri->getSegment(2);
            }

            $this->language = lang($route . '.list');
        }
    }

    /**
     *
     *
     * @param   string  $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
    /**
     *
     *
     * @return  string
     */
    public function getTitle()
    {
        return service('registry')->get('config_name') . ' | ' . (string) $this->title;
    }
    /**
     *
     * @param   string  $href
     * @param   string  $rel
     * @param   string  $media
     */
    public function addStyle($href, $rel = 'stylesheet', $media = 'screen')
    {
        $this->styles[$href] = [
            'href'  => $href,
            'rel'   => $rel,
            'media' => $media
        ];
    }

    /**
     *
     * @return  array
     */
    public function getStyles()
    {
        return esc($this->styles, 'html');
    }
    /**
     *
     *
     * @param   string  $src
     * @param   string  $postion
     */
    public function addScript($src, $postion = 'footer')
    {
        $this->scripts[$postion][$src] = $src;
    }
    /**
     *
     *
     * @param   string  $postion
     *
     * @return  array
     */
    public function getScripts($postion = 'footer')
    {
        if (isset($this->scripts[$postion])) {
            return esc($this->scripts[$postion], 'html');
        } else {
            return [];
        }
    }
    
    // Generating Final Template Output
    public function setOutput(string $view, array $data = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader(config('Paths')->viewDirectory);
        // initialize Twig environment
        $config = [
                'autoescape'  => false,
                'debug'       => false,
                'auto_reload' => true,
                'cache'       => config('paths')->writableDirectory . '/cache/'
            ];

        $twig  = new \Twig\Environment($loader, $config);

        // Merge Language Data
        if (is_array($this->language)) {
            $data = array_merge($this->language, $data);
        }

        echo $twig->render($view . '.twig', $data);
    }

    // --------------------------------------------------------------------------------------------------
}
