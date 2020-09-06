<?php namespace Catalog\Controllers\Common;

class Footer extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['informations'] = array();
        
        $informations = new \Catalog\Models\Catalog\Informations();

        foreach ($informations->getInformations(4) as $result) {
            $data['informations'][] = [
                'information_id' => $result['information_id'],
                'name'           => $result['title'],
                'href'           => base_url('information/information?information_id=' . $result['information_id']),//base_url(getSeoUrlKeywordByQuery('information_id=' . $result['information_id'])),
            ];
        }

        // Categories
        $data['categories'] = array();
        $categories_model = new \Catalog\Models\catalog\Categories();

        $filter_data = [
            'start'         => 0,
            'limit'         => 4,
            'parent_id'     => 0,
        ];

        $results = $categories_model->getCategories($filter_data);
        foreach ($results as $result) {
            $data['categories'][] = [
            'category_id' => $result['category_id'],
            'name'        => $result['name'],
            'href'        => base_url('project/category?category_id=' . $result['category_id']),//base_url('project/category/' . getSeoUrlKeywordByQuery('category_id=' . $result['category_id'])),
            ];
        }

        $data['text_quick_links'] = lang('common/footer.text_quick_links');
        $data['text_categories']  = lang('common/footer.text_categories');
        $data['text_in_touch']    = lang('common/footer.text_in_touch');
        $data['text_terms']       = lang('common/footer.text_terms');
        $data['text_privacy']     = lang('common/footer.text_privacy');
        $data['text_sitemap']     = lang('common/footer.text_sitemap');
        $data['text_account']     = lang('common/footer.text_account');
        $data['text_newsletter']  = lang('common/footer.text_newsletter');
        $data['text_contact']     = lang('common/footer.text_contact');
        $data['text_email']       = lang('common/footer.text_email');
        $data['text_footer']      = lang('common/footer.text_footer');
        $data['text_blog']        = lang('common/footer.text_blog');
        $data['text_facebook']    = lang('common/footer.text_facebook');
        $data['text_google']      = lang('common/footer.text_google');
        $data['text_linkedin']    = lang('common/footer.text_linkedin');
        $data['text_forgotton']   = lang('common/footer.text_forgotton');
        $data['text_no_account']  = lang('common/footer.text_no_account');
        $data['text_login']       = lang('common/footer.text_login');
        $data['text_register']    = lang('common/footer.text_register');


        $data['entry_email']    = lang('common/footer.entry_email');
        $data['entry_password'] = lang('common/footer.entry_password');
        $data['entry_confirm']  = lang('common/footer.entry_confirm');

        $data['button_login']    = lang('common/footer.button_login');
        $data['button_register'] = lang('common/footer.button_register');


        $data['contact'] = base_url('information/contact');
        $data['blog']    = base_url('blog');

        if (getSettingValue('config_customer_online')) {

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
