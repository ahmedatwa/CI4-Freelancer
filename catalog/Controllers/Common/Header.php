<?php namespace Catalog\Controllers\Common;

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
        $data['direction']   = lang($this->locale .'.direction');
        
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

        $data['text_finance']              = lang('common/header.text_finance');
        $data['text_account']              = lang('common/header.text_account');
        $data['text_balances']             = lang('common/header.text_balances');
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

        if ($this->session->get('customer_id')) {
            $data['logout']      = route_to('account_logout') ? route_to('account_logout') : base_url('account/logout');
            $data['profile']     = route_to('freelancer_profile', $this->session->get('customer_id'), $this->session->get('username')) ? route_to('freelancer_profile', $this->session->get('customer_id'), $this->session->get('username')) : base_url('freelancer/freelancer?cid=' . $this->session->get('customer_id'));
            $data['setting']     = route_to('account_setting') ? route_to('account_setting') : base_url('account/setting?cid=' . $this->session->get('customer_id'));
            $data['dashboard']   = route_to('account_dashboard') ? route_to('account_dashboard') : base_url('account/dashboard?cid=' . $this->session->get('customer_id'));

        }


        $data['informations'] = [];
        
        $informations = new \Catalog\Models\Catalog\Informations();
        $seo_url = service('seo_url');

        foreach ($informations->getInformations(4) as $result) {
            if ($result['bottom'] == 0) {
                $keyword = $seo_url->getKeywordByQuery('information_id=' . $result['information_id']);
                $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'href'           => ($keyword) ? route_to('information', $keyword) : base_url('information/Information?fid=' . $result['information_id']),
            ];
            }
        }

        // Blog
        if ($this->registry->get('blog_extension_status')) {
            $data['text_blog'] = lang('common/header.text_blog');
            $data['blog'] = route_to('blog') ? route_to('blog') : base_url('extension/blog/blog');
        } else {
            $data['text_blog'] = '';
            $data['blog'] = '';
        }

        $data['logged'] = $this->customer->isLogged();
        $data['username'] = $this->session->get('username');

        if (is_file(DIR_IMAGE . $this->customer->getcustomerImage())) {
            $data['image'] = slash_item('baseURL')  . 'images/' . $this->customer->getcustomerImage();
        } elseif(!empty($this->customer->getcustomerImage())) {
            $data['image'] = $this->customer->getcustomerImage();
        } else {    
            $data['image'] = base_url()  . '/images/profile.png';
        }

        $data['defaut_color_scheme'] = $this->registry->get('theme_default_color') ?? 'red.css';
        $data['all_messages'] = route_to('account_messages') ? route_to('account_messages') : base_url('account/message');


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

        $messageModel = new \Catalog\Models\Account\MessageModel();

        $results = $messageModel->getMessageByCustomerId($viewed, $this->session->get('customer_id'));

        helper('text');

        foreach ($results as $result) {
            $json[] = [
                'message_id'  => $result['message_id'],
                'customer_id' => $result['customer_id'],
                'name'        => $result['name'],
                'image'       => ($result['image']) ? $this->resize($result['image'], 42, 42) : $this->resize('catalog/avatar.jpg', 42, 42),
                'message'     => word_limiter($result['message'], 10),
                'date_added'  => $this->dateDifference($result['date_added']),
                'count'       => $result['total'],
                'href'        => base_url('account/message?message_id=' . $result['message_id']),

            ];
        }
            
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
