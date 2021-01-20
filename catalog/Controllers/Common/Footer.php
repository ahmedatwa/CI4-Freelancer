<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Catalog\CategoryModel;
use \Catalog\Models\Catalog\Informations;

class Footer extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['informations'] = [];
        
        $informations = new Informations();
        $seo_url = service('seo_url');

        foreach ($informations->getInformations() as $result) {
            if ($result['bottom']) {
                $keyword = $seo_url->getKeywordByQuery('information_id=' . $result['information_id']);

                $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'href'           => ($keyword) ? route_to('information', $result['information_id'], $keyword) : base_url('information/information/view?fid=' . $result['information_id']),
            ];
            }
        }

        // Categories
        $data['categories'] = [];
        $categoryModel = new CategoryModel();

        $filter_data = [
            'start'         => 0,
            'limit'         => 5,
            'parent_id'     => 0,
        ];

        $results = $categoryModel->getCategories($filter_data);
        foreach ($results as $result) {
            $keyword = $seo_url->getKeywordByQuery('category_id=' . $result['category_id']);
            $data['categories'][] = [
            'category_id' => $result['category_id'],
            'name'        => $result['name'],
            'href'        => ($keyword) ? route_to('category', $result['category_id'], $keyword) : base_url('project/project/category?gid=' . $result['category_id']),
         ];
        }

        $data['text_terms']       = lang('common/footer.text_terms');
        $data['text_freelancers'] = lang('common/footer.text_freelancers');
        $data['text_freelancer']  = lang('common/footer.text_freelancer');
        $data['text_categories']  = lang('common/footer.text_categories');
        $data['text_projects']    = lang('common/footer.text_projects');
        $data['text_freelancers'] = lang('common/footer.text_freelancers');
        $data['text_contact']     = lang('common/footer.text_contact');
        $data['text_account']     = lang('common/footer.text_account');
        $data['text_login']       = lang('common/footer.text_login');
        $data['text_register']    = lang('common/footer.text_register');
        
        
        $data['text_footer']      = lang('common/footer.text_footer');
        $data['text_newsletter']  = lang('common/footer.text_newsletter');
        $data['help_newsletter']  = lang('common/footer.help_newsletter');
        $data['entry_email']      = lang('common/footer.entry_email');

        // Social
        $data['facebook']      = $this->registry->get('config_facebook');
        $data['twitter']       = $this->registry->get('config_twitter');
        $data['pintrest']      = $this->registry->get('config_pintrest');
        $data['linkedin']      = $this->registry->get('config_linkedin');
        $data['instagram']     = $this->registry->get('config_instagram');

        $data['contact']     = route_to('contact') ? route_to('contact') : base_url('information/contact');
        $data['login']       = route_to('account_login') ? route_to('account_login') : base_url('account/login');
        $data['register']    = route_to('account_register') ? route_to('account_register') : base_url('account/register');
        $data['blog']        = base_url('blog');
        
        $data['freelancers'] = route_to('freelancers') ? route_to('freelancers') : base_url('freelancer/freelancer');
        $data['projects']    = route_to('projects') ? route_to('projects') : base_url('project/project');
        $data['category']    = route_to('categories') ? route_to('categories') : base_url('project/category');
        $data['add_project'] = route_to('add-project') ? route_to('add-project') : base_url('project/project/add');

        $data['project_added'] = $this->session->getFlashdata('project_added');

        $data['config_name'] = $this->registry->get('config_name');

        $data['logged'] = $this->customer->isLogged();
        $data['customer_id'] = $this->customer->getCustomerId();

        
        if (is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = base_url() . '/images/' . $this->registry->get('config_logo');
        } else {
            $data['logo'] = '';
        }

        if ($this->registry->get('config_customer_online')) {
            $online_model = new \Catalog\Models\Tool\Online();

            if ($this->request->getIPAddress()) {
                $ip = $this->request->getIPAddress();
            } else {
                $ip = '';
            }

            if (current_url()) {
                $url = current_url();
            } else {
                $url = '';
            }

            if (previous_url()) {
                $referer = previous_url();
            } else {
                $referer = '';
            }

            if ($this->customer->getCustomerId()) {
                $customer_id = $this->customer->getCustomerId();
            } else {
                $customer_id = 0;
            }

            $online_model->addOnline($ip, $customer_id, $url, $referer);
        }

        $data['scripts'] = $this->template->getScripts();

        $data['currency'] = view_cell('\Catalog\Controllers\Common\Currency::index');
        $data['language'] = view_cell('\Catalog\Controllers\Common\Language::index');

        return view('common/footer', $data);
    }

    //--------------------------------------------------------------------
}
