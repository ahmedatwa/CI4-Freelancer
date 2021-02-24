<?php 

namespace Catalog\Controllers\Common;

use \Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Catalog\InformationModel;
use Catalog\Models\Catalog\CategoryModel;
use Catalog\Models\Account\MessageModel;
use Catalog\Models\Freelancer\BalanceModel;

class Header extends BaseController
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

        $balanceModel = new BalanceModel();

        if ($this->customer->getCustomerID()) {
            $customer_id = $this->customer->getCustomerID();
        } else {
            $customer_id = 0;
        }

        $data['customer_balance'] = base_url('common/header/getCustomerBalace');
        
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
        $data['markread']    = base_url('account/notifications/markRead');

        if ($this->registry->get('config_global_alert')) {
            $data['global_alert'] = $this->registry->get('config_global_alert');
        } else {
            $data['global_alert'] = '';
        }

        if ($this->session->get('customer_id')) {
            $data['logout']      = route_to('account_logout') ? route_to('account_logout') : base_url('account/logout');
            $data['profile']     = route_to('freelancer_profile', $this->session->get('customer_id'), $this->session->get('username')) ? route_to('freelancer_profile', $this->session->get('customer_id'), $this->session->get('username')) : base_url('freelancer/freelancer?cid=' . $this->session->get('customer_id'));
            $data['setting']     = route_to('account_setting') ? route_to('account_setting') : base_url('account/setting?cid=' . $this->session->get('customer_id'));
            $data['dashboard']   = route_to('account_dashboard') ? route_to('account_dashboard') : base_url('account/dashboard?cid=' . $this->session->get('customer_id'));
        }


        $data['informations'] = [];
        
        $informations = new InformationModel();
        $seo_url = service('seo_url');

        foreach ($informations->getInformations() as $result) {
            if ($result['bottom'] == 0) {
                $keyword = $seo_url->getKeywordByQuery('information_id=' . $result['information_id']);
                $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'href'           => ($keyword) ? route_to('information', $result['information_id'], $keyword) : base_url('information/Information/view?fid=' . $result['information_id']),
            ];
            }
        }

        // Blog
        if ($this->registry->get('blog_extension_status')) {
            $data['blog'] = route_to('blog') ? route_to('blog') : base_url('extension/blog/blog');
        } else {
            $data['blog'] = '';
        }

        // Local Jobs
        if ($this->registry->get('job_extension_status')) {
            $data['local_jobs'] = route_to('local_jobs') ? route_to('local_jobs') : base_url('extension/job/job');
        } else {
            $data['local_jobs'] = '';
        }

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
        $data['all_messages']        = route_to('account_project');
        
        $data['dashboard']        = route_to('account_dashboard') ? route_to('account_dashboard') : base_url('account/dashboard');
        $data['my_projects']      = route_to('account_project') ? route_to('account_project') : base_url('account/project');
        $data['messages']         = route_to('account_message') ? route_to('account_message') : base_url('account/message');
        $data['reviews']          = route_to('account_review') ? route_to('account_review') : base_url('account/review');
        
        $data['langData'] = lang('common/header.list');

        return view('common/header', $data);
    }

    public function getCustomerBalance()
    {
        $json = [];
        
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            if ($this->customer->getCustomerID()) {
                $customer_id = $this->customer->getCustomerID();
            } else {
                $customer_id = 0;
            }

            helper('number');

            if ($customer_id) {
                $balanceModel = new BalanceModel();

                $balance = $balanceModel->getBalanceByCustomerID($customer_id);

                $currency = empty($balance['currency']) ? $this->registry->get('config_currency') : $balance['currency'];

                $json['total'] = number_to_currency($balance['total'], $currency, $this->locale, 2);
            } else {
                $json['total'] = number_to_currency('0.00', $currency, $this->locale, 2);
            }
        }

        return $this->response->setJSON($json);
    }

    public function getMessages()
    {
        $json = [];

        if ($this->session->get('customer_id')) {
            $messageModel = new MessageModel();

            $results = $messageModel->getMessageByCustomerId(0, $this->session->get('customer_id'));

            helper('text');

            foreach ($results as $result) {
                $json[] = [
                'thread_id'   => $result['thread_id'],
                'message_id'  => $result['message_id'],
                'receiver_id' => $result['receiver_id'],
                'project_id'  => $result['project_id'],
                'sender_id'   => $result['sender_id'],
                'name'        => $result['name'],
                'image'       => ($result['image']) ? $this->resize($result['image'], 42, 42) : $this->resize('catalog/avatar.jpg', 42, 42),
                'message'     => word_limiter($result['message']),
                'date_added'  => $this->dateDifference($result['date_added']),
                'count'       => $result['total'],

            ];
            }
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
