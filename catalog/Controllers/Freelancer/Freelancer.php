<?php namespace Catalog\Controllers\Freelancer;

use \Catalog\Models\Account\CustomerModel;
use \Catalog\Models\Catalog\CategoryModel;
use \Catalog\Models\Freelancer\FreelancerModel;
use \Catalog\Models\Account\ReviewModel;
use \Catalog\Models\Freelancer\BalanceModel;
use \Catalog\Models\freelancer\DisputeModel;
use \Catalog\Models\Account\MessageModel;

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
        $reviewModel = new ReviewModel();

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
                
        $data['action_skills'] = route_to('freelancers') . $url;



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
            'href'  => route_to('freelancers') .'?rate=10&order_by=ASC' . $url
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_10_20'),
            'value' => '10_20',
            'href'  => route_to('freelancers') .'?rate=10_20&order_by=ASC' . $url
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_20_30'),
            'value' => '20_30',
            'href'  => route_to('freelancers') .'?rate=20_30&order_by=ASC' . $url
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_30_40'),
            'value' => '30_40',
            'href'  => route_to('freelancers') . '?rate=30_40&order_by=DESC' . $url
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.text_40'),
            'value' => '40',
            'href'  => route_to('freelancers') . '?rate=40&order_by=DESC' . $url
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

        $data['customer_profile_id'] = $customer_id;
        $data['customer_id'] = $this->session->get('customer_id');
       
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

        $reviewModel = new ReviewModel();
        $projectModel = new \Catalog\Models\Catalog\ProjectModel();

        if ($customer_info) {
            $data['text_hire_me']     = sprintf(lang('freelancer/freelancer.text_hire_me'), $customer_info['username']);
            $data['text_canned']      = sprintf(lang('freelancer/freelancer.text_canned'), $customer_info['username']);

            $name = $customer_info['firstname'] . ' ' . $customer_info['lastname'];

            $data['name']          = (strlen($name) > 1) ? $name : '@'.$customer_info['username'];
            $data['freelancer_id'] = $customer_info['customer_id'];
            $data['about']         = $customer_info['about'];
            $data['rate']          = $customer_info['rate'];
            $data['tag_line']      = ($customer_info['tag_line'] == 'NULL') ? '' : $customer_info['tag_line'];

            $data['image'] = $customer_info['image'] ? $this->resize($customer_info['image'], 130, 130) : $this->resize('catalog/avatar.jpg', 130, 130);
            // Widgets
            $data['rating']        = $reviewModel->getAvgReviewByFreelancerId($customer_id);
            $data['recommended']   = $reviewModel->getRecommendedByFreelancerId($customer_id);
            $data['ontime']        = $reviewModel->getOntimeByFreelancerId($customer_id);
            // Social
            $data['facebook'] = $customer_info['facebook'];
            $data['twitter']  = $customer_info['twitter'];
            $data['linkedin'] = $customer_info['linkedin'];
            $data['github']   = $customer_info['github'];

            $data['skills']        = $customerModel->getCustomerSkills($customer_id);
            $data['languages']     = $customerModel->getCustomerLanguages($customer_id);

            $data['educations'] = $customerModel->getEducations($customer_id);

            
            $data['certificates'] = $customerModel->getCustomerCertificates($customer_id);

            // $filter_data = [
            //  'freelancer_id' => $customer_id,
            //  'status'        => $this->registry->get('config_project_completed_status')
            // ];

            // $projects = $projectModel->getProjectAward($filter_data);
            
            // reviews
            $data['reviews'] = [];
            $freelancer_reviews = $reviewModel->getFreelancerReviews($customer_id);
            foreach ($freelancer_reviews as $result) {
                $data['reviews'][] = [
                    'name'          => $result['name'],
                    'comment'       => $result['comment'],
                    'rating'        => $result['rating'],
                    'date_added'    => lang('en.mediumDate', [strtotime($result['date_added'])]),
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

        $data['employer_id'] = $this->session->get('customer_id');


        $customerModel->updateViewed($customer_id);

        $this->template->output('freelancer/freelancer_info', $data);
    }

    public function acceptOffer()
    {
        $json = [];

        if ($this->request->getVar('freelancer_id')) {
            if ($this->request->getVar('freelancer_id')) {
                $freelancer_id = $this->request->getVar('freelancer_id');
            } else {
                $freelancer_id = 0;
            }

            if ($this->request->getVar('project_id')) {
                $project_id = $this->request->getVar('project_id');
            } else {
                $project_id = 0;
            }

            if ($this->request->getVar('bid_id')) {
                $bid_id = $this->request->getVar('bid_id');
            } else {
                $bid_id = 0;
            }

            if ($this->request->getVar('employer_id')) {
                $employer_id = $this->request->getVar('employer_id');
            } else {
                $employer_id = 0;
            }

            $freelancerModel = new FreelancerModel();

            $freelancerModel->acceptOffer($freelancer_id, $project_id, $bid_id, $employer_id);

            $json['success'] = lang('freelancer/freelancer.text_offer_accepted');
        }

        return $this->response->setJSON($json);
    }

    public function getDisputes()
    {
        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
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
            $limit = $this->registry->get('theme_default_projects_limit') ?? 15;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
         'created_by' => $customer_id,
         'sort_by'     => $sort_by,
         'order_by'    => $order_by,
         'limit'       => $limit,
         'start'       => ($page - 1) * $limit,
        ];

        $data['disputes'] = [];

        $disputeModel = new DisputeModel();
        $customerModel = new CustomerModel;

        $results = $disputeModel->getDisputes($filter_data);
        $total = $disputeModel->getTotalDisputes($filter_data);

        foreach ($results as $result) {

            $dispute_action = $disputeModel->getDisputeAction($result['dispute_action_id']);
            $name = $customerModel->where('customer_id', $result['employer_id'])->findColumn('username');

            $data['disputes'][] = [
                'dispute_id' => $result['project_id'],
                'employer' => $name[0],
                'project_id' => $result['project_id'],
                'comment'    => $result['comment'],
                'status'     => $result['status'],
                'action'     => $dispute_action ?? '-',
                'date_added' => lang('en.longDate', [strtotime($result['date_added'])]),

            ];
        }

        $data['column_project_id']    = lang('employer/employer.column_project_id');
        $data['column_freelancer_id'] = lang('employer/employer.column_freelancer_id');
        $data['column_employer_id']   = lang('employer/employer.column_employer_id');
        $data['column_comment']       = lang('employer/employer.column_comment');
        $data['column_status']        = lang('employer/employer.column_status');
        $data['column_action']        = lang('employer/employer.column_action');
        $data['column_date_added']    = lang('employer/employer.column_date_added');

        $data['customer_id'] = $customer_id;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        return view('freelancer/dispute_list', $data);
    }

    public function openDispute()
    {
        $json = [];

        $disputeModel = new DisputeModel();

        if (! $this->validate([
           'comment' => "required|min_length[20]",
        ]))
        {
         $json['error'] = $this->validator->getErrors();
        }

        if ($this->request->getMethod() == 'post') {
           
            if (! $json) {
                $dispute_data = [
                    'created_by'        => $this->request->getPost('freelancer_id'),
                    'employer_id'       => $this->request->getPost('employer_id'),
                    'freelancer_id'     => $this->request->getPost('freelancer_id'),
                    'project_id'        => $this->request->getPost('project_id'),
                    'comment'           => $this->request->getPost('comment'),
                    'dispute_reason_id' => $this->request->getPost('dispute_reason_id'),
                ];

                $disputeModel->insert($dispute_data);

                $json['success'] = lang('freelancer/dispute.text_success');
            }
        }
        
        return $this->response->setJSON($json);
    }
    //--------------------------------------------------------------------
}
