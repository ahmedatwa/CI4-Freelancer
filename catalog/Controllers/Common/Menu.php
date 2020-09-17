<?php namespace Catalog\Controllers\Common;

class Menu extends \Catalog\Controllers\BaseController
{
    public function index()
    {

        // Extensions
        $extensions_model = new \Catalog\Models\Setting\Extensions();

        $data['blog'] = [];

        $blog = $extensions_model->getExtensions('blog');

        // Menu
        $data['menus'][] = [
            'id'       => 'menu-home',
            'name'     => lang('common/menu.text_home'),
            'icon'     => '',
            'href'     => base_url(),
            'children' => [],
        ];

        $data['menus'][] = [
            'id'       => 'menu-project',
            'name'     => lang('common/menu.text_project'),
            'icon'     => '',
            'href'     => route_to('project/category'),
            'children' => [],
        ];
        $data['menus'][] = [
            'id'       => 'menu-employer',
            'name'     => lang('common/menu.text_employer'),
            'icon'     => '',
            'href'     => route_to('project/category'),
            'children' => [],
        ];
        // if ($this->registry->get('blog_status')) {
        //     $data['menus'][] = [
        //     'id'       => 'menu-blog',
        //     'name'     => lang('extension/blog/blog.heading_title'),
        //     'icon'     => '',
        //     'href'     => base_url('blog'),
        //     'children' => [],
        // ];
        // }

        // Links


        return view('common/menu', $data);
    }


    //--------------------------------------------------------------------
}
