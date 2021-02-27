<?php

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Catalog\InformationModel;
use Catalog\Models\Catalog\CategoryModel;
use Catalog\Models\Account\MessageModel;
use Catalog\Models\Account\BalanceModel;

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

        if ($this->customer->getID()) {
            $customer_id = $this->customer->getID();
        } else {
            $customer_id = 0;
        }
        
        $data['config_name'] = $this->registry->get('config_name');

        if (is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = base_url() . '/images/' . $this->registry->get('config_logo');
        } else {
            $data['logo'] = '';
        }

        if ($this->registry->get('config_global_alert')) {
            $data['global_alert'] = $this->registry->get('config_global_alert');
        } else {
            $data['global_alert'] = '';
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
                    'href'           => ($keyword) ? route_to('information', $keyword) : base_url('information/Information/view?fid=' . $result['information_id']),
                ];
            }
        }
        // Blog
        if ($this->registry->get('blog_extension_status')) {
            $data['blog'] = route_to('blog');
        } else {
            $data['blog'] = '';
        }

        // Local Jobs
        if ($this->registry->get('job_extension_status')) {
            $data['local_jobs'] = route_to('local_jobs');
        } else {
            $data['local_jobs'] = '';
        }

        if ($this->customer->isLogged()) {
            $data['account_dashoard']   = route_to('account_dashboard', $this->customer->getUserName());
            $data['account_project']    = route_to('account_project', $this->customer->getUserName());
            $data['account_inbox']      = route_to('account_inbox', $this->customer->getUserName());
            $data['account_review']     = route_to('account_review', $this->customer->getUserName());
            $data['freelancer_profile'] = route_to('freelancer_profile', $this->customer->getID(), $this->customer->getUserName());
            $data['account_setting']    = route_to('account_setting', $this->customer->getUserName());
            $data['deposit']            = route_to('freelancer_deposit', $this->customer->getUserName());
            $data['withdraw']           = route_to('freelancer_withdraw', $this->customer->getUserName());
            $data['balance']            = route_to('freelancer_balance', $this->customer->getUserName());
            $data['transaction']        = route_to('freelancer_transaction', $this->customer->getUserName()); 
        } 

        $data['home']        = base_url();
        $data['register']    = route_to('account_register');
        $data['login']       = route_to('account_login');
        $data['projects']    = route_to('projects');
        $data['add_project'] = route_to('add-project');
        // finance menu
        $data['markread']    = base_url('account/notifications/markRead');
        $data['logout']      = route_to('account_logout');

        $data['logged'] = $this->customer->isLogged();
        $data['username'] = $this->customer->getUserName();

        if (is_file(DIR_IMAGE . $this->customer->getImage())) {
            $data['image'] = slash_item('baseURL')  . 'images/' . $this->customer->getImage();
        } else {
            $data['image'] = base_url() . '/images/profile.png';
        }

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $data['defaut_color_scheme'] = $this->registry->get('theme_default_color') ?? 'red.css';
        
        $data['langData'] = lang('common/header.list');

        return view('common/header', $data);
    }

    public function getCustomerBalance()
    {
        $json = [];
        
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            if ($this->customer->getID()) {
                $customer_id = $this->customer->getID();
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
