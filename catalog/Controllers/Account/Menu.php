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
            'href'  => base_url('account/dashboard?cid=' . $this->customer->getCustomerId()),
        ];

        $data['menus'][] = [
            'id'       => 'menu-start',
            'icon'     => 'icon-material-outline-question-answer',
            'class'    => '',
            'name'     => lang('account/menu.text_messages'),
            'href'     => base_url('account/messages?cid=' . $this->customer->getCustomerId()),
            'children' => [],
        ];

         $data['menus'][] = [
            'id'       => 'menu-start',
            'icon'     => 'icon-material-outline-rate-review',
            'class'    => '',
            'name'     => lang('account/menu.text_reviews'),
            'href'     => base_url('account/review?cid=' . $this->customer->getCustomerId()),
            'children' => [],
        ];

        // $data['menus'][] = [
        //     'id'       => 'menu-start',
        //     'name'     => 'Start',
        //     'children' => $start,
        // ];

        $data['menus'][] = [
            'id'       => 'menu-account',
            'icon'     => 'icon-material-outline-settings',
            'class'    => '',
            'name'     => lang('account/menu.text_settings'),
            'href'     => base_url('account/setting?cid=' . $this->customer->getCustomerId()),
            'children' => [],
        ];

        

        // $data['menus'][] = [
        //     'id'       => 'menu-account',
        //     'name'     => 'Account',
        //     'children' => $account,
        // ];
        
        // Projects 
        $projects = [];
        $data['menus'][] = [
            'id'       => 'menu-manage',
            'icon'     => 'icon-feather-arrow-right',
            'class'    => '',
            'name'     => lang('account/menu.text_my_projects'),
            'href'     => base_url('employer/project?cid=' . $this->customer->getCustomerId()),
            'children' => [],
        ];
        // $manage [] = [
        //     'id'       => 'menu-manage',
        //     'icon'     => 'icon-feather-arrow-right',
        //     'class'    => '',
        //     'name'     => lang('account/menu.text_manage_bidders'),
        //     'href'     => base_url('account/dashboard/bidders?customer_id=' . $this->customer->getCustomerId()),
        //     'children' => [],
        // // ];
        $data['menus'][] = [
            'id'       => 'menu-manage',
            'icon'     => 'icon-feather-arrow-right',
            'class'    => '',
            'name'     => lang('account/menu.text_active_bids'),
            'href'     => base_url('employer/bids?cid=' . $this->customer->getCustomerId()),
            'children' => [],
        ];

        // $data['menus'][] = [
        //     'id'       => 'menu-account',
        //     'icon'     => 'icon-material-outline-power-settings-new',
        //     'class'    => '',
        //     'name'     => lang('account/menu.text_logout'),
        //     'href'     => route_to('account/logout'),
        //     'children' => [],
        // ];
        // $manage [] = [
        //     'id'       => 'menu-manage',
        //     'icon'     => 'icon-feather-arrow-right',
        //     'class'    => '',
        //     'name'     => lang('account/menu.text_post_project'),
        //     'href'     => base_url('account/manage/project/add?customer_id=' . $this->customer->getCustomerId()),
        //     'children' => [],
        // ];
        // $projects[] = [
        //     'id'       => 'menu-manage',
        //     'icon'     => '',
        //     'name'     => lang('account/menu.text_projects'),
        //     'class'     => '',
        //     'href'     => '',
        //     'children' => $manage,
        // ];

        // $data['menus'][] = [
        //     'id'           => 'menu-account',
        //     'name'         => 'Organize and Manage',
        //     'children'     => $projects,
        // ];

        return view ('account/menu', $data);
    }
    //--------------------------------------------------------------------
}
