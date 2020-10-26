<?php namespace Catalog\Controllers\Freelancer;

use Catalog\Models\Account\CustomerModel;
use \Catalog\Models\Catalog\CategoryModel;

class Freelancer extends \Catalog\Controllers\BaseController
{
    public function view()
    {
        $this->template->setTitle(lang('freelancer/freelancer.text_profile'));

        $customerModel = new CustomerModel();

        $this->profile();
    }

    public function index()
    {

        $this->template->setTitle(lang('freelancer/freelancer.heading_title'));

        $customerModel = new CustomerModel();
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('freelancer/freelancer.heading_title'),
            'href' => base_url('freelancer/freelancer'),
        ];

        if ($this->request->getVar('skills')) {
            $filter_skills = explode('_', $this->request->getVar('skills'));
        } else {
            $filter_skills = [];
        }

        if ($this->request->getVar('rate')) {
            $filter_rate = $this->request->getVar('rate');
        } else {
            $filter_rate = null;
        }

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'p.date_added';
        }
       
        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 20;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
            'filter_freelancer' => 0,
            'filter_skills'     => $filter_skills,
            'filter_rate'       => $filter_rate,
            'sort_by'           => $sort_by,
            'order_by'          => $order_by,
            'limit'             => $limit,
            'start'             => ($page - 1) * $limit,
        ];
        
        $data['freelancers'] = [];

        $results = $customerModel->getCustomers($filter_data);
        $total = $customerModel->getTotalCustomers($filter_data);

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
                'href'     => route_to('freelancer_profile', $result['customer_id'], $result['username']) ? route_to('freelancer_profile', $result['customer_id'], $result['username']) : base_url('freelancer/freelancer/view?cid=' . $result['customer_id'])
            ];
        }

        $url = '';

        if ($this->request->getVar('order_by')) {
            $url .= '&order_by=' . $this->request->getVar('order_by');
        }

        if ($this->request->getVar('sort_by')) {
            $url .= '&sort_by=' . $this->request->getVar('sort_by');
        }
        
        if ($this->request->getVar('rate')) {
            $url .= '&rate=' . $this->request->getVar('rate');
        }
                
        $data['action_skills'] = str_replace('&amp;', '&', base_url('freelancer/freelancer') . $url);



        // $data['sorts'] = [];

        // $data['sorts'][] = [
        //     'text'  => lang('common/search.text_newest'),
        //     'value' => 'p.date_added-ASC',
        //     'href'  => base_url('freelancer/freelancer?sort_by=budget_min&order_by=ASC' . $url)
        // ];

        // $data['sorts'][] = [
        //     'text'  => lang('common/search.text_lowest'),
        //     'value' => 'p.budget_min-ASC',
        //     'href'  => base_url('freelancer/freelancer?sort_by=budget_min&order_by=ASC' . $url)
        // ];

        // $data['sorts'][] = [
        //     'text'  => lang('common/search.text_highest'),
        //     'value' => '< 10',
        //     'href'  => base_url('freelancer/freelancer?sort_by=budget_min&order_by=DESC' . $url)
        // ];

        $url = '';

        if ($this->request->getVar('order_by')) {
            $url .= '&order_by=' . $this->request->getVar('order_by');
        }

        if ($this->request->getVar('sort_by')) {
            $url .= '&sort_by=' . $this->request->getVar('sort_by');
        }
        
        if ($this->request->getVar('skills')) {
            $url .= '&skills=' . $this->request->getVar('skills');
        }

        $data['rates'] = [];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_10'),
            'value' => '10',
            'href'  => base_url('freelancer/freelancer?rate=10&order_by=ASC' . $url)
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_10_20'),
            'value' => '10_20',
            'href'  => base_url('freelancer/freelancer?rate=10_20&order_by=ASC' . $url)
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_20_30'),
            'value' => '20_30',
            'href'  => base_url('freelancer/freelancer?rate=20_30&order_by=ASC' . $url)
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_30_40'),
            'value' => '30_40',
            'href'  => base_url('freelancer/freelancer?rate=30_40&order_by=DESC' . $url)
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_40'),
            'value' => '40',
            'href'  => base_url('freelancer/freelancer?rate=40&order_by=DESC' . $url)
        ];

        $categoryModel = new CategoryModel();

        $data['categories'] = [];
        $categories = $categoryModel->getCategories(['start' => 0, 'limit' => 5]);
        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name']
            ];
        }

        $data['button_view']      = lang('freelancer/freelancer.button_view');
        $data['text_rate']        = lang('freelancer/freelancer.text_rate');
        $data['heading_title']    = lang('freelancer/freelancer.heading_title');
        $data['text_found']       = lang('freelancer/freelancer.text_found', [$total]);
        $data['text_skills']      = lang('freelancer/freelancer.text_skills');
        $data['text_select']      = lang('en.text_select');
        $data['text_hourly_rate'] = lang('freelancer/freelancer.text_hourly_rate');

        $data['filter_skills'] = $filter_skills;
        $data['filter_rate']   = $filter_rate;
        $data['sort_by']       = $sort_by;
        $data['order_by']      = $order_by;
        $data['limit']         = $limit;
        $data['page']          = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        $this->template->output('freelancer/freelancer_list', $data);

    }

    public function profile()
    {
        $this->template->setTitle(lang('freelancer/freelancer.text_profile'));

        $customerModel = new CustomerModel();

        if ($this->request->getVar('cid')) {
           $customer_id = $this->request->getVar('cid');
        } elseif ($this->request->uri->getSegment(2)) {
           $customer_id = substr($this->request->uri->getSegment(2), 1);
        } else {
           $customer_id = 0;
        }
       

        if ($customer_id) {
            $customer_info = $customerModel->getCustomer($customer_id);
        } 

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('freelancer/freelancer.heading_title'),
            'href' => base_url('freelancer/freelancer'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $customer_info['firstname'],
            'href' => base_url('freelancer/freelancer'),
        ];

        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();
        $projectModel = new \Catalog\Models\Catalog\ProjectModel();

        if ($customer_info) {
            $data['text_hire_me']     = sprintf(lang('freelancer/freelancer.text_hire_me'), $customer_info['username']);
            $data['text_canned']      = sprintf(lang('freelancer/freelancer.text_canned'), $customer_info['username']);


            $data['name']          = $customer_info['firstname'] . ' ' . $customer_info['lastname'];
            $data['freelancer_id'] = $customer_info['customer_id'];
            $data['about']         = $customer_info['about'];
            $data['rate']          = $customer_info['rate'];
            $data['tag_line']      = $customer_info['tag_line'];

            $data['image'] = $customer_info['image'] ? $this->resize($customer_info['image'], 130, 130) : $this->resize('catalog/avatar.jpg', 130, 130);

            $data['rating']        = $reviewModel->getAvgReviewByFreelancerId($customer_id);
            $data['skills']        = $customerModel->getCustomerSkills($customer_id);
            $data['languages']     = $customerModel->getCustomerLanguages($customer_id);

            $data['educations'] = $customerModel->getEducations($customer_id);
            $data['completed'] = $projectModel->getTotalAwardsByFreelancerId($customer_id);

            
            $data['certificates'] = $customerModel->getCustomerCertificates($customer_id);

            
            $filter_data = [
             'freelancer_id' => $customer_id,
             'status'        => $this->registry->get('config_project_completed_status')
            ];

            $projects = $projectModel->getProjectAward($filter_data);
            $reviews = $reviewModel->getFreelancerReview($customer_id);

            $data['projects'] = [];
            foreach ($projects as $project) {
                $data['projects'][] = [
                    'name'          => $project['name'],
                    'delivery_time' => $project['delivery_time'],
                    'comment'       => $reviews['comment'],
                    'date_added'    => $reviews['date_added'],
                    'rating'        => $reviews['rating'],
                ];
            }
        }

        $data['heading_title']    = lang('freelancer/freelancer.text_profile');
        $data['text_about']       = lang('freelancer/freelancer.text_about');
        $data['text_history']     = lang('freelancer/freelancer.text_history');
        $data['text_social']      = lang('freelancer/freelancer.text_social');
        $data['text_skills']      = lang('freelancer/freelancer.text_skills');
        $data['text_languages']   = lang('freelancer/freelancer.text_languages');
        $data['text_education']   = lang('freelancer/freelancer.text_education');
        $data['text_cert']        = lang('freelancer/freelancer.text_cert');
        $data['button_offer']     = lang('freelancer/freelancer.button_offer');
        $data['text_message']     = lang('freelancer/freelancer.text_message');
        $data['text_budget_min']  = lang('freelancer/freelancer.text_budget_min');
        $data['button_hire']      = lang('freelancer/freelancer.button_hire');
        $data['text_fixed_price'] = lang('en.text_fixed_price');
        $data['text_per_hour']    = lang('en.text_per_hour');

        $projects_total = $projectModel->getTotalAwardsByFreelancerId($customer_id);
       
        $limit = 5;
        $page = 1;

        $pager = \Config\Services::pager();
        $data['pagination'] = ($projects_total <= $limit) ? '' : $pager->makeLinks($page, $limit, $projects_total);

        $data['employer_id'] = $this->customer->getCustomerId();


        $customerModel->updateViewed($customer_id);

        $this->template->output('freelancer/freelancer_info', $data);
    }

   public function hireMe()
   {
        $json = [];

        if ($this->request->getMethod() == 'post') {

        $messageModel = new \Catalog\Models\Account\MessageModel();

        $messageModel->addMessage($this->request->getPost());

        $json['success'] = lang('freelancer/freelancer.text_success');

        }

        return $this->response->setJSON($json);
   }

    //--------------------------------------------------------------------
}
