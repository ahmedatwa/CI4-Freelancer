<?php namespace Admin\Libraries;

use Config\Services;

class Document
{
    // Meta
    protected $title;
    protected $description;
    protected $keywords;
    protected $links = [];
    protected $styles = [];
    protected $scripts = [];



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
        $this->title = $title;
    }
    /**
     *
     *
     * @return  string
     */
    public function getTitle()
    {
        return service('registry')->get('config_name') . ' :: ' . $this->title;
    }

    /**
     *
     *
     * @param   string  $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
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
        return $this->description;
    }

    /**
     *
     *
     * @param   string  $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     *
     *
     * @return  string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }
    
    /**
     *
     *
     * @param   string  $href
     * @param   string  $rel
     */
    public function addLink($href, $rel)
    {
        $this->links[$href] = array(
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
        return $this->links;
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
        $this->styles[$href] = [
            'rel'   => $rel,
            'href'  => $href,
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
        return $this->styles;
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
            return $this->scripts[$postion];
        } else {
            return [];
        }
    }
                
    // Preload Merge language needed in respective controller
    /**
    * @return array
    */
    // protected function getLanguage(): array
    // {
    //     $route = '';

    //     $language = [];

    //     $langArray = [];

    //     $loader = Services::locator(true);
    //     // Getting the Current Url Segment
    //     $uri = new \CodeIgniter\HTTP\URI((string) current_url(true));

    //     $totalSegments = $uri->getTotalSegments();

    //     if ($totalSegments > 3) {
    //         // Determine if the Last Segment is a Class or Method
    //         $controllerFile = $loader->locateFile(ucfirst($uri->getSegment(4)), ucfirst($uri->getSegment(2)) . '/Controllers/' . ucfirst($uri->getSegment(3)));
    //         if ($controllerFile) {
    //             $route = $uri->getSegment(3)  . '/' . $uri->getSegment(4);
    //         } else {
    //             $route = $uri->getSegment(2)  . '/' . $uri->getSegment(3);
    //         }
    //     } elseif ($totalSegments == 2) {
    //         $route = $uri->getSegment(1)  . '/' . $uri->getSegment(2);
    //     }

    //     if ($route) {
    //         $langArray = lang($route . '.list');
    //     }

    //     // Combining the Master Language File if Exists
    //     $localeLangFile = $loader->locateFile(config('App')->defaultLocale ?? 'en', 'Language/' . config('App')->defaultLocale ?? 'en');

    //     if ($localeLangFile) {
    //         $primaryLang = lang('en.list');
    //     } else {
    //         $primaryLang = [];
    //     }

    //     // escape if .list lang not found
    //     if (! is_array($langArray)) {
    //         $language = $primaryLang;
    //     } else {
    //         $language = array_merge($primaryLang, $langArray);
    //     }
       

    //     return $language;
    // }

    //  Final Template Output
    public function output(string $view, array $data = [])
    {
        // Renderer
        $renderer = \Config\Services::renderer();

        // Merge Language Data
        // if (is_array($this->getLanguage())) {
        //     $data = array_merge($this->getLanguage(), $data);
        // }

        // Parts
        $data['header']      = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left'] = view_cell('\Admin\Controllers\Common\Column_left::index');
        $data['footer']      = view_cell('\Admin\Controllers\Common\Footer::index');

        echo $renderer->setData($data)->render($view);
    }

    //  Final Template Output
    public function moduleOutput(string $type, string $view, array $data = [])
    {
        // Renderer
        $renderer = \Config\Services::renderer();
        // Merge Language Data
        // if (is_array($this->getLanguage())) {
        //     $data = array_merge($this->getLanguage(), $data);
        // }

        // Parts
        $data['header']      = view_cell('\Admin\Controllers\Common\Header::index');
        $data['column_left'] = view_cell('\Admin\Controllers\Common\Column_left::index');
        $data['footer']      = view_cell('\Admin\Controllers\Common\Footer::index');

        echo $renderer->setData($data)->render($type . '\Views\template\\' . $view);
    }

    // --------------------------------------------------------------------------------------------------
}
