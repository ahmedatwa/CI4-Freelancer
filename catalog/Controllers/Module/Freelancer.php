<?php 

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\ProjectModel;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Account\ReviewModel;

class Freelancer extends BaseController
{
    public function index($setting)
    {		
        $filter_data = [
			'filter_freelancer' => 100,
			'start'             => 0,
            'limit'             => $this->registry->get('module_freelancer_limit'),
        ];
        
        $data['freelancers'] = [];

        $customerModel = new CustomerModel();
        $reviewModel   = new ReviewModel();

        $results        = $customerModel->getCustomers($filter_data);
        $total_services = $reviewModel->getTotalJobsByFreelancerId($this->customer->getCustomerId()) ?? null;
        $ontime         =  $reviewModel->getOntimeByFreelancerId($this->customer->getCustomerId()) ?? null;

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
                'success'  => ($ontime) ? ($total_services / $ontime) : '0',
                'href'     => (route_to('freelancer_profile', $result['customer_id'], $result['username'])) ? route_to('freelancer_profile', $result['customer_id'], $result['username']) : base_url('freelancer/freelancer/view?cid=' . $result['customer_id'])
            ];
        }


        $data['freelancers_all'] = route_to('freelancers') ? route_to('freelancers') : base_url('freelancer/freelancer');
      
        $data['langData'] = lang('module/freelancer.list');

        return view('module/freelancer', $data);
    }
    // -------------------------------------------------------
}
