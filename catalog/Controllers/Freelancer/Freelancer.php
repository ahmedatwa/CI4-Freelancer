<?php 

namespace Catalog\Controllers\Freelancer;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\CategoryModel;
use Catalog\Models\Freelancer\FreelancerModel;
use Catalog\Models\Account\ReviewModel;
use Catalog\Models\Freelancer\BalanceModel;
use Catalog\Models\Account\InboxModel;
use Catalog\Models\Localization\CountryModel;

class Freelancer extends BaseController
{
    public function view()
    {
        $this->template->setTitle(lang('freelancer/freelancer.text_profile'));

        $freelancerModel = new FreelancerModel();

        $this->profile();
    }

    public function index()
    {
        $this->template->setTitle(lang('freelancer/freelancer.heading_title'));

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

        if ($this->request->getVar('country')) {
            $filter_country = $this->request->getVar('country');
        } else {
            $filter_country = null;
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
            'filter_skills'     => $filter_skills,
            'filter_rate'       => $filter_rate,
            'filter_country'    => $filter_country,
            'sort_by'           => $sort_by,
            'order_by'          => $order_by,
            'limit'             => $limit,
            'start'             => ($page - 1) * $limit,
        ];
        
        $freelancerModel = new FreelancerModel();
        $reviewModel = new ReviewModel();

        $data['freelancers'] = [];

        $results = $freelancerModel->getFreelancers($filter_data);
        $total = $freelancerModel->getTotalFreelancers($filter_data);

        foreach ($results as $result) {
            if ($result['image'] && file_exists('images/' . $result['image'])) {
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
                'href'     => route_to('freelancer_profile', $result['username']) ? route_to('freelancer_profile', $result['username']) : base_url('freelancer/freelancer/view?freelancer_id=' . $result['customer_id'])
            ];
        }

        // Freelancer Rates Filter
        $data['rates'] = [];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.list.text_10'),
            'value' => '10',
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.list.text_10_20'),
            'value' => '10_20',
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.list.text_20_30'),
            'value' => '20_30',
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.list.text_30_40'),
            'value' => '30_40',
        ];

        $data['rates'][] = [
            'text'  => lang('freelancer/freelancer.list.text_40'),
            'value' => '40',
        ];

        $categoryModel = new CategoryModel();

