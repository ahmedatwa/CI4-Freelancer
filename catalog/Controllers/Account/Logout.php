<?php namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;

class Logout extends BaseController
{

    public function index()
    {

        $this->customer->logout();

        return redirect()->to('/');
    }

    //--------------------------------------------------------------------
}
