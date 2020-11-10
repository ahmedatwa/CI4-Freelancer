<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Logout extends \Catalog\Controllers\BaseController
{

    public function index()
    {
    	$json = [];

    	$customerModel = new CustomerModel();

    	$customerModel->setOnlineStatus(0);

        $this->customer->logout();
        
        $json['redirect'] = base_url();
     
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
