<?php namespace Catalog\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Seo_url implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $data = [];

        $segments = explode('/', uri_string());

        $slug = end($segments);

        if ($slug) {
            $seo_urls_model = new \Catalog\Models\Design\Seo_urls();
            
            $query = (string) $seo_urls_model->getQueryByKeyword($slug);

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
