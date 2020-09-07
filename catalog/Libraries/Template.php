<?php namespace Catalog\Libraries;

class Template
{
    protected static $title;
    protected static $description;
    protected static $keywords;
    protected static $links = [];
    protected static $styles = [];
    protected static $scripts = [];



    public function __construct()
    {
        log_message('info', 'Template class initialized');
    }

    /**
     *
     *
     * @param   string  $title
     */
    public function setTitle(string $title)
    {
        self::$title = $title;
    }
    /**
     *
     *
     * @return  string
     */
    public function getTitle()
    {
        return (string) self::$title;
    }

    /**
     *
     *
     * @param   string  $description
     */
    public function setDescription(string $description)
    {
        self::$description = $description;
    }

    /**
     *
     *
     * @param   string  $description
     *
     * @return  string
     */
    public function getDescription()
    {
        return self::$description;
    }

    /**
     *
     *
     * @param   string  $keywords
     */
    public function setKeywords($keywords)
    {
        self::$keywords = $keywords;
    }

    /**
     *
     *
     * @return  string
     */
    public function getKeywords()
    {
        return self::$keywords;
    }
    
    /**
     *
     *
     * @param   string  $href
     * @param   string  $rel
     */
    public function addLink($href, $rel)
    {
        self::$links[$href] = [
            'href' => $href,
            'rel'  => $rel
        ];
    }

    /**
     *
     *
     * @return  array
     */
    public function getLinks()
    {
        return self::$links;
    }
    /**
     *
     *
     * @param   string  $href
     * @param   string  $rel
     * @param   string  $media
     */
    public function addStyle($href, $rel = 'stylesheet', $media = 'screen')
    {
        self::$styles[$href] = [
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
    public function getStyles()
    {
        return self::$styles;
    }
    /**
     *
     *
     * @param   string  $src
     * @param   string  $postion
     */
    public function addScript($src, $postion = 'footer')
    {
        self::$scripts[$postion][$src] = $src;
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
        if (isset(self::$scripts[$postion])) {
            return self::$scripts[$postion];
        } else {
            return [];
        }
    }

    // Generating Final Template Output
    public function output(string $view, array $data)
    {
        if (config('App')->templateEngine == 'twig') {
            // specify where to look for templates
            $loader = new \Twig\Loader\FilesystemLoader(config('paths')->viewDirectory);
            // initialize Twig environment
            $config = [
                'autoescape'  => false,
                'debug'       => false,
                'auto_reload' => true,
                'cache'       => config('paths')->writableDirectory . '/cache/'
            ];

            $twig  = new \Twig\Environment($loader, $config);

            $data['header']      = view_cell('\Catalog\Controllers\Common\Header::index');
            $data['menu']        = view_cell('\Catalog\Controllers\Common\Menu::index');
            $data['column_left'] = view_cell('\Catalog\Controllers\Common\Column_left::index');
            $data['footer']      = view_cell('\Catalog\Controllers\Common\Footer::index');

            echo $twig->render(getSettingValue('config_theme') . '/' . $view . '.twig', $data);
        } else {
            // Renderer
            $renderer = \Config\Services::renderer();
            // Parts
            $data['header']      = view_cell('\Catalog\Controllers\Common\Header::index');
            $data['menu']        = view_cell('\Catalog\Controllers\Common\Menu::index');
            $data['column_left'] = view_cell('\Catalog\Controllers\Common\Column_left::index');
            //$data['column_right'] = view_cell('\Catalog\Controllers\Common\Column_right::index');
            //$data['content_top'] = view_cell('\Catalog\Controllers\Common\Content_top::index');
            //$data['content_bottom'] = view_cell('\Catalog\Controllers\Common\Content_bottom::index');
            $data['footer'] = view_cell('\Catalog\Controllers\Common\Footer::index');

            echo $renderer->setData($data)->render(getSettingValue('config_theme') . '/' . $view);
        }
    }

    // --------------------------------------------------------------------------------------------------
}
