<?php namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;

class Logout extends BaseController
{

    public function index()
    {

        $this->customer_id = '';
        $this->customer_name = '';
        $this->customer_group_id = '';
        $this->isLogged = '';
        $this->session->destroy();

        return redirect()->to('/');
    }

    //--------------------------------------------------------------------
}
