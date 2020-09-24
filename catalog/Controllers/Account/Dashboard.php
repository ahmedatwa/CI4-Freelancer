<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Dashboard extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('account/dashboard.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => route_to('account/dashboard'),
        ];

        $customerModel = new CustomerModel();

        $data['menus'] = [];

        $start []= [
            'id'       => 'menu-start',
            'icon'     => 'icon-material-outline-dashboard',
            'class'     => 'active',
            'name'     => lang('account/dashboard.text_dashboard'),
            'href'     => route_to('account/dashboard'),
        ];

        $start []= [
            'id'       => 'menu-start',
            'icon'     => 'icon-material-outline-question-answer',
            'class'     => '',
            'name'     => lang('account/dashboard.text_messages'),
            'href'     => route_to('account/messages'),
            'children' => [],
        ];
        $start []= [
            'id'       => 'menu-start',
            'icon'     => 'icon-material-outline-rate-review',
            'class'     => '',
            'name'     => lang('account/dashboard.text_reviews'),
            'href'     => route_to('account/review'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id'           => 'menu-start',
            'name'         => 'Start',
            'children'     => $start,
        ];

        $account []= [
            'id'       => 'menu-account',
            'icon'     => 'icon-material-outline-settings',
            'class'     => '',
            'name'     => lang('account/dashboard.text_settings'),
            'href'     => route_to('account/setting'),
            'children' => [],
        ];

        $account []= [
            'id'       => 'menu-account',
            'icon'     => 'icon-material-outline-power-settings-new',
            'class'     => '',
            'name'     => lang('account/dashboard.text_logout'),
            'href'     => route_to('account/logout'),
            'children' => [],
        ];

        $data['menus'][] = [
            'id'           => 'menu-account',
            'name'         => 'Account',
            'children'     => $account,
        ];
        
        // Projects 
        $projects = [];
        $manage []= [
            'id'       => 'menu-manage',
            'icon'     => 'icon-feather-arrow-right',
            'class'    => '',
            'name'     => lang('account/dashboard.text_manage_projects'),
            'href'     => route_to('manage/projects'),
            'children' => [],
        ];
        $manage [] = [
            'id'       => 'menu-manage',
            'icon'     => 'icon-feather-arrow-right',
            'class'    => '',
            'name'     => lang('account/dashboard.text_manage_bidders'),
            'href'     => route_to('manage/bidders'),
            'children' => [],
        ];
        $manage [] = [
            'id'       => 'menu-manage',
            'icon'     => 'icon-feather-arrow-right',
            'class'    => '',
            'name'     => lang('account/dashboard.text_active_bids'),
            'href'     => route_to('manage/bids'),
            'children' => [],
        ];
        $manage [] = [
            'id'       => 'menu-manage',
            'icon'     => 'icon-feather-arrow-right',
            'class'    => '',
            'name'     => lang('account/dashboard.text_post_project'),
            'href'     => route_to('manage/add'),
            'children' => [],
        ];
        $projects[] = [
            'id'       => 'menu-manage',
            'icon'     => '',
            'name'     => lang('account/dashboard.text_projects'),
            'class'     => '',
            'href'     => '',
            'children' => $manage,
        ];

        $data['menus'][] = [
            'id'           => 'menu-account',
            'name'         => 'Organize and Manage',
            'children'     => $projects,
        ];

        $data['text_dashboard']  = lang('account/dashboard.text_dashboard');
        $data['entry_password']  = lang('account/dashboard.entry_password');
        $data['entry_confirm']   = lang('account/dashboard.entry_confirm');
        $data['heading_title']   = lang('account/dashboard.heading_title');
        $data['text_login']      = sprintf(lang('account/dashboard.text_login'), route_to('account/login'));
        $data['text_dashboard']   = lang('account/dashboard.text_dashboard');
        $data['button_dashboard'] = lang('account/dashboard.button_dashboard');


        $data['action'] = base_url('account/dashboard');

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->request->getPost('confirm')) {
            $data['confirm'] = $this->request->getPost('confirm');
        } else {
            $data['confirm'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $this->template->output('account/dashboard', $data);
    }

    protected function validateForm()
    {
        // Fields Validation Rules
        if (! $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_unique[customer.email]',
                'errors' => [
                    'is_unique' => 'Warning: E-Mail Address is already dashboarded!'
                ],
            ],
            'password' => 'required|min_length[4]',
            'confirm'  => 'required_with[password]|matches[password]',
            ])) {
            $this->session->setFlashData('error_warning', lang('account/dashboard.text_warning'));
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------
}
