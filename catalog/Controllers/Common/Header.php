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

        $data['text_home']      = lang('common/header.text_home');
        $data['text_logout']    = lang('common/header.text_logout');
        $data['text_login']     = lang('common/header.text_login');
        $data['text_register']  = lang('common/header.text_register');
        $data['text_jobs']      = lang('common/header.text_jobs');
        $data['text_projects']  = lang('common/header.text_projects');
        $data['text_dashboard'] = lang('common/header.text_dashboard');
        $data['text_setting']   = lang('common/header.text_setting');
        $data['text_logout']    = lang('common/header.text_logout');

        $data['config_name'] = $this->registry->get('config_name');

        if (is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = base_url() . '/images/' . $this->registry->get('config_logo');
        } else {
            $data['logo'] = '';
        }
        
        $data['home']      = base_url();
        $data['register']  = route_to('account/register');
        $data['login']     = route_to('account/login');
        $data['forgotton'] = route_to('account/forgotten');
        $data['logout']    = route_to('account/logout');
        $data['setting']   = route_to('account/setting');
        $data['dashboard'] = route_to('account/dashboard');
        $data['projects']  = route_to('projects');
        $data['jobs']      = route_to('jobs');

        $data['logged'] = $this->customer->isLogged();
        $data['username'] = $this->customer->getCustomerName();

        if (is_file(DIR_IMAGE . $this->customer->getcustomerImage())) {
            $data['image'] = slash_item('baseURL')  . 'images/' . $this->customer->getcustomerImage();
        } else {
            $data['image'] = base_url()  . '/images/profile.png';
        }


        return view('common/header', $data);
    }


    //--------------------------------------------------------------------
}
