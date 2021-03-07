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
            $data['total_jobs']    = $freelancerModel->getTotalFreelancerProjects(['freelancer_id' => $freelancer_id]);
            // Social
            $data['social']        = json_decode($freelancer_info['social'], true);

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

        // Education 
        $education = $freelancerModel->getEducation($freelancer_id);
        foreach ($education as $result) {
            $data['educations'][] = [
                'education_id' => $result['education_id'],
                'university'   => $result['university'],
                'major'        => $result['major'],
                'year'         => $result['year'],
                'title'        => $result['title'],
                'country'      => $result['country'],
            ];
        }

        // Skills
        $skills = $freelancerModel->getSkills($freelancer_id);
        foreach ($skills as $skill) {
            $data['skills'][] = [
                'skill_id' => $skill['skill_id'],
                'name'     => $skill['name'],
            ];
        }

        //  Education Title
        $data['education_titles'][] = [
            'value' => 'associate',
            'text'  => lang('freelancer/freelancer.text_associate'),
        ];
        $data['education_titles'][] = [
            'value' => 'certificate',
            'text'  => lang('freelancer/freelancer.text_certificate'),
        ];
        $data['education_titles'][] = [
            'value' => 'ba',
            'text'  => lang('freelancer/freelancer.text_ba'),
        ];
        $data['education_titles'][] = [
            'value' => 'brach',
            'text'  => lang('freelancer/freelancer.text_barch'),
        ];
        $data['education_titles'][] = [
            'value' => 'bm',
            'text'  => lang('freelancer/freelancer.text_bm'),
        ];
        $data['education_titles'][] = [
            'value' => 'bfa',
            'text'  => lang('freelancer/freelancer.text_bfa'),
        ];
        $data['education_titles'][] = [
            'value' => 'bsc',
            'text'  => lang('freelancer/freelancer.text_bsc'),
        ];
        $data['education_titles'][] = [
            'value' => 'ma',
            'text'  => lang('freelancer/freelancer.text_ma'),
        ];
        $data['education_titles'][] = [
            'value' => 'mba',
            'text'  => lang('freelancer/freelancer.text_mba'),
        ];
        $data['education_titles'][] = [
            'value' => 'mfa',
            'text'  => lang('freelancer/freelancer.text_mfa'),
        ];
        $data['education_titles'][] = [
            'value' => 'msc',
            'text'  => lang('freelancer/freelancer.text_msc'),
        ];
        $data['education_titles'][] = [
            'value' => 'jd',
            'text'  => lang('freelancer/freelancer.text_jd'),
        ];
        $data['education_titles'][] = [
            'value' => 'md',
            'text'  => lang('freelancer/freelancer.text_md'),
        ];
        $data['education_titles'][] = [
            'value' => 'phd',
            'text'  => lang('freelancer/freelancer.text_phd'),
        ];
        $data['education_titles'][] = [
            'value' => 'llb',
            'text'  => lang('freelancer/freelancer.text_llb'),
        ];
        $data['education_titles'][] = [
            'value' => 'llm',
            'text'  => lang('freelancer/freelancer.text_llm'),
        ];

        // Country
        $countryModel = new CountryModel();
        $data['countries'] = $countryModel->where('status', 1)->findAll();

        // Languages
        $data['languages'] = [];
        $languages  = $freelancerModel->getLanguages(['freelancer_id' => $freelancer_id]);

        foreach ($languages as $language) {
            switch ($language['level']) {
                case '1':
                $level = lang('account/setting.list.text_basic');
                  break;
                case '2':
                $level = lang('account/setting.list.text_conversational');
                 break;
                case '3':
                $level = lang('account/setting.list.text_fluent');
                 break;
                case '4':
                $level = lang('account/setting.list.text_native_or_bilingual');
                 break;
            }

            $data['languages'][] = [
                'language_id' => $language['language_id'],
                'name'        => $language['text'],
                'level'       => $level,
            ];
        }

        // certificates
        $data['certificates'] = [];

        $results = $freelancerModel->getCertificates($freelancer_id);

        foreach ($results as $result) {
            $data['certificates'][] = [
                'certificate_id' => $result['certificate_id'],
                'name'           => $result['name'],
                'year'           => $result['year'],
            ];
        }

        // Profile Progress Bar
        if ($freelancer_info) {
            $data['profile_strength'] = 0;

            if ($freelancer_info['rate'] && $freelancer_info['tag_line'] && $freelancer_info['about']) {
                $data['profile_strength'] = 10;
            } 

            if ($freelancer_info['social']) {
                $data['profile_strength'] += 10;
            } 

            if ($freelancer_info['bg_image']) {
                $data['profile_strength'] += 10;
            } 
            // Certs
            if ($freelancerModel->getTotalCertificatesByID($freelancer_id)) {
                $data['profile_strength'] += 10;
            } 
            // Edu
            if ($freelancerModel->getTotalEducationByID($freelancer_id)) {
                $data['profile_strength'] += 10;
            } 
            // Skills
            if ($freelancerModel->getTotalSkillsByID($freelancer_id)) {
                $data['profile_strength'] += 10;
            } 
            // Lang
            if ($freelancerModel->getTotalLanguageByID($freelancer_id)) {
                $data['profile_strength'] += 30;
            } 

            // Update the current value if not 100
            if ($freelancer_info['profile_strength'] < 100) {
                $freelancerModel->updateStrength($freelancer_id, $data['profile_strength']);
            }
        }

        $data['customer_id'] = $this->customer->getID();

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
        var_dump($this->request->getPost());
        die;
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

    /*
    * Additional Freelancer Profile Info
    */
    // ---- Education ---- //
    public function addEducation()
    {
        $json = [];

        if (! $this->validate([
            'university_id' => [
                'label' => 'University',
                'rules' => 'required|numeric|is_unique[customer_to_education.university_id]',
                'errors' => [
                   'is_unique' => 'University Name already exists'
                ]
            ],
            'major_title'   => [
                'label' => 'Major Title',
                'rules' => 'required|alpha_numeric_space'
            ],
            'major_id'      => [
                'label' => 'Major',
                'rules' => 'required|numeric'
            ],
            'education_country' => [
                'label' => 'Country',
                'rules' => 'required|alpha_numeric_space'
            ]
        ])) {
            $json['error'] = $this->validator->getErrors();
        }

        if (! $json) {
            $freelancerModel = new FreelancerModel();

            $freelancerModel->addEducation($this->request->getVar('freelancer_id'), $this->request->getPost());
            $json['success'] = sprintf(lang('account/setting.text_success_tab'), 'Education');
        }

        return $this->response->setJSON($json);
    }

    public function universitiesAutocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_university')) {
            $filter_data = [
                'limit'             => 5,
                'start'             => 0,
                'filter_university' => $this->request->getVar('filter_university')
            ];

            $freelancerModel = new FreelancerModel();

            $universities = $freelancerModel->getUniversities($filter_data);

            foreach ($universities as $university) {
                $json[] = [
                    'university_id' => $university['university_id'],
                    'university'    => $university['text'],
                    'country'       => $university['country']
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    // Major Autocomplete
    public function majorsAutocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_major')) {
            $filter_data = [
                'limit'             => 5,
                'start'             => 0,
                'filter_university' => $this->request->getVar('filter_major')
            ];
    
            $freelancerModel = new FreelancerModel();
    
            $majors = $freelancerModel->getMajors($filter_data);
    
            foreach ($majors as $major) {
                $json[] = [
                    'major_id' => $major['major_id'],
                    'text'     => $major['text'],
                ];
            }
    
            return $this->response->setJSON($json);
        }
    }

    public function deleteEducation()
    {
        $json = [];
        if ($this->customer->getID()) {
            $freelancerModel = new FreelancerModel();
            if ($this->request->getVar('education_id')) {
                $freelancerModel->deleteEducation($this->request->getVar('education_id'));
                $json['success'] = sprintf(lang('account/setting.text_success_tab'), 'Education');
            }
            return $this->response->setJSON($json);
        }
    }
    // ---- Education End ---- //
    // ---- Certificates Start ---- //
    public function addCertificate()
    {
        $json = [];

        if (! $this->validate([
            'certificate' => [
                'label' => 'Certificate Name',
                'rules' => 'required|is_unique[customer_to_certificate.name]'
            ],
            'year' => [
                'label' => 'Certificate Year',
                'rules' => 'required|numeric'
            ]
        ])) {
            $json['error'] = $this->validator->getErrors();
        }

        if (! $json) {
            $freelancerModel = new FreelancerModel();

            $freelancerModel->addCertificate($this->request->getVar('freelancer_id'), $this->request->getPost('name'), $this->request->getPost('year'));
            $json['success'] = sprintf(lang('account/setting.text_success_tab'), 'Certificates');
        }

        return $this->response->setJSON($json);
    }

    public function deleteCertificate()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if ($this->request->getVar('certificate_id')) {
                $certificate_id = (int) $this->request->getVar('certificate_id');
            } else {
                $certificate_id = 0;
            }

            if ($this->customer->isLogged() && ($this->request->getMethod() == 'post')) {
                $freelancerModel = new FreelancerModel();
                if ($certificate_id) {
                    $freelancerModel->deleteCertificate($certificate_id);
                    $json['success'] = sprintf(lang('account/setting.text_success_tab'), 'Certificates');
                }
            }
        }
        return $this->response->setJSON($json);
    }
    // ---- Certificates End ---- //
    // ---- Language Start ---- //
    public function languagesAutocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_language')) {
            $filter_data = [
                'limit'             => 5,
                'start'             => 0,
                'filter_language'   => $this->request->getVar('filter_language')
            ];

            $freelancerModel = new FreelancerModel();

            $languages = $freelancerModel->getLanguages($filter_data);

            foreach ($languages as $language) {
                $json[] = [
                    'language_id' => $language['language_id'],
                    'text'        => $language['text'],
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    public function addLanguage()
    {
        $json = [];
        
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {

            if (! $this->validate([
                'language'  => [
                    'label'  => 'Language Name',
                    'rules'  => 'required',
                ],
                'level' => [
                    'label'  => 'Language Level',
                    'rules'  => 'required|numeric'
                ],
            ])) {
                $json['error'] = $this->validator->getErrors();
            }

            if (! $json) {
                $freelancerModel = new FreelancerModel();

                $freelancerModel->addLanguage($this->request->getPost('language_id'), $this->request->getVar('freelancer_id'), $this->request->getPost('level'));
                $json['success'] = sprintf(lang('account/setting.text_success_tab'), 'Languages');
            }
        }
        return $this->response->setJSON($json);
    }

    public function deleteLanguage()
    {
        $json = [];

        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            $freelancerModel = new FreelancerModel();

            if ($this->request->getVar('language_id')) {
                $freelancerModel->deleteLanguage($this->request->getVar('language_id'));
                $json['success'] = sprintf(lang('account/setting.text_success_tab'), 'Languages');
            }
        }

        return $this->response->setJSON($json);
    }
    // ---- Language End ---- //
    // ---- Skills Start ---- //
    public function addSkill()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if (! $json) {
                $freelancerModel = new FreelancerModel();

                $freelancerModel->addSkill($this->request->getPost());
                $json['success'] = sprintf(lang('account/setting.text_success_edu'), lang('account/setting.text_skills'));
            }
        }

        return $this->response->setJSON($json);
    }

    // Delete skill
    public function deleteSkill()
    {
        $json = [];

        if ($this->request->getVar('category_id')) {
            $freelancerModel = new FreelancerModel();
            $freelancerModel->deleteSkill($this->request->getVar('category_id'), $this->request->getVar('freelancer_id'));
            $json['success'] = sprintf(lang('account/setting.text_success_edu'), 'Skills');
        }

        return $this->response->setJSON($json);
    }

    // ---- Skills End ---- //
    //--------------------------------------------------------------------
}
