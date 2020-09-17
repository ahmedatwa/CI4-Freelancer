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
        $data['lang']        = $this->locale;
        $data['direction']   = lang($this->locale .'.direction');
        
        $data['base'] = slash_item('baseURL');

        $data['text_home']     = lang('common/header.text_home');
        $data['text_logout']   = lang('common/header.text_logout');
        $data['text_login']    = lang('common/header.text_login');
        $data['text_register'] = lang('common/header.text_register');
        $data['text_jobs']     = lang('common/header.text_jobs');
        $data['text_projects']    = lang('common/header.text_projects');

        $data['name'] = $this->registry->get('config_name');

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
        $data['projects']  = route_to('projects');
        $data['jobs']      = route_to('jobs');



        $data['isLogged'] = $this->customer->isLogged();
        $data['username'] = $this->customer->getCustomerName();


        return view('common/header', $data);
    }


    //--------------------------------------------------------------------
}
