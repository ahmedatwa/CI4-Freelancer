<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Localization\CountryModel;

class Setting extends BaseController
{
    public function edit()
    {
        $this->template->setTitle(lang('account/setting.heading_title'));

        $customerModel = new CustomerModel();

        if (($this->request->getMethod() == 'post')) {
            $customerModel->update($this->session->get('customer_id'), $this->request->getPost());
            return redirect()->route('account_setting')->with('success', lang('account/setting.text_success'));
        }

        $this->index();
    }

    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $this->template->setTitle(lang('account/setting.heading_title'));

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        $customerModel = new CustomerModel();

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => route_to('account_dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/setting.heading_title'),
            'href' => route_to('account_setting', $this->customer->getCustomerUserName()),
        ];


        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($customer_id) {
            $customer_info = $customerModel->getCustomer($customer_id);
        }

        if (isset($customer_info['firstname'])) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if (isset($customer_info['lastname'])) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if (isset($customer_info['email'])) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }
        // Freelancer Profile
        if ($this->request->getPost('about')) {
            $data['about'] = $this->request->getPost('about');
        } elseif ($customer_info['about']) {
            $data['about'] = $customer_info['about'];
        } else {
            $data['about'] = '';
        }
        if ($this->request->getPost('tag_line')) {
            $data['tag_line'] = $this->request->getPost('tag_line');
        } elseif ($customer_info['tag_line']) {
            $data['tag_line'] = ($customer_info['tag_line'] == 'NULL') ? '' : $customer_info['tag_line'];
        } else {
            $data['tag_line'] = '';
        }
        if ($this->request->getPost('rate')) {
            $data['rate'] = $this->request->getPost('rate');
        } elseif ($customer_info['rate']) {
            $data['rate'] = $customer_info['rate'];
        } else {
            $data['rate'] = 0;
        }
        if ($this->request->getPost('social')) {
            $data['social'] = $this->request->getPost('social');
        } elseif ($customer_info['social']) {
            $data['social'] = json_decode($customer_info['social'], true);
        } else {
            $data['social'] = '';
        }

        // avatar placeholder
        if (!empty($customer_info['image']) && file_exists(DIR_IMAGE . $customer_info['image'])) {
            $thumb = '<img src="images/' . $customer_info['image'] . '" style="height:260px;" alt="Your Avatar">';
        } else {
            $thumb = '<img src="images/catalog/avatar.jpg" style="height:260px;"alt="Your Avatar"><h6 class="text-muted">Click to select</h6>';
        }

        $data['thumb'] = $thumb;

        // Background image placeholder
        if (!empty($customer_info['bg_image']) && file_exists(DIR_IMAGE . $customer_info['bg_image'])) {
            $bg_thumb = '<img src="images/'. $customer_info['bg_image'] . '" style="height:260px;width:100%;" alt="Your Profile Background Image">';
        } else {
            $bg_thumb = '<img src="images/no_image.jpg" style="height:260px;width:100%;" alt="Your Avatar">';
        }
        
        $data['bg_thumb'] = $bg_thumb;

        $data['action'] = base_url('account/setting/edit?customer_id=' . $this->customer->getCustomerID());

        //  Education Title
        $data['education_titles'][] = [
            'value' => 'associate',
            'text'  => lang('account/setting.text_associate'),
        ];
        $data['education_titles'][] = [
            'value' => 'certificate',
            'text'  => lang('account/setting.text_certificate'),
        ];
        $data['education_titles'][] = [
            'value' => 'ba',
            'text'  => lang('account/setting.text_ba'),
        ];
        $data['education_titles'][] = [
            'value' => 'brach',
            'text'  => lang('account/setting.text_barch'),
        ];
        $data['education_titles'][] = [
            'value' => 'bm',
            'text'  => lang('account/setting.text_bm'),
        ];
        $data['education_titles'][] = [
            'value' => 'bfa',
            'text'  => lang('account/setting.text_bfa'),
        ];
        $data['education_titles'][] = [
            'value' => 'bsc',
            'text'  => lang('account/setting.text_bsc'),
        ];
        $data['education_titles'][] = [
            'value' => 'ma',
            'text'  => lang('account/setting.text_ma'),
        ];
        $data['education_titles'][] = [
            'value' => 'mba',
            'text'  => lang('account/setting.text_mba'),
        ];
        $data['education_titles'][] = [
            'value' => 'mfa',
            'text'  => lang('account/setting.text_mfa'),
        ];
        $data['education_titles'][] = [
            'value' => 'msc',
            'text'  => lang('account/setting.text_msc'),
        ];
        $data['education_titles'][] = [
            'value' => 'jd',
            'text'  => lang('account/setting.text_jd'),
        ];
        $data['education_titles'][] = [
            'value' => 'md',
            'text'  => lang('account/setting.text_md'),
        ];
        $data['education_titles'][] = [
            'value' => 'phd',
            'text'  => lang('account/setting.text_phd'),
        ];
        $data['education_titles'][] = [
            'value' => 'llb',
            'text'  => lang('account/setting.text_llb'),
        ];
        $data['education_titles'][] = [
            'value' => 'llm',
            'text'  => lang('account/setting.text_llm'),
        ];

        // Country
        $countryModel = new CountryModel();
        $data['countries'] = $countryModel->where('status', 1)->findAll();

        $data['customer_id'] = $this->customer->getCustomerID();
        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');
        $data['currency'] = $this->session->get('currency') ?? $this->registry->get('config_currency');

        // Profile Progress Bar
        $profile_strength = 100;

        if ($customer_info) {
            if ($customer_info['rate'] && $customer_info['tag_line'] && $customer_info['about']) {
                $basic_info = 10;
            } else {
                $basic_info = 0;
            }
            if ($customer_info['social']) {
                $social_info = 10;
            } else {
                $social_info = 0;
            }

            if ($customer_info['bg_image']) {
                $image_info = 10;
            } else {
                $image_info = 0;
            }
            // Certs
            if ($customerModel->getTotalCertificatesByCustomerId($this->customer->getCustomerID())) {
                $cert_info = 10;
            } else {
                $cert_info = 0;
            }
            // Edu
            if ($customerModel->getTotalEducationsByCustomerID($this->customer->getCustomerID())) {
                $edu_info = 10;
            } else {
                $edu_info = 0;
            }
            // Skills
            if ($customerModel->getTotalSkillsByCustomerID($this->customer->getCustomerID())) {
                $skills_info = 10;
            } else {
                $skills_info = 0;
            }
            // Lang
            if ($customerModel->getTotalLanguagesByCustomerId($this->customer->getCustomerID())) {
                $lang_info = 30;
            } else {
                $lang_info = 0;
            }
            $data['profile_strength'] = ($basic_info + $social_info + $image_info + $cert_info + $edu_info + $skills_info + $lang_info) * $profile_strength / 100;
            // Update the current value if not 100%
            if ($customer_info['profile_strength'] < 100) {
                $customerModel->where('customer_id', $customer_id)
                              ->set('profile_strength', $data['profile_strength'])
                              ->update();
            }
        }

        $data['langData'] = lang('account/setting.list');
        
        $this->template->output('account/setting', $data);
    }

    // Certificates
    public function addCertificate()
    {
        $json = [];

        if ($this->request->getVar('cid')) {
            $freelancer_id = $this->request->getVar('cid');
        } else {
            $freelancer_id = 0;
        }
    
        $customerModel = new CustomerModel();

        if (! $this->validate([
            'certificate_name' => [
                'label' => 'Certificate Name',
                'rules' => 'required|alpha_numeric|is_unique[customer_to_certificate.name]'
            ],
            'certificate_year' => [
                'label' => 'Certificate Year',
                'rules' => 'required|numeric'
            ]
        ])) {
            $json['error'] = $this->validator->getErrors();
        }

        if (! $json) {
            $customerModel->addCertificate($this->request->getPost());
            $json['success'] = sprintf(lang('account/setting.text_success_edu'), 'Certificates');
        }

        return $this->response->setJSON($json);
    }

    // Fetch certificates
    public function getCertificates()
    {
        $customerModel = new CustomerModel();
        
        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $data['certificates'] = [];       

        $results = $customerModel->getCustomerCertificates($this->customer->getCustomerID(), ($page - 1) * 5, 5);
        $total = $customerModel->getTotalCertificatesByCustomerId($this->request->getVar('customer_id'));

        foreach ($results as $result) {
            $data['certificates'][] = [
                'certificate_id' => $result['certificate_id'],
                'name'           => $result['name'],
                'year'           => $result['year'],
            ];
        }

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, 5, $total);

        echo view('account/blocks/certificates', $data);
    }

    // Delete certificate
    public function deleteCertificate()
    {
        $json = [];
        if ($this->customer->getCustomerId() && $this->request->getMethod() == 'post') {
            $customerModel = new CustomerModel();
            if ($this->request->getVar('certificate_id')) {
                $customerModel->deleteCustomerCertificate($this->request->getVar('certificate_id'));
                $json['success'] = sprintf(lang('account/setting.text_success_edu'), 'Certificates');
            }
            return $this->response->setJSON($json);
        }
    }
    
    // Education
    public function universitiesAutocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_university')) {
            $filter_data = [
                'limit'             => 5,
                'start'             => 0,
                'filter_university' => $this->request->getVar('filter_university')
            ];

            $customerModel = new CustomerModel();

            $universities = $customerModel->getUniversities($filter_data);

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
    
            $customerModel = new CustomerModel();
    
            $majors = $customerModel->getMajors($filter_data);
    
            foreach ($majors as $major) {
                $json[] = [
                    'major_id' => $major['major_id'],
                    'text'     => $major['text'],
                ];
            }
    
            return $this->response->setJSON($json);
        }
    }

    public function addEducation()
    {
        $json = [];

        if ($this->request->getVar('cid')) {
            $freelancer_id = $this->request->getVar('cid');
        } else {
            $freelancer_id = 0;
        }
    
        $customerModel = new CustomerModel();

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
            $customerModel->addEducation($this->request->getPost());
            $json['success'] = sprintf(lang('account/setting.text_success_edu'), 'Educations');
        }

        return $this->response->setJSON($json);
    }

    public function getEducation()
    {
        $customerModel = new CustomerModel();

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $data['educations'] = [];

        $results = $customerModel->getEducations($this->customer->getCustomerID(), ($page - 1) * 5, 5);
        $total = $customerModel->getTotalEducationsByCustomerId($this->customer->getCustomerID());

        foreach ($results as $result) {
            $data['educations'][] = [
                'education_id' => $result['education_id'],
                'university'   => $result['university'],
                'major'        => $result['major'],
                'year'         => $result['year'],
                'title'        => $result['title'],
                'country'      => $result['country'],
            ];
        }
        
        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, 5, $total);

        echo view('account/blocks/educations', $data);
    }

    // Delete certificate
    public function deleteEducation()
    {
        $json = [];
        if ($this->customer->getCustomerId()) {
            $customerModel = new CustomerModel();
            if ($this->request->getVar('education_id')) {
                $customerModel->deleteCustomerEducation($this->request->getVar('education_id'));
                $json['success'] = sprintf(lang('account/setting.text_success_edu'), 'Educations');
            }
            return $this->response->setJSON($json);
        }
    }

    // Languages
    public function languagesAutocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_language')) {
            $filter_data = [
                'limit'             => 5,
                'start'             => 0,
                'filter_language' => $this->request->getVar('filter_language')
            ];

            $customerModel = new CustomerModel();

            $skills = $customerModel->getLanguages($filter_data);

            foreach ($skills as $skill) {
                $json[] = [
                    'language_id' => $skill['language_id'],
                    'text'        => $skill['text'],
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    public function addLanguage()
    {
        $json = [];
        
        if ($this->request->getMethod() == 'post') {
            $customerModel = new CustomerModel();

            if (! $this->validate([
                'language_name'  => [
                    'label'  => 'Language Name',
                    'rules' => 'required|alpha',
                ],
                'language_level' => [
                    'label'  => 'Language Level',
                    'rules' => 'required|numeric'
                ],
            ])) {
                $json['error'] = $this->validator->getErrors();
            }

            if (! $json) {
                $customerModel->addCustomerLanguage($this->request->getPost());
                $json['success'] = sprintf(lang('account/setting.text_success_edu'), lang('account/setting.text_languages'));
            }
        }
        return $this->response->setJSON($json);
    }

    // Fetch Languages
    public function getLanguages()
    {
        $customerModel = new CustomerModel();

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $data['languages'] = [];

        $results = $customerModel->getCustomerLanguages($this->customer->getCustomerID(), ($page - 1) * 5, 5);
        $total = $customerModel->getTotalLanguagesByCustomerId($this->request->getVar('seller_id'));

        foreach ($results as $result) {
            switch ($result['level']) {
                case '1':
                $level = lang('account/setting.text_basic');
                  break;
                case '2':
                $level = lang('account/setting.text_conversational');
                 break;
                case '3':
                $level = lang('account/setting.text_fluent');
                 break;
                case '4':
                $level = lang('account/setting.text_native_or_bilingual');
                 break;
            }

            $data['languages'][] = [
                'language_id' => $result['language_id'],
                'name'        => $result['name'],
                'level'       => $level,
           ];
        }

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, 5, $total);
        echo view('account/blocks/languages', $data);
    }

    // Delete Language
    public function deleteLanguage()
    {
        $json = [];
        if ($this->customer->getCustomerId()) {
            $customerModel = new CustomerModel();
            if ($this->request->getVar('language_id')) {
                $customerModel->deleteCustomerLanguage($this->request->getVar('language_id'));
                $json['success'] = sprintf(lang('account/setting.text_success_edu'), lang('account/setting.text_languages'));
            }
            return $this->response->setJSON($json);
        }
    }

    /* Skills */
    public function addSkill()
    {
        $json = [];
        if ($this->request->getMethod() == 'post') {
            $customerModel = new CustomerModel();

            if (! $this->validate([
                    'category_id' => ['label' => 'Skill', 'rules' => 'required'],
             ])) {
                $json['error'] = $this->validator->getError('category_id');
            }

            if (!$json) {
                $customerModel->addCustomrSkill($this->request->getPost());
                $json['success'] = sprintf(lang('account/setting.text_success_edu'), lang('account/setting.text_skills'));
            }
        }

        return $this->response->setJSON($json);
    }

    // Fetch Skills
    public function getSkills()
    {
        $customerModel = new CustomerModel();

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $data['skills'] = [];

        $results = $customerModel->getCustomerSkills($this->customer->getCustomerID(), ($page - 1) * 5, 5);
        $total = $customerModel->getTotalSkillsByCustomerID($this->customer->getCustomerID());

        foreach ($results as $result) {
            $data['skills'][] = [
                'skill_id' => $result['skill_id'],
                'name' => $result['name'],
            ];
        }

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, 5, $total);

        echo view('account/blocks/skills', $data);
    }

    // Delete skill
    public function deleteSkill()
    {
        $json = [];

        if ($this->request->getVar('category_id')) {
            $customerModel = new CustomerModel();
            $customerModel->deleteCustomerSkill($this->request->getVar('category_id'));
            $json['success'] = sprintf(lang('account/setting.text_success_edu'), 'Skills');
        }

        return $this->response->setJSON($json);
    }

    public function avatarUpload()
    {
        $json = [];
        if ($this->request->isAJAX()) {
            if ($imagefile = $this->request->getFile('image')) {
                $customerModel = new CustomerModel();

                if ($imagefile->isValid() && ! $imagefile->hasMoved()) {
                    $newName = $imagefile->getRandomName();
                    $imagefile->move('images/catalog', $newName);
                    $customerModel->where('customer_id', $this->session->get('customer_id'))
                              ->set('image', 'catalog/' . $newName)
                              ->update();
                    // return fileInput Config
                    $json = [
                        'initialPreview' => base_url('images/catalog/' . $newName),
                        'initialPreviewConfig' => [
                            'caption' => $imagefile->getClientName(),
                            'url'     => '',
                            'key'     => $this->session->get('customer_id'),
                        ],
                        'append' => true,
                   ];
                }
            }
        }
        return $this->response->setJSON($json);
    }

    public function backgroundImageUpload()
    {
        $json = [];
        if ($this->request->isAJAX()) {
            if ($imagefile = $this->request->getFile('bg_image')) {
                $customerModel = new CustomerModel();

                if ($imagefile->isValid() && ! $imagefile->hasMoved()) {
                    $newName = $imagefile->getRandomName();
                    $imagefile->move('images/catalog', $newName);
                    $customerModel->where('customer_id', $this->session->get('customer_id'))
                              ->set('bg_image', 'catalog/' . $newName)
                              ->update();
                    // return fileInput Config
                    $json = [
                        'initialPreview' => base_url('images/catalog/' . $newName),
                        'initialPreviewConfig' => [
                            'caption' => $imagefile->getClientName(),
                            'url'     => '',
                            'key'     => $this->session->get('customer_id'),
                        ],
                        'append' => true,
                   ];
                }
            }
        }
        return $this->response->setJSON($json);
    }

    public function profileUpdate()
    {
        $json = [];
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            // Fields Validation Rules // Passowrd Update
            if ($this->request->getPost('current') && $this->request->getPost('password')) {
                if (! $this->validate([
                        'current'  => 'required',
                        'password' => 'required|min_length[4]|alpha_numeric_punct',
                        'confirm'  => 'required_with[password]|matches[password]',
                    ])) {
                    $json['error'] = $this->validator->getErrors();
                }

                if (! $json) {
                    $customerModel = new CustomerModel();

                    $oldPassword = $customerModel->where('customer_id', $this->customer->getCustomerID())
                                                 ->findColumn('password');
                    if (password_verify($this->request->getPost('current'), $oldPassword[0])) {
                        // old password passed then update
                        $customerModel->where('customer_id', $this->customer->getCustomerID())
                                      ->set('password', $this->request->getPost('password'))
                                      ->update();
                        $json['success'] = lang('account/setting.text_password_success');
                    } else {
                        $json['error']['old_password'] = lang('account/setting.error_old_password');
                    }
                }
                // Name
            } else {
                if (! $this->validate([
                        'firstname' => 'required|alpha_numeric',
                        'lastname'  => 'required|alpha_numeric',
                    ])) {
                    $json['error'] = $this->validator->getErrors();
                }

                if (! $json) {
                    $customerModel = new CustomerModel();
                    $customerModel->update($this->session->get('customer_id'), $this->request->getPost());
                    $json['success'] = lang('account/setting.text_success');
                }
            }
        }
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
