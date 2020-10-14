<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Catalog\ProjectModel;
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
		$data['text_apply']           = lang('common/home.text_apply');
		$data['text_browse']          = lang('common/home.text_browse');
		$data['text_featured']        = lang('common/home.text_featured');
		$data['text_freelancers']     = lang('common/home.text_freelancers');
		$data['text_all_freelancers'] = lang('common/home.text_all_freelancers');
		$data['text_view_profile']                     = lang('common/home.text_view_profile');
		$data['']                     = lang('common/home.text_title');

		// featured block 
		$data['featured'] = [];

		$projectModel = new ProjectModel();

		$filter_data = [
            'limit'         => 5,
            'start'         => 0,
        ];

		$results = $projectModel->getProjects($filter_data);

		foreach ($results as $result) {
            $keyword = $seoUrl->getKeywordByQuery('project_id=' . $result['project_id']);
            $data['featured'][] = [
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'type'        => ($result['type'] == 1) ? lang('en.text_fixed_price') : lang('en.text_per_hour'),
                'date_added'  => $this->dateDifference($result['date_added']),
                'href'        => (route_to('project')) ? route_to('project', $keyword) : base_url('project/project?pid=' . $result['project_id']),
            ];
        }


        // Freelancers Block
        $filter_data = [
			'filter_freelancer' => 0,
			'limit'             => 7,
			'start'             => 0,
        ];
        
        $data['freelancers'] = [];

        $customerModel = new CustomerModel();

        $results = $customerModel->getCustomers($filter_data);
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();

        foreach ($results as $result) {

            if ($result['image']) {
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
                'href'     => (route_to('freelancer')) ? route_to('freelancer') : base_url('freelancer/freelancer/view?cid=' . $result['customer_id'])
            ];
        }



        // Categories Block
   //      $filter_data = [
			// 'limit'             => 8,
			// 'start'             => 0,
   //      ];
        
   //      $data['categories'] = [];

   //      $categoryModel = new \Catalog\Models\Catalog\CategoryModel();

   //      $results = $categoryModel->getCategories($filter_data);

   //      foreach ($results as $result) {
   //          $data['categories'][] = [
   //              'name'     => $result['name'],
   //              'total'    => $categoryModel->getTotalProjectsByCategoryId($result['category_id']),
   //              'href'     => base_url('project/category?gid=' . $result['category_id'])
   //          ];
   //      }


		$data['projects_all']    = base_url('project/category');
		$data['freelancers_all']    = base_url('freelancer/freelancer');
		$data['register'] = base_url('account/register');

		$this->template->output('common/home', $data);

	}

	//--------------------------------------------------------------------

}
