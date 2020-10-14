<?php namespace Catalog\Controllers\Common;

class Footer extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['informations'] = [];
        
        $informations = new \Catalog\Models\Catalog\Informations();
        $seo_url = service('seo_url');

        foreach ($informations->getInformations(4) as $result) {

            $keyword = $seo_url->getKeywordByQuery('information_id=' . $result['information_id']);

               $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'href'           => ($keyword) ? route_to('information', $keyword) : base_url('information/information?fid=' . $result['information_id']),
            ];
        }

        // Categories
        $data['categories'] = [];
        $categoryModel = new \Catalog\Models\Catalog\CategoryModel();

        $filter_data = [
            'start'         => 0,
            'limit'         => 4,
            'parent_id'     => 0,
        ];

        $results = $categoryModel->getCategories($filter_data);
        foreach ($results as $result) {
            $keyword = $seo_url->getKeywordByQuery('category_id=' . $result['category_id']);
            $data['categories'][] = [
            'category_id' => $result['category_id'],
            'name'        => $result['name'],
            'href'        => ($keyword) ? route_to('categories', $keyword) : base_url('project/category?gid=' . $result['category_id']),
         ];
        }

        $data['text_links']              = lang('common/footer.text_links');
        $data['text_for_freelancers']    = lang('common/footer.text_for_freelancers');
        $data['text_for_employer']       = lang('common/footer.text_for_employer');
        $data['text_browse_projects']    = lang('common/footer.text_browse_projects');
        $data['text_browse_freelancers'] = lang('common/footer.text_browse_freelancers');
        $data['text_post_job']           = lang('common/footer.text_post_job');
        $data['text_post_project']       = lang('common/footer.text_post_project');
        $data['text_footer']             = lang('common/footer.text_footer');
        $data['text_newsletter']         = lang('common/footer.text_newsletter');
        $data['help_newsletter']         = lang('common/footer.help_newsletter');
        $data['entry_email']             = lang('common/footer.entry_email');

        $data['contact']     = base_url('information/contact');
        $data['blog']        = base_url('blog');
        $data['freelancers'] = route_to('freelancers') ? route_to('freelancers') : base_url('freelancer/freelancer');
        $data['projects']    = base_url('project/category');
        $data['add_project'] = base_url('project/project/add');
        $data['add_job']     = base_url('add_job');

        $data['project_added'] = $this->session->getFlashdata('project_added');

        $data['config_name'] = $this->registry->get('config_name');
        
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

        $data['new_project_alert'] = $this->session->getFlashdata('new_project_add');

        $data['currency'] = view_cell('\Catalog\Controllers\Common\Currency::index');

        return view('common/footer', $data);
    }


    //--------------------------------------------------------------------
}
