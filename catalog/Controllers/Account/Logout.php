<?php namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;

class Logout extends BaseController
{

    public function index()
    {
    	$json = [];

        $this->customer->logout();
        
        $json['redirect'] = base_url();
        

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
