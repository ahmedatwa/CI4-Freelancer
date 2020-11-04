<?php namespace Catalog\Controllers\Common;

use Catalog\Models\Account\CustomerModel;

class Home extends \Catalog\Controllers\BaseController
{
	public function index()
	{
		$this->template->setTitle($this->registry->get('config_meta_title'));
		$this->template->setDescription($this->registry->get('config_meta_description'));
		$this->template->setKeywords($this->registry->get('config_meta_keyword'));

        $seoUrl = service('seo_url');
        
    		$data['text_login']           = lang('common/home.text_title');
    		$data['text_freelancers']     = lang('common/home.text_freelancers');
    		$data['text_all_freelancers'] = lang('common/home.text_all_freelancers');
    		$data['text_view_profile']    = lang('common/home.text_view_profile');

            // Freelancers Block
        $filter_data = [
    			'filter_freelancer' => 0,
    			'limit'             => 7,
    			'start'             => 0,
        ];
        
        $data['freelancers'] = [];

        $customerModel = new CustomerModel();

        $results = $customerModel->getCustomers($filter_data);
        $reviewModel = new \Catalog\Models\Account\ReviewModel();

        foreach ($results as $result) {

            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                    $image = $this->resize($result['image'], 110, 110);
                } else {
                    $image = $this->resize('catalog/avatar.jpg', 110, 110);
                }

            $data['freelancers'][] = [
                'image'    => $image,
                'name'     => $result['name'],
                'tag_line' => $result['tag_line'],
                'rate'     => $this->currencyFormat($result['rate']),
                'rating'   => $reviewModel->getAvgReviewByFreelancerId($result['customer_id']),
                'href'     => (route_to('freelancer_profile', $result['customer_id'], $result['name'])) ? route_to('freelancer_profile', $result['customer_id'], $result['name']) : base_url('freelancer/freelancer/view?cid=' . $result['customer_id'])
            ];
        }


        $data['freelancers_all'] = route_to('freelancers') ? route_to('freelancers') : base_url('freelancer/freelancer');
        $data['register']        = route_to('register') ? route_to('register') : base_url('account/register');

		$this->template->output('common/home', $data);

	}

	//--------------------------------------------------------------------

}
