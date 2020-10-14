<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Menu extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['menus'] = [];

        $projects = [];
        $data['menus'][] = [
            'id'       => 'menu-manage',
            'icon'     => 'icon-feather-arrow-right',
            'class'    => '',
            'name'     => lang('account/menu.text_my_projects'),
            'href'     => base_url('account/project?cid=' . $this->customer->getCustomerId()),
            'children' => [],
        ];

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
            'href'     => base_url('account/message?cid=' . $this->customer->getCustomerId()),
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

        return view ('account/menu', $data);
    }
    //--------------------------------------------------------------------
}
