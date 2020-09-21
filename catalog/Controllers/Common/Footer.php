<?php namespace Catalog\Controllers\Common;

class Footer extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['informations'] = [];
        
        $informations = new \Catalog\Models\Catalog\Informations();

        foreach ($informations->getInformations(4) as $result) {
            $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'href'           => route_to('information', getKeywordByQuery('information_id=' . $result['information_id'])),
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
            $data['categories'][] = [
            'category_id' => $result['category_id'],
            'name'        => $result['name'],
            'href'        => route_to('project/category', getKeywordByQuery('category_id=' . $result['category_id'])),
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

        $data['contact']     = route_to('information/contact');
        $data['blog']        = route_to('blog');
        $data['freelancers'] = route_to('freelancers');
        $data['projects']    = route_to('projects');
        $data['add_project'] = route_to('project/add');
        $data['add_job']     = route_to('add_job');

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


        return view('common/footer', $data);
    }


    //--------------------------------------------------------------------
}
