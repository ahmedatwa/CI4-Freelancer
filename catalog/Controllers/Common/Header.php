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
        $data['text_add_project'] = lang('common/header.text_add_project');

        $data['config_name'] = $this->registry->get('config_name');

        if (is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = base_url() . '/images/' . $this->registry->get('config_logo');
        } else {
            $data['logo'] = '';
        }
        
        $data['home']        = base_url();
        $data['register']    = base_url('account/register');
        $data['login']       = base_url('account/login');
        $data['forgotton']   = base_url('account/forgotten');
        $data['logout']      = base_url('account/logout');
        $data['setting']     = base_url('account/setting?cid=' . $this->customer->getCustomerId());
        $data['dashboard']   = base_url('account/dashboard?cid=' . $this->customer->getCustomerId());
        $data['projects']    = base_url('project/category');
        $data['add_project'] = base_url('project/project/add');

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

        if ($this->registry->get('blog_extension_status')) {
            $data['text_blog'] = lang('common/header.text_blog');
            $data['blog'] = route_to('blog');
        } else {
            $data['text_blog'] = '';
            $data['blog'] = '';

        }

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
