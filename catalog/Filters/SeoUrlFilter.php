<?php namespace Catalog\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SeoUrlFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $data = [];

        $slug = '';

        $segments = explode('/', uri_string());

        $slug = end($segments);

        if ($slug) {
            $seoUrl = service('seo_url');

            $query = $seoUrl->getQueryByKeyword(urldecode($slug));

            parse_str($query, $data);

            $request->setGlobal('get', $data);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
