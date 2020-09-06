<?php namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;

class Logout extends BaseController
{

    public function index()
    {
        if ($this->customer->isLogged()) {
        	$this->customer->logout();

        	$this->session->destroy();
        }
        return redirect()->to('/');
    }

    //--------------------------------------------------------------------
}
