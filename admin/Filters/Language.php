<?php namespace Admin\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class Language implements FilterInterface
{
    protected $LangData = [];

    public function before(RequestInterface $request)
    {
        
        $view = \Config\Services::renderer();
        $loader = Services::locator(true);
        // Getting the Current Url Segment
        $uri = new \CodeIgniter\HTTP\URI((string) current_url(true));

        $language = [];

        $route = '';

        $parts = $uri->getSegments();

        if (isset($parts[0]) && ($parts[0] == 'extensions')) {
             unset($parts[0]);
        }

        // check if the last string is a method
        $methods = ['install', 'uninstall', 'add', 'edit', 'delete'];

        $last = end($parts);
        
        if (in_array($last, $methods)) {
            array_pop($parts);
        }

        $route = implode('/', $parts);
        
        if ($route) {

            $routeLang = [];

            $routeLang = lang($route . '.list');

            // Combining the Master Language File if Exists

            $primaryLangPath = $loader->locateFile('en', 'Language/' . config('App')->defaultLocale);

            $primaryLang = [];

            if ($primaryLangPath) {
                $primaryLang = lang(config('App')->defaultLocale . '.list');
            }
           
            $language = array_merge($primaryLang, (array)$routeLang);
           }
           $data = [];
           
          
          $this->LangData = $view->setData($language);
          
         
        //   foreach ($this->LangData as $key => $value)
        //   {
        //      var_dump($route . '.' . $key); 
        //       lang($route . '.' . $key);
        //   }
          
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        //var_dump($request);
        //return $this->LangData;
    }

    // ----------------------------------------------------
}
