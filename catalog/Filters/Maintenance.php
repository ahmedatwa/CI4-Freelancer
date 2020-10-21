<?php namespace Catalog\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Maintenance implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        if (service('registry')->get('config_maintenance') == 1) {
            echo view_cell('Catalog\Controllers\Common\Maintenance::index');
            exit;
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
