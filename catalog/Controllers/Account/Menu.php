<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Menu extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['menus'] = [];

        $data['menus'][] = [
            'id'    => 'menu-start',
            'icon'  => 'icon-material-outline-menu',
            'class' => 'active',
            'name'  => lang('account/menu.text_dashboard'),
            'href'  => route_to('account_dashboard') ? route_to('account_dashboard') : base_url('account/dashboard'),
        ];

        $data['menus'][] = [
            'id'       => 'menu-manage',
            'icon'     => 'icon-feather-arrow-right',
            'class'    => '',
            'name'     => lang('account/menu.text_my_projects'),
            'href'     => route_to('account_project') ? route_to('account_project') : base_url('account/project'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id'       => 'menu-start',
            'icon'     => 'icon-material-outline-question-answer',
            'class'    => '',
            'name'     => lang('account/menu.text_messages'),
            'href'     => route_to('account_message') ? route_to('account_message') : base_url('account/message'),
            'children' => [],
        ];

         $data['menus'][] = [
            'id'       => 'menu-start',
            'icon'     => 'icon-material-outline-rate-review',
            'class'    => '',
            'name'     => lang('account/menu.text_reviews'),
            'href'     => route_to('account_review') ? route_to('account_review') : base_url('account/review'),
            'children' => [],
        ];

        return view ('account/menu', $data);
    }
    //--------------------------------------------------------------------
}
