<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Account\CustomerModel;
use \Catalog\Models\Catalog\Informations;
use \Catalog\Models\Catalog\CategoryModel;
use \Catalog\Models\Account\MessageModel;
use \Catalog\Models\Freelancer\BalanceModel;

class Header extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['title']       = $this->template->getTitle();
        $data['description'] = $this->template->getDescription();
        $data['keywords']    = $this->template->getKeywords();
        $data['links']       = $this->template->getLinks();
        $data['styles']      = $this->template->getStyles();
        $data['scripts']     = $this->template->getScripts();
        $data['lang']        = $this->locale;
        $data['direction']   = lang($this->locale . '.direction');
        
        $data['base'] = slash_item('baseURL');

        $data['text_home']        = lang('common/header.text_home');
        $data['text_logout']      = lang('common/header.text_logout');
        $data['text_login']       = lang('common/header.text_login');
        $data['text_register']    = lang('common/header.text_register');
        $data['text_projects']    = lang('common/header.text_projects');
        $data['text_dashboard']   = lang('common/header.text_dashboard');
        $data['text_setting']     = lang('common/header.text_setting');
        $data['text_profile']     = lang('common/header.text_profile');
        $data['text_add_project'] = lang('common/header.text_add_project');

        $balanceModel = new BalanceModel();

        helper('number');

        if ($this->customer->getCustomerID()) {
           $customer_id = $this->customer->getCustomerID();
        } else {
            $customer_id = 0;
        }

        $customer_balance = $balanceModel->getBalanceByCustomerID($customer_id);

        $data['text_finance']              = lang('common/header.text_finance');
        $data['text_account']              = lang('common/header.text_account');
        $data['text_balances']             = lang('common/header.text_balances');
        $data['customer_balance']          = number_to_currency($customer_balance, $this->session->get('customer_currency') ?? $this->registry->get('config_currency'));
        $data['text_deposite_funds']       = lang('common/header.text_deposite_funds');
        $data['text_withdraw_funds']       = lang('common/header.text_withdraw_funds');
        $data['text_transactions_history'] = lang('common/header.text_transactions_history');

        $data['config_name'] = $this->registry->get('config_name');

        if (is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = base_url() . '/images/' . $this->registry->get('config_logo');
        } else {
            $data['logo'] = '';
        }
        
        $data['home']        = base_url();
        $data['register']    = route_to('account_register') ? route_to('account_register') : base_url('account/register');
        $data['login']       = route_to('account_login') ? route_to('account_login') : base_url('account/login');
        $data['forgotton']   = route_to('account_forgotten') ? route_to('account_forgotten') : base_url('account/forgotten');
        $data['projects']    = route_to('projects') ? route_to('projects') : base_url('project/project');
        $data['add_project'] = route_to('add-project') ? route_to('add-project') : base_url('project/project/add');
        $data['logout']      = route_to('account_logout') ? route_to('account_logout') : base_url('account/logout');

        if ($this->session->get('customer_id')) {
            $data['logout']      = route_to('account_logout') ? route_to('account_logout') : base_url('account/logout');
            $data['profile']     = route_to('freelancer_profile', $this->session->get('customer_id'), $this->session->get('username')) ? route_to('freelancer_profile', $this->session->get('customer_id'), $this->session->get('username')) : base_url('freelancer/freelancer?cid=' . $this->session->get('customer_id'));
            $data['setting']     = route_to('account_setting') ? route_to('account_setting') : base_url('account/setting?cid=' . $this->session->get('customer_id'));
            $data['dashboard']   = route_to('account_dashboard') ? route_to('account_dashboard') : base_url('account/dashboard?cid=' . $this->session->get('customer_id'));
        }


        $data['informations'] = [];
        
        $informations = new Informations();
        $seo_url = service('seo_url');

        foreach ($informations->getInformations() as $result) {
            if ($result['bottom'] == 0) {
                $keyword = $seo_url->getKeywordByQuery('information_id=' . $result['information_id']);
                $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'href'           => ($keyword) ? route_to('information', $result['information_id'], $keyword) : base_url('information/Information?fid=' . $result['information_id']),
            ];
            }
        }

        $data['categories'] = [];

        $categoryModel = new CategoryModel();

        $filter_data = [
            'limit' => 4,
            'start' => 0,
        ];
        
        $results = $categoryModel->getCategories($filter_data);

        foreach ($results as $result) {
            $data['categories'][] = [
                'name'     => $result['name'],
                'icon'     => $result['icon'],
                'children' => $categoryModel->getChildrenByCategoryId($result['category_id']),
                'href'        => (route_to('projects') . '?gid=' . $result['category_id']) ? route_to('projects') . '?gid=' . $result['category_id'] : base_url('project/project?gid=' . $result['category_id']),
            ];
        }

        // Blog
        if ($this->registry->get('blog_extension_status')) {
            $data['text_blog'] = lang('common/header.text_blog');
            $data['blog'] = route_to('blog') ? route_to('blog') : base_url('extension/blog/blog');
        } else {
            $data['text_blog'] = '';
            $data['blog'] = '';
        }

        // Local Jobs
        if ($this->registry->get('job_extension_status')) {
            $data['text_job'] = lang('common/header.text_job');
            $data['local_jobs'] = route_to('local_jobs') ? route_to('local_jobs') : base_url('extension/job/job');
        } else {
            $data['text_job'] = '';
            $data['local_jobs'] = '';
        }
        // customer Menu
        $data['text_dashboard']   = lang('account/menu.text_dashboard');
        $data['text_my_projects'] = lang('account/menu.text_my_projects');

        $data['dashoard']         = route_to('account_dashboard') ? route_to('account_dashboard') : base_url('account/dashboard');
        $data['account_project']  = route_to('account_project') ? route_to('account_project') : base_url('account/project');
        
        $data['text_messages']    = lang('account/menu.text_messages');
        $data['account_message']  = route_to('account_message') ? route_to('account_message') : base_url('account/message');
        $data['text_reviews']     = lang('account/menu.text_reviews');
        $data['account_review']   = route_to('account_review') ? route_to('account_review') : base_url('account/review');
        // finance menu
        $data['deposit']          = route_to('freelancer_deposit') ? route_to('freelancer_deposit') : base_url('freelancer/deposit');
        $data['withdraw']         = route_to('freelancer_withdraw') ? route_to('freelancer_withdraw') : base_url('freelancer/withdraw');
        $data['balance']          = route_to('freelancer_balance') ? route_to('freelancer_balance') : base_url('freelancer/balance');
        $data['transaction']      = route_to('freelancer_transaction') ? route_to('freelancer_transaction') : base_url('account/review');


        $data['logged'] = $this->customer->isLogged();
        $data['username'] = $this->session->get('username');

        if (is_file(DIR_IMAGE . $this->customer->getcustomerImage())) {
            $data['image'] = slash_item('baseURL')  . 'images/' . $this->customer->getcustomerImage();
        } elseif ($this->session->get('customer_image')) {
            $data['image'] = $this->session->get('customer_image');
        } else {
            $data['image'] = base_url() . '/images/profile.png';
        }

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $data['defaut_color_scheme'] = $this->registry->get('theme_default_color') ?? 'red.css';
        $data['all_messages']        = route_to('account_messages') ? route_to('account_messages') : base_url('account/message');

        // Logged Menu
        $data['text_dashboard']   = lang('account/menu.text_dashboard');
        $data['text_my_projects'] = lang('account/menu.text_my_projects');
        $data['text_messages']    = lang('account/menu.text_messages');
        $data['text_reviews']     = lang('account/menu.text_reviews');
        
        $data['dashboard']        = route_to('account_dashboard') ? route_to('account_dashboard') : base_url('account/dashboard');
        $data['my_projects']      = route_to('account_project') ? route_to('account_project') : base_url('account/project');
        $data['messages']         = route_to('account_message') ? route_to('account_message') : base_url('account/message');
        $data['reviews']          = route_to('account_review') ? route_to('account_review') : base_url('account/review');

        return view('common/header', $data);
    }

    public function getMessages()
    {
        $json = [];

        if ($this->session->get('customer_id')) {
            if ($this->request->getVar('view')) {
                $viewed = $this->request->getVar('view');
            } else {
                $viewed = '';
            }

            $messageModel = new MessageModel();

            $results = $messageModel->getMessageByCustomerId($viewed, $this->session->get('customer_id'));

            helper('text');

            foreach ($results as $result) {
                $json[] = [
                'thread_id'   => $result['thread_id'],
                'message_id'  => $result['message_id'],
                'receiver_id' => $result['receiver_id'],
                'sender_id'   => $result['sender_id'],
                'name'        => $result['name'],
                'image'       => ($result['image']) ? $this->resize($result['image'], 42, 42) : $this->resize('catalog/avatar.jpg', 42, 42),
                'message'     => word_limiter(json_decode($result['message'], true)['text'], 10),
                'date_added'  => $this->dateDifference($result['date_added']),
                'count'       => $result['total'],
                'href'        => base_url('account/inbox?message_id=' . $result['message_id']),

            ];
            }
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
