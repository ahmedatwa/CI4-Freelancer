<?php 

namespace Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class Language implements FilterInterface
{
    protected $LangData = [];

    public function before(RequestInterface $request, $arguments = null)
    {
        /**
        * @var renderer \Config\Services::renderer 
        */
        $view = \Config\Services::renderer();

        // Getting the Current Url Segment
        $language = [];
        $route = '';

        $uriParts = $request->uri->getSegments();

        if ($uriParts) {
            if (isset($uriParts[0]) && ($uriParts[0] == 'admin')) {
                 unset($uriParts[0]);
           }

           if (isset($uriParts[1]) && ($uriParts[1] == 'extensions')) {
                unset($uriParts[1]);
           }
        }

        // check if the last string is a method
        $methods = ['install', 'uninstall', 'add', 'edit', 'delete'];

        $last = end($uriParts);
        
        if (in_array($last, $methods)) {
            array_pop($uriParts);
        }

        $route = implode('/', $uriParts);

        if ($route) {

            $loader = Services::locator(true);

            $routeLang = [];
            // Controller Route Lang File array
            $routeLang = lang($route . '.list');

            // Combining the Master Language File if Exists
            $primaryLangPath = $loader->locateFile('en', 'Language/' . config('App')->defaultLocale);

            $primaryLang = [];

            if ($primaryLangPath) {
                $primaryLang = lang(config('App')->defaultLocale . '.list');
            }
           
            $language = array_merge($primaryLang, (array)$routeLang);

           }
           // Setting the lang tempData Array
          $this->LangData = $view->setData($language);
                    
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing Here
    }

    // ----------------------------------------------------
}
