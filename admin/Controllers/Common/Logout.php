<?php namespace Admin\Controllers\Common;

class Logout extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->user->logout();

        return redirect()->to(base_url('index.php/common/login'));
    }


    //--------------------------------------------------------------------
}
