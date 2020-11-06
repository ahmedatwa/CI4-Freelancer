<?php namespace Catalog\Controllers\Module;

use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Account\CustomerModel;

class Freelancer extends \Catalog\Controllers\BaseController
{
    public function index($setting)
    {
		$data['heading_title']        = lang('module/freelancer.heading_title');
		$data['text_freelancers']     = lang('module/freelancer.text_freelancers');
		$data['text_all_freelancers'] = lang('module/freelancer.text_all_freelancers');
		$data['text_view_profile']    = lang('module/freelancer.text_view_profile');
		
        $filter_data = [
			'filter_freelancer' => 0,
			'limit'             => $this->registry->get('module_freelancer_limit'),
			'start'             => 0,
        ];
        
        $data['freelancers'] = [];

        $customerModel = new CustomerModel();

        $results = $customerModel->getCustomers($filter_data);
        $reviewModel = new \Catalog\Models\Account\ReviewModel();
        $total_services = $reviewModel->getTotalJobsByFreelancerId($this->customer->getCustomerId()) ?? null;
        $ontime =  $reviewModel->getOntimeByFreelancerId($this->customer->getCustomerId()) ?? null;

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
                'success'  => @($total_services / $ontime),
                'href'     => (route_to('freelancer_profile', $result['customer_id'], $result['name'])) ? route_to('freelancer_profile', $result['customer_id'], $result['name']) : base_url('freelancer/freelancer/view?cid=' . $result['customer_id'])
            ];
        }


        $data['freelancers_all'] = route_to('freelancers') ? route_to('freelancers') : base_url('freelancer/freelancer');
      
        return view('module/freelancer', $data);
    }
}
