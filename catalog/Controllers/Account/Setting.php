<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Setting extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('account/setting.heading_title'));

        $customerModel = new CustomerModel();

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => route_to('account/dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/setting.heading_title'),
            'href' => route_to('account/setting', $this->customer->getCustomerUserName()),
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

        if (($this->request->getMethod() != 'post') && $this->customer->getCustomerID()) {
            $customer_info = $customerModel->getCustomer($this->customer->getCustomerID());
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif (!empty($customer_info['firstname'])) {
            $data['firstname'] = $customer_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif (!empty($customer_info['lastname'])) {
            $data['lastname'] = $customer_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } elseif (!empty($customer_info['email'])) {
            $data['email'] = $customer_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('about')) {
            $data['about'] = $this->request->getPost('about');
        } elseif (!empty($customer_info['about'])) {
            $data['about'] = $customer_info['about'];
        } else {
            $data['about'] = '';
        }
        if ($this->request->getPost('tagline')) {
            $data['tagline'] = $this->request->getPost('tagline');
        } elseif (!empty($customer_info['tagline'])) {
            $data['tagline'] = $customer_info['tagline'];
        } else {
            $data['tagline'] = '';
        }

        if ($this->request->getPost('passowrd')) {
            $data['passowrd'] = $this->request->getPost('passowrd');
        } else {
            $data['passowrd'] = '';
        }

        if ($this->request->getPost('confirm')) {
            $data['confirm'] = $this->request->getPost('confirm');
        } else {
            $data['confirm'] = '';
        }

        if ($this->request->getPost('current_passowrd')) {
            $data['current_passowrd'] = $this->request->getPost('current_passowrd');
        } else {
            $data['current_passowrd'] = '';
        }
        
        $data['action'] = base_url('account/setting?customer_id=' . $this->customer->getCustomerID());

        $data['heading_title']          = lang('account/setting.heading_title');
        $data['entry_firstname']        = lang('account/setting.entry_firstname');
        $data['entry_lastname']         = lang('account/setting.entry_lastname');
        $data['entry_email']            = lang('account/setting.entry_email');
        $data['text_profile']           = lang('account/setting.text_profile');
        $data['text_account']           = lang('account/setting.text_account');
        $data['text_about']             = lang('account/setting.text_about');
        $data['entry_tagline']          = lang('account/setting.entry_tagline');
        $data['entry_nationality']      = lang('account/setting.entry_nationality');
        $data['text_password_security'] = lang('account/setting.text_password_security');
        $data['text_2step']             = lang('account/setting.text_2step');
        $data['text_skills']            = lang('account/setting.text_skills');
        $data['text_hourly_rate']       = lang('account/setting.text_hourly_rate');
        $data['text_loading']           = lang('en.text_loading');
        $data['button_add']             = lang('en.button_add');
        
        $data['text_certification']     = lang('account/setting.text_certification');
        $data['text_loading']           = lang('account/setting.text_loading');
        $data['text_select']            = lang('en.text_select');
        $data['text_sure']              = lang('account/setting.text_sure');
        $data['text_education']         = lang('account/setting.text_education');
        
        $data['entry_year']             = lang('account/setting.entry_year');
        $data['entry_university']       = lang('account/setting.entry_university');
        $data['entry_country']          = lang('account/setting.entry_country');
        $data['entry_uni_title']        = lang('account/setting.entry_uni_title');
        $data['entry_major']            = lang('account/setting.entry_major');
        $data['entry_certification']    = lang('account/setting.entry_certification');


        $data['tab_certificates']          = lang('account/setting.tab_certificates');
        $data['tab_education']             = lang('account/setting.tab_education');
        $data['tab_languages']             = lang('account/setting.tab_languages');
        $data['tab_skill']                = lang('account/setting.tab_skill');

        $data['text_professional_heading'] = lang('account/setting.text_professional_heading');
        $data['text_professional_sub']     = lang('account/setting.text_professional_sub');
        $data['text_add_language']         = lang('account/setting.text_add_language');
        $data['text_basic']                = lang('account/setting.text_basic');
        $data['text_conversational']       = lang('account/setting.text_conversational');
        $data['text_fluent']               = lang('account/setting.text_fluent');
        $data['text_native_or_bilingual']  = lang('account/setting.text_native_or_bilingual');
        $data['text_beginner']             = lang('account/setting.text_beginner');
        $data['text_intermediate']         = lang('account/setting.text_intermediate');
        $data['text_expert']               = lang('account/setting.text_expert');
        $data['text_add_skill']            = lang('account/setting.text_add_skill');
        $data['entry_language']       = lang('account/setting.entry_language');
        $data['entry_language_level']       = lang('account/setting.entry_language_level');
        $data['entry_skill']       = lang('account/setting.entry_skill');
        $data['entry_skill_level']       = lang('account/setting.entry_skill_level');

        $data['entry_current_password'] = lang('account/setting.entry_current_password');
        $data['entry_password']         = lang('account/setting.entry_password');
        $data['entry_confirm']          = lang('account/setting.entry_confirm');
        
       
        $data['button_submit'] = lang('account/setting.button_submit');

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


        $data['customer_id'] = $this->customer->getCustomerID();

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/setting', $data);
    }

    public function edit()
    {
        $this->template->setTitle(lang('account/setting.heading_title'));

        $customerModel = new CustomerModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->categories->editCategory($this->customer->getCustomerID(), $this->request->getPost());
            return redirect()->to(route_to('account/setting', $this->customer->getCustomerUserName()))
                             ->with('success', lang('catalog/category.text_success'));
        }

        $this->index();
    }

    // Certificates
    public function addCertificate()
    {
        $json = [];

        if ($this->customer->getCustomerID()) {
            $freelancer_id = $this->customer->getCustomerID();
        } else {
            $freelancer_id = 0;
        }
    
        $customerModel = new CustomerModel();

        if (! $this->validate([
            'name'             => "required",
            'certificate_year' => 'required'
        ])) {
            $json['error']      = lang('account/setting.error_data');
            $json['error_name'] = $this->validator->getError('certificate');
            $json['error_year'] = $this->validator->getError('certificate_year');
            return false;
        }

        $customerModel->addCertificate($this->request->getPost());
        $json['success'] = sprintf(lang('account/setting.text_success_edu'), 'Certificates');

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

        $data['text_loading']  = lang('en.text_loading');
        $data['column_name']   = lang('account/setting.column_name');
        $data['column_year']   = lang('account/setting.column_year');
        $data['column_action'] = lang('account/setting.column_action');
        $data['button_delete'] = lang('account/setting.button_delete');
       

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
        if ($this->customer->getCustomerId()) {
            $customerModel = new CustomerModel();
            if ($this->request->getVar('certificate_id')) {
                $this->sellers->deleteSellerCertificate($this->request->getVar('certificate_id'));
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

        if ($this->customer->getCustomerID()) {
            $freelancer_id = $this->customer->getCustomerID();
        } else {
            $freelancer_id = 0;
        }
    
        $customerModel = new CustomerModel();

        if (! $this->validate([
            'university_id' => "required",
            'major_title'   => "required",
            'major_id'      => "required",
        ])) {
            $json['error']                 = lang('account/setting.error_data');
            $json['error_university_name'] = $this->validator->getError('university_id');
            $json['error_major_title']     = $this->validator->getError('major_title');
            $json['error_major_name']      = $this->validator->getError('major_id');
            return false;
        } else {
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

        $data['column_country']    = lang('account/setting.column_country');
        $data['column_university'] = lang('account/setting.column_university');
        $data['column_major']      = lang('account/setting.column_major');
        $data['column_year']       = lang('account/setting.column_year');
        $data['column_action']     = lang('account/setting.column_action');

        $data['text_loading'] = lang('account/setting.text_loading');

        $data['button_delete'] = lang('account/setting.button_delete');
        

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
        if ($this->customer->get_customer_id()) {
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
            'language_id' => "required",
            'language_level'   => "required",
        ])) {
            $json['error'] = lang('account/setting.error_data');
            $json['error_language'] = $this->validator->getError('language_id');
            $json['error_language_level'] = $this->validator->getError('language_level');
            return false;
        } 
            $customerModel->addCustomerLanguage($this->request->getPost());
            $json['success'] = sprintf(lang('account/setting.text_success_edu'), lang('account/setting.text_languages'));
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

        $data['column_name'] = lang('account/setting.column_name');
        $data['column_level'] = lang('account/setting.column_level');
        $data['column_action'] = lang('account/setting.column_action');

        $data['text_loading'] = lang('account/setting.text_loading');

        $data['button_delete'] = lang('account/setting.button_delete');

        $results = $customerModel->getCustomerLanguages($this->customer->getCustomerID(), ($page - 1) * 5, 5);
        $total = $customerModel->getTotalLanguagesByCustomerId($this->request->getVar('seller_id'));

        foreach ($results as $result) {
            $data['languages'][] = [
                'language_id' => $result['language_id'],
                'name' => $result['name'],
                'level' => $result['level'],
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
        if ($this->customer->get_customer_id()) {
            $customerModel = new CustomerModel();
            if ($this->request->getVar('language_id')) {
                $customerModel->deleteCustomerLanguage($this->request->getVar('language_id'));
                $json['success'] = sprintf(lang('account/setting.text_success_edu'), lang('account/setting.text_languages'));
            }
            return $this->response->setJSON($json);
        }
    }

    //  Skills
    public function skillsAutocomplete()
    {
        $json = [];

        if ($this->request->getVar('project_skill')) {
            $filter_data = [
                'limit'             => 5,
                'start'             => 0,
                'filter_skill'      => $this->request->getVar('project_skill')
            ];
            $customerModel = new CustomerModel();

            $skills = $customerModel->getSkills($filter_data);

            foreach ($skills as $skill) {
                $json[] = [
                    'skill_id' => $skill['skill_id'],
                    'text' => $skill['text'],
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    public function addSkill()
    {
        $json = [];
        if ($this->request->getMethod() == 'post') {
            $customerModel = new CustomerModel();

            if (! $this->validate([
                    'skill_id'      => "required",
                    'skill_level'   => "required",
             ])) {
                $json['error'] = lang('account/setting.error_data');
                $json['error_skill'] = $this->validator->getError('skill_id');
                $json['error_level'] = $this->validator->getError('skill_level');
            }

            $customerModel->addCustomrSkill($this->request->getPost());
            $json['success'] = sprintf(lang('account/setting.text_success_edu'), lang('account/setting.text_skills'));
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

        $data['column_name']   = lang('account/setting.column_name');
        $data['column_level']  = lang('account/setting.column_level');
        $data['column_action'] = lang('account/setting.column_action');
        $data['text_loading']  = lang('account/setting.text_loading');
        $data['button_delete'] = lang('account/setting.button_delete');

        $results = $customerModel->getCustomerSkills($this->customer->getCustomerID(), ($page - 1) * 5, 5);
        $total = $customerModel->getTotalSkillsByCustomerID($this->request->getVar('seller_id'));

        foreach ($results as $result) {
            $data['skills'][] = [
                'skill_id' => $result['skill_id'],
                'name' => $result['name'],
                'level' => $result['level'],
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
        if ($this->customer->getCustomerID()) {
            $customerModel = new CustomerModel();
            if ($this->request->getVar('skill_id')) {
                $customerModel->deleteCustomerSkill($this->request->getVar('skill_id'));
                $json['success'] = sprintf(lang('account/setting.text_success_edu'), 'Skills');
            }
            return $this->response->setJSON($json);
        }
    }

    protected function validateForm()
    {
        // Fields Validation Rules
        if (! $this->validate([
            'firstname' => 'required|alpha_numeric',
            'lastname' => 'required|alpha_numeric',
            'email' => [
                'rules' => 'required|valid_email|is_unique[customer.email]',
                'errors' => [
                    'is_unique' => 'Warning: E-Mail Address is already registered!'
                ],
            ],
            'password' => 'required|min_length[4]',
            'confirm'  => 'required_with[password]|matches[password]',
            ])) {
            $this->session->setFlashData('error_warning', lang('account/register.text_warning'));
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------
}