        $data['categories'] = [];
        $categories = $categoryModel->getCategories();
        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name']
            ];
        }   

        // Country
        $countryModel = new CountryModel();
        $data['countries'] = $countryModel->where('status', 1)->findAll();

        $data['text_found']    = lang('freelancer/freelancer.text_found', [$total]);
        $data['heading_title'] = lang('freelancer/freelancer.heading_title');

        $data['filter_skills']  = $filter_skills;
        $data['filter_rate']    = $filter_rate;
        $data['filter_country'] = $filter_country;
        $data['sort_by']        = $sort_by;
        $data['order_by']       = $order_by;
        $data['limit']          = $limit;
        $data['page']           = $page;

        $data['langData'] = lang('freelancer/freelancer.list');

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        $this->template->output('freelancer/freelancer_list', $data);
    }

    public function profile(string $username = '')
    {
        $this->template->setTitle(lang('freelancer/freelancer.text_profile'));

        $freelancerModel = new FreelancerModel();

        if ($username) {
            $freelancer_info = $freelancerModel->getFreelancer($username);
        }

        if ($this->request->getVar('cid')) {
            $freelancer_id = $this->request->getVar('cid');
        } elseif ($freelancer_info['customer_id']) {
            $freelancer_id = $freelancer_info['customer_id'];
        } else {
            $freelancer_id = 0;
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
            'text' => $username,
            'href' => base_url('freelancer/freelancer'),
        ];

        if ($freelancer_info) {
            $reviewModel = new ReviewModel();

            $data['text_hire_me']     = sprintf(lang('freelancer/freelancer.text_hire_me'), $freelancer_info['username']);
            $data['text_canned']      = sprintf(lang('freelancer/freelancer.text_canned'), $freelancer_info['username']);

            $name                  = $freelancer_info['firstname'] . ' ' . $freelancer_info['lastname'];
            $data['name']          = (strlen($name) > 1) ? $name : '@'. $freelancer_info['username'];
            $data['freelancer_id'] = $freelancer_info['customer_id'];
            $data['employer_id']   = $this->customer->getID();
            $data['about']         = $freelancer_info['about'];
            $data['rate']          = $freelancer_info['rate'];
            $data['tag_line']      = $freelancer_info['tag_line'];
            
            if ($freelancer_info['image'] && file_exists('images/' . $freelancer_info['image'])) {
                $data['image'] = $this->resize($freelancer_info['image'], 130, 130);
            } else {
                $data['image'] = $this->resize('catalog/avatar.jpg', 130, 130);
            }

            if ($freelancer_info['bg_image'] && file_exists('images/' . $freelancer_info['bg_image'])) {
                $data['bgImage'] = $this->resize($freelancer_info['bg_image'], 1200, 1200);
            } else {
                $data['bgImage'] = $this->resize('catalog/single-freelancer.jpg', 1200, 1200);
            }

            // Widgets
            $data['rating']        = $reviewModel->getAvgReviewByFreelancerId($freelancer_id);
            $data['recommended']   = $reviewModel->getRecommendedByFreelancerId($freelancer_id);
            $data['ontime']        = $reviewModel->getOntimeByFreelancerId($freelancer_id);
            // Social
            $data['social']        = json_decode($freelancer_info['social'], true);
            $data['skills']        = $freelancerModel->getFreelancerSkills($freelancer_id);
            // Languages
            $data['languages'] = [];
            $languages  = $freelancerModel->getFreelancerLanguages(['freelancer_id' => $freelancer_id]);

            foreach ($languages as $language) {
                $data['languages'][] = $language['text'];
            }

            $data['educations']    = $freelancerModel->getFreelancerEducation($freelancer_id);
            $data['certificates']  = $freelancerModel->getFreelancerCertificates($freelancer_id);

            // reviews
            $data['reviews'] = [];
            $reviews = $reviewModel->getFreelancerReviews($freelancer_id);
            $reviews_total = $reviewModel->getTotalFreelancerReviews($freelancer_id);
            foreach ($reviews as $result) {
                $data['reviews'][] = [
                    'name'          => $result['name'],
                    'comment'       => $result['comment'],
                    'rating'        => $result['rating'],
                    'date_added'    => lang('en.mediumDate', [strtotime($result['date_added'])]),
                ];
            }

       
        $limit = 5;
        $page = 1;

        $pager = \Config\Services::pager();
        $data['pagination'] = ($reviews_total <= $limit) ? '' : $pager->makeLinks($page, $limit, $reviews_total, 'default_simple');

            // Project PMs Data
            $inboxModel = new InboxModel();
            $message_info = $inboxModel->getMessageThread($freelancer_id);
            $data['thread_id'] = $message_info['thread_id'] ?? '';
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Update Profile Views
        $freelancerModel->updateViewed($freelancer_id);

        $data['langData'] = lang('freelancer/freelancer.list');
        
        $this->template->output('freelancer/freelancer_info', $data);
    }

   /**
   *  overwrite any existing query variables.
   *  add a value to the query variables collection without destroying the existing query variables
   */
    public function filter()
    {
        $json = [];

        if ($this->request->getPost('uri')) {
            $uri = new \CodeIgniter\HTTP\URI(base64_decode($this->request->getPost('uri', FILTER_SANITIZE_STRING)));

            if ($this->request->getPost('skills') && ($this->request->getPost('skills') != 0)) {
                $uri->addQuery('skills', $this->request->getPost('skills'));
            } else {
                $uri->stripQuery('skills');
            }

            if ($this->request->getPost('rate')) {
                $uri->addQuery('rate', $this->request->getPost('rate'));
            }


            $json['uri'] = (string) $uri;
        }
        
        return $this->response->setJSON($json);
    }
    
    public function profileUpdate()
    {
        $json = [];

        if ($this->request->getPost('pk')) {
            $freelancer_id = $this->request->getPost('pk');
        } else {
            $freelancer_id = 0;
        }
        var_dump( $this->request->getPost());die;
        $freelancerModel = new FreelancerModel();

        if (! $this->validate([
            // 'certificate_name' => [
            //     'label' => 'Certificate Name',
            //     'rules' => 'required|alpha_numeric|is_unique[customer_to_certificate.name]'
            // ],
            // 'certificate_year' => [
            //     'label' => 'Certificate Year',
            //     'rules' => 'required|numeric'
            // ]
        ])) {
            $json['error'] = $this->validator->getErrors();
        }

        if (! $json) {
            $freelancerModel->edit($freelancer_id, $this->request->getPost());
            $json['success'] = sprintf(lang('account/setting.text_success_tab'), 'Certificates');
        }

        return $this->response->setJSON($json);
    }





    //--------------------------------------------------------------------
}
