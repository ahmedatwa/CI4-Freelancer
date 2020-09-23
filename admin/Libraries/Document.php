<?php namespace Admin\Libraries;

use Config\Services;

class Document
{
    protected static $ttl = 0 ;
    // Meta
    protected static $title;
    protected static $description;
    protected static $keywords;
    protected static $links = array();
    protected static $styles = array();
    protected static $scripts = array();



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
        self::$links[$href] = array(
            'href' => $href,
            'rel'  => $rel
        );
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
        self::$styles[$href] = array(
            'href'  => $href,
            'rel'   => $rel,
            'media' => $media
        );
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
            return array();
        }
    }
                
    // Preload Merge language needed in respective controller
    /**
    * @return array
    */
    protected function getLanguage(): array
    {
        $language = [];

        $loader = Services::locator(true);
        // Getting the Current Url Segment
        $uri = new \CodeIgniter\HTTP\URI((string) current_url(true));

        $totalSegments = $uri->getTotalSegments();

        if ($totalSegments > 3) {
            // Determine if the Last Segment is a Class or Method
            $controllerFile = $loader->locateFile(ucfirst($uri->getSegment(4)), ucfirst($uri->getSegment(2)) . '/Controllers/' . ucfirst($uri->getSegment(3)));
            
            if ($controllerFile) {
                $route = $uri->getSegment(3)  . '/' . $uri->getSegment(4);
            } else {
                $route = $uri->getSegment(2)  . '/' . $uri->getSegment(3);
            }
        } else {
            $route = $uri->getSegment(2)  . '/' . $uri->getSegment(3);
        }

        if ($route) {
            $langArray = lang($route . '.list');
        }
        // Combining the Master Language File if Exists
        $localeLangFile = $loader->locateFile(config('App')->defaultLocale ?? 'en', 'Language/' . config('App')->defaultLocale ?? 'en');

        if ($localeLangFile) {
            $primaryLang = lang('en.list');
        } else {
            $primaryLang = [];
        }

        // escape if .list lang not found
        if (! is_array($langArray)) {
            $language = $primaryLang;
        } else {
            $language = array_merge($primaryLang, $langArray);
        }
        // }
        return $language;
    }

    //  Final Template Output
    public function output(string $view, array $data = [])
    {
        // Renderer
        $renderer = \Config\Services::renderer();

        $options = [];
        // Merge Language Data
        if (is_array($this->getLanguage())) {
            $data = array_merge($this->getLanguage(), $data);
        }

        // Parts
        $data['header']      = view_cell('\Admin\Controllers\Common\Header::index', null, 900);
        $data['column_left'] = view_cell('\Admin\Controllers\Common\Column_left::index', null, 900);
        $data['footer']      = view_cell('\Admin\Controllers\Common\Footer::index', null, 900);

        echo $renderer->setData($data)->render($view, $options);
    }

    //  Final Template Output
    public function moduleOutput(string $type, string $view, array $data = [])
    {
        // Renderer
        $renderer = \Config\Services::renderer();
        // Merge Language Data
        if (is_array($this->getLanguage())) {
            $data = array_merge($this->getLanguage(), $data);
        }

        // Parts
        $data['header']      = view_cell('\Admin\Controllers\Common\Header::index', null, 900);
        $data['column_left'] = view_cell('\Admin\Controllers\Common\Column_left::index', null, 900);
        $data['footer']      = view_cell('\Admin\Controllers\Common\Footer::index', null, 900);

        echo $renderer->setData($data)->render($type . '\Views\template\\' . $view);
    }

    // --------------------------------------------------------------------------------------------------
}
