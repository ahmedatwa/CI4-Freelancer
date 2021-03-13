<?php 

namespace Catalog\Controllers\Common;

use \Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\CategoryModel;
use Catalog\Models\Catalog\InformationModel;
use Catalog\Models\Tool\OnlineModel;

class Footer extends BaseController
{
    public function index()
    {
        $data['informations'] = [];
        
        $informations = new InformationModel();

        foreach ($informations->getInformations() as $result) {
            if ($result['bottom']) {
                $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'href'           => ($result['keyword']) ? route_to('information', $result['keyword']) : base_url('information/information/view?fid=' . $result['information_id']),
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
            $data['categories'][] = [
            'category_id' => $result['category_id'],
            'name'        => $result['name'],
            'href'        => ($result['keyword']) ? route_to('category', $result['category_id'], $result['keyword']) : base_url('project/project/category?gid=' . $result['category_id']),
         ];
        }

        $data['text_footer'] = sprintf(lang('common/footer.list.text_footer'), $this->registry->get('config_name'));
        // Social
        $data['social_networks'] = json_decode($this->registry->get('config_social_networks'), true);

        $data['contact']     = route_to('contact') ?? base_url('information/contact');
        $data['login']       = route_to('account_login');
        $data['register']    = route_to('account_register');

        if ($this->customer->isLogged()) {
            $data['setting'] = route_to('account_setting', $this->customer->getUserName());
        }

        $data['blog']        = route_to('blog');
        $data['freelancers'] = route_to('freelancers');
        $data['projects']    = route_to('projects_all');
        $data['category']    = route_to('categories');
        $data['add_project'] = route_to('add-project');

        $data['project_added'] = $this->session->getFlashdata('project_added');

        $data['config_name'] = $this->registry->get('config_name');

        $data['logged'] = $this->customer->isLogged();
        $data['customer_id'] = $this->customer->getID();

        
        if (is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = base_url() . '/images/' . $this->registry->get('config_logo');
        } else {
            $data['logo'] = '';
        }

        if ($this->registry->get('config_customer_online')) {
            $online_model = new OnlineModel();
            $agent = $this->request->getUserAgent();

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

            if ($agent->isReferral()) {
                $referer = $agent->getReferrer();
            } else {
                $referer = previous_url();
            }

            if ($this->customer->getID()) {
                $customer_id = $this->customer->getID();
            } else {
                $customer_id = 0;
            }

            $online_model->addOnline($ip, $customer_id, $url, $referer);
        }

        // Chat Widget Code 
        if ($this->registry->get('config_chat_widget')) {
            $data['config_chat_widget'] = $this->registry->get('config_chat_widget');
        } else {
            $data['config_chat_widget'] = '';
        }

        $data['scripts'] = $this->template->getScripts();

        $data['currency'] = view_cell('\Catalog\Controllers\Common\Currency::index');
        $data['language'] = view_cell('\Catalog\Controllers\Common\Language::index');

        $data['langData'] = lang('common/footer.list');

        return view('common/footer', $data);
    }

    //--------------------------------------------------------------------
}
