<?php namespace Catalog\Controllers\Common;

class Menu extends \Catalog\Controllers\BaseController
{

    public function index()
    {

        $data['text_menu']        = lang('common/menu.text_menu');
        $data['text_login']       = lang('common/menu.text_login');
        $data['text_register']    = lang('common/menu.text_register');
        $data['button_logout']    = lang('common/menu.button_logout');
        $data['button_messages']  = lang('common/menu.button_messages');
        $data['button_dashboard'] = lang('common/menu.button_dashboard');

        // Extensions
        $extensions_model = new \Catalog\Models\Setting\Extensions();

        $data['blog'] = [];

        $blog = $extensions_model->getExtensions('blog');

        // Menu 
        $data['menus'][] = [
            'id'       => 'menu-home',
            'name'     => lang('common/menu.text_home'),
            'icon'     => '',
            'href'     => base_url('/'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id'       => 'menu-jobs',
            'name'     => lang('common/menu.text_jobs'),
            'icon'     => '',
            'href'     => base_url('project/category'),
            'children' => [],
        ];
        if ($blog) {
        $data['menus'][] = [
            'id'       => 'menu-blog',
            'name'     => lang('common/menu.blog'),
            'icon'     => '',
            'href'     => base_url('extensions/blog'),
            'children' => [],
        ];
    }

       // Links 
        $data['home']      = base_url('/');
        $data['register']  = base_url('common/register');
        $data['action']    = base_url('common/login');
        $data['forgotton'] = base_url('common/forgotten');
        $data['logout']    = base_url('common/logout');

        $data['button_logout']    = lang('common/menu.button_logout');
        $data['button_dashboard'] = lang('common/menu.button_dashboard');
        $data['button_messages']  = lang('common/menu.button_messages');


        $data['isLogged'] = $this->customer->isLogged();
        $data['username'] = $this->customer->getcustomerName();
        $data['image']    = '';


        return view ('common/menu', $data);
    }


    //--------------------------------------------------------------------
}