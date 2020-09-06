<?php namespace Admin\Controllers\Error;

class Permission extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('error/permission.text_title'));

        $data['heading_title'] = lang('error/permission.heading_title');

        $data['text_permission'] = lang('error/permission.list.text_permission');
        
        return $this->document->output('error/permission', $data);
    }



    //--------------------------------------------------------------------
}
