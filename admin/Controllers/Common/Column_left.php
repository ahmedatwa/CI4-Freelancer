<?php namespace Admin\Controllers\Common;

class Column_left extends \Admin\Controllers\BaseController
{
    public function index()
    {

        $data['dashboard'] = base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token'));
        $data['text_navigation'] = lang('common/column_left.text_navigation');

        $data['menus'][]= [
            'id'       => 'menu-dashboard',
            'icon'     => 'fas fa-tachometer-alt',
            'name'     => lang('common/column_left.text_dashboard'),
            'href'     => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        // Catalog Level 1
        $catalog = [];
        $catalog[] = [
            'id'       => 'menu-catalog',
            'name'     => lang('common/column_left.text_categories'),
            'href'     => base_url('index.php/catalog/category?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $catalog[] = [
            'id'       => 'menu-catalog',
            'name'     => lang('common/column_left.text_projects'),
            'href'     => base_url('index.php/catalog/project?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $catalog[] = [
            'id'       => 'menu-catalog',
            'name'     => lang('common/column_left.text_reviews'),
            'href'     => base_url('index.php/catalog/review?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $catalog[] = [
            'id'       => 'menu-catalog',
            'name'     => lang('common/column_left.text_information'),
            'href'     => base_url('index.php/catalog/information?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $data['menus'][] = [
            'id'           => 'menu-catalog',
            'icon'         => 'fas fa-tags',
            'name'         => lang('common/column_left.text_catalog'),
            'children'     => $catalog,
        ];
        // Extensions Level 1
        $extensions = [];
        $extensions[] = [
            'id'       => 'menu-extensions',
            'name'     => lang('common/column_left.text_extensions'),
            'href'     => base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $extensions[] = [
            'id'       => 'menu-extensions',
            'name'     => lang('common/column_left.text_modules'),
            'href'     => base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $extensions[] = [
            'id'       => 'menu-extensions',
            'name'     => lang('common/column_left.text_events'),
            'href'     => base_url('index.php/setting/event?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $data['menus'][] = [
            'id'           => 'menu-extensions',
            'icon'         => 'fas fa-puzzle-piece',
            'name'         => lang('common/column_left.text_extensions'),
            'children'     => $extensions,
        ];
        // Design Level 1
        $design = [];
        $design[] = [
            'id'       => 'menu-design',
            'name'         => lang('common/column_left.text_layouts'),
            'href'         => base_url('index.php/design/layout?user_token=' . $this->request->getVar('user_token')),
            'children'     => [],
        ];
        $design[] = [
            'id'       => 'menu-design',
            'name'     => lang('common/column_left.text_banner'),
            'href'     => base_url('index.php/design/banner?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $design[] = [
            'id'       => 'menu-design',
            'name'     => lang('common/column_left.text_seo_url'),
            'href'     => base_url('index.php/design/seo_url?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $data['menus'][] = [
            'id'           => 'menu-design',
            'icon'         => 'fas fa-desktop',
            'name'         => lang('common/column_left.text_design'),
            'children'     => $design,
        ];
        // customers Level 1
        $customers = [];
        $customers[] = [
            'id'       => 'menu-customers',
            'name'         => lang('common/column_left.text_customers'),
            'href'         => base_url('index.php/customer/customer?user_token=' . $this->request->getVar('user_token')),
            'children'     => [],
        ];
        $customers[] = [
            'id'       => 'menu-customers',
            'name'     => lang('common/column_left.text_customers_group'),
            'href'     => base_url('index.php/customer/customer_group?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $data['menus'][] = [
            'id'           => 'menu-customers',
            'icon'         => 'fas fa-users',
            'name'         => lang('common/column_left.text_customers'),
            'children'     => $customers,
        ];
        // finance Level 1
        $finance = [];
        $finance[] = [
            'id'       => 'menu-finance',
            'name'     => lang('common/column_left.text_disputes'),
            'href'     => base_url('index.php/finance/dispute?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $finance[] = [
            'id'       => 'menu-finance',
            'name'     => lang('common/column_left.text_withdrawal'),
            'href'     => base_url('index.php/finance/withdrawal?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $data['menus'][] = [
            'id'           => 'menu-finance',
            'icon'         => 'fas fa-hand-holding-usd',
            'name'         => lang('common/column_left.text_finance'),
            'children'     => $finance,
        ];
        // system
        $system = [];
        $system[] = [
            'id'       => 'menu-system',
            'name'     => lang('common/column_left.text_setting'),
            'href'     => base_url('index.php/setting/setting?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        // Users
        $users = [];
        $users[] = [
            'id'       => 'menu-users',
            'name'     => lang('common/column_left.text_users'),
            'href'     => base_url('index.php/user/user?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $users[] = [
            'id'       => 'menu-users',
            'name'     => lang('common/column_left.text_user_group'),
            'href'     => base_url('index.php/user/user_group?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $system[] = [
            'id'       => 'menu-users',
            'name'     => lang('common/column_left.text_users'),
            'href'     => '',
            'children' => $users,
        ];
        // localisation Level 2
        $localisation[] = [
            'id'       => 'menu-localisation',
            'name'     => lang('common/column_left.text_language'),
            'href'     => base_url('index.php/localisation/language?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $localisation[] = [
            'id'       => 'menu-localisation',
            'name'     => lang('common/column_left.text_project_status'),
            'href'     => base_url('index.php/localisation/project_status?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $localisation[] = [
            'id'       => 'menu-localisation',
            'name'     => lang('common/column_left.text_currency'),
            'href'     => base_url('index.php/localisation/currency?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        // level 3
        $disputes = [];
        $disputes[] = [
            'id'       => 'menu-disputes',
            'name'     => lang('common/column_left.text_dispute_action'),
            'href'     => base_url('index.php/localisation/dispute_action?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $disputes[] = [
            'id'       => 'menu-disputes',
            'name'     => lang('common/column_left.text_dispute_reason'),
            'href'     => base_url('index.php/localisation/dispute_reason?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $disputes[] = [
            'id'       => 'menu-disputes',
            'name'     => lang('common/column_left.text_dispute_status'),
            'href'     => base_url('index.php/localisation/dispute_status?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $localisation[] = [
            'id'       => 'menu-disputes',
            'name'     => lang('common/column_left.text_disputes'),
            'href'     => base_url('index.php/localisation/disputes?user_token=' . $this->request->getVar('user_token')),
            'children' => $disputes,
        ];
        $system[] = [
            'id'       => 'menu-localisation',
            'name'     => lang('common/column_left.text_localisation'),
            'href'     => '',
            'children' => $localisation,
        ];

        // Tools Level 1
        $tools = [];
        $tools[] = [
            'id'       => 'menu-tools',
            'name'     => lang('common/column_left.text_mail'),
            'href'     => base_url('index.php/tool/mail?user_token=' . $this->request->getVar('user_token')),
            'children' => [],
        ];
        $tools[] = [
            'id'           => 'menu-tools',
            'icon'         => 'fas fa-angle-double-right',
            'name'         => lang('common/column_left.text_error_logs'),
            'href'         => base_url('index.php/tool/log?user_token=' . $this->request->getVar('user_token')),
            'children'     => [],
        ];
        $system[] = [
            'id'       => 'menu-tools',
            'name'     => lang('common/column_left.text_tools'),
            'href'     => base_url('index.php/tool/mail?user_token=' . $this->request->getVar('user_token')),
            'children' => $tools,
        ];

        $data['menus'][] = [
            'id'           => 'menu-system',
            'icon'         => 'fas fa-cogs',
            'name'         => lang('common/column_left.text_system'),
            'children'     => $system,
        ];
        

        return view('common/column_left', $data);
    }


    //--------------------------------------------------------------------
}
