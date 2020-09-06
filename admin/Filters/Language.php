<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class Language implements FilterInterface
{

    public function before(RequestInterface $request)
    {
        $view = \Config\Services::renderer();

        $language = [];
        static $route = '';
        $loader = Services::locator(true);
        // Getting the Current Url Segment
        $uri = new \CodeIgniter\HTTP\URI((string) current_url(true));

        $total_segments = $uri->getTotalSegments();

        if ($total_segments != 1) {
            $last = $loader->locateFile($uri->getSegment(4), 'Controllers/' .$uri->getSegment(2) . '/' . $uri->getSegment(3));
            // for named routes controller name must be the same folder name
            if ($last) {
                $route = $uri->getSegment(2) . '/' . $uri->getSegment(3)  . '/' . $uri->getSegment(4);
            } else {
                $route = $uri->getSegment(2) . '/' . $uri->getSegment(3);
            }

            if ($route) {
                // Check if Lang File Exists
                static $route_language_path = '';

                $default_path = $loader->locateFile($route, 'Language/' . config('App')->defaultLocale);
                $modules_path = $loader->locateFile($route, 'Modules/Language/' . config('App')->defaultLocale);

                // throw exception error if not found
                if ($default_path) {
                    $route_language_path = $default_path;
                } else {
                    $route_language_path = $modules_path;
                }

                if (! $route_language_path) {
                    throw new \Exception("Language File couldn't be found!");
                }

                $route_language = lang($route . '.list');

                // Combining the Master Language File if Exists

                $master_language_path = $loader->locateFile('en', 'Language/' . config('App')->defaultLocale);

                if (! file_exists($master_language_path)) {
                    $master_language = array();
                } else {
                    $master_language = lang('en.list');
                }
                // escape if .list lang not found
                if (! is_array($route_language)) {
                    $language = $master_language;
                } else {
                    $language = array_merge($master_language, $route_language);
                }
            } else {
                // Silet Segment unreachable Error
                $uri->setSilent();
            }
        }

        $view->setData($language);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    // ----------------------------------------------------
}
