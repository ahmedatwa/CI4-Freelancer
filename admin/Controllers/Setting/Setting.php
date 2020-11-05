<?php namespace Admin\Controllers\Setting;

class Setting extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->settings = new \Admin\Models\Setting\Settings();

        $this->document->setTitle(lang('setting/setting.text_title'));

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->settings->editSetting('config', $this->request->getPost());
            return redirect()->to(base_url('index.php/setting/setting?user_token=' . $this->request->getVar('user_token')))
                             ->with('success', lang('setting/setting.text_success'));
        }
        $this->getForm();
    }

    protected function getForm()
    {

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
            ];
        
        $data['breadcrumbs'][] = [
            'text' => lang('setting/setting.text_title'),
            'href' => base_url('index.php/setting/setting?user_token=' . $this->request->getVar('user_token')),
            ];
        
        $data['action'] = base_url('index.php/setting/setting?user_token=' . $this->request->getVar('user_token'));
        
        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getMethod() != 'post') {
            $setting_info = $this->settings->getSetting();
        }
        
        // General
        if ($this->request->getPost('config_meta_title')) {
            $data['config_meta_title'] = $this->request->getPost('config_meta_title');
        } elseif (!empty($setting_info['config_meta_title'])) {
            $data['config_meta_title'] = $setting_info['config_meta_title'];
        } else {
            $data['config_meta_title'] = '';
        }

        if ($this->request->getPost('config_meta_description')) {
            $data['config_meta_description'] = $this->request->getPost('config_meta_description');
        } elseif (!empty($setting_info['config_meta_description'])) {
            $data['config_meta_description'] = $setting_info['config_meta_description'];
        } else {
            $data['config_meta_description'] = '';
        }

        if ($this->request->getPost('config_meta_keyword')) {
            $data['config_meta_keyword'] = $this->request->getPost('config_meta_keyword');
        } elseif (!empty($setting_info['config_meta_keyword'])) {
            $data['config_meta_keyword'] = $setting_info['config_meta_keyword'];
        } else {
            $data['config_meta_keyword'] = '';
        }

        if ($this->request->getPost('config_theme')) {
            $data['config_theme'] = $this->request->getPost('config_theme');
        } elseif (!empty($setting_info['config_theme'])) {
            $data['config_theme'] = $setting_info['config_theme'];
        } else {
            $data['config_theme'] = '';
        }

        $data['themes'] = [];

        $extensions_model = new \Admin\Models\Setting\Extensions();

        $extensions = $extensions_model->getInstalled('theme');

        foreach ($extensions as $code) {
            $data['themes'][] = [
                'text'  => lang('theme/' . $code . '.list.heading_title'),
                'value' => ($code == 'basic') ? 'default' : $code,
            ];
        }

        if ($this->request->getPost('config_name')) {
            $data['config_name'] = $this->request->getPost('config_name');
        } elseif (!empty($setting_info['config_name'])) {
            $data['config_name'] = $setting_info['config_name'];
        } else {
            $data['config_name'] = '';
        }
        if ($this->request->getPost('config_owner')) {
            $data['config_owner'] = $this->request->getPost('config_owner');
        } elseif (!empty($setting_info['config_owner'])) {
            $data['config_owner'] = $setting_info['config_owner'];
        } else {
            $data['config_owner'] = '';
        }
        if ($this->request->getPost('config_address')) {
            $data['config_address'] = $this->request->getPost('config_address');
        } elseif (!empty($setting_info['config_address'])) {
            $data['config_address'] = $setting_info['config_address'];
        } else {
            $data['config_address'] = '';
        }
        if ($this->request->getPost('config_email')) {
            $data['config_email'] = $this->request->getPost('config_email');
        } elseif (!empty($setting_info['config_email'])) {
            $data['config_email'] = $setting_info['config_email'];
        } else {
            $data['config_email'] = '';
        }
        if ($this->request->getPost('config_telephone')) {
            $data['config_telephone'] = $this->request->getPost('config_telephone');
        } elseif (!empty($setting_info['config_telephone'])) {
            $data['config_telephone'] = $setting_info['config_telephone'];
        } else {
            $data['config_telephone'] = '';
        }

        // Local
        $languages = new \Admin\Models\Localisation\Languages();
        $data['languages'] = $languages->where('status', 1)->findAll();

        if ($this->request->getPost('config_language_id')) {
            $data['config_language_id'] = $this->request->getPost('config_language_id');
        } elseif (!empty($setting_info['config_language_id'])) {
            $data['config_language_id'] = $setting_info['config_language_id'];
        } else {
            $data['config_language_id'] = '';
        }

        if ($this->request->getPost('config_admin_language_id')) {
            $data['config_admin_language_id'] = $this->request->getPost('config_admin_language_id');
        } elseif (!empty($setting_info['config_admin_language_id'])) {
            $data['config_admin_language_id'] = $setting_info['config_admin_language_id'];
        } else {
            $data['config_admin_language_id'] = '';
        }

        if ($this->request->getPost('config_currency')) {
            $data['config_currency'] = $this->request->getPost('config_currency');
        } elseif (!empty($setting_info['config_currency'])) {
            $data['config_currency'] = $setting_info['config_currency'];
        } else {
            $data['config_currency'] = '';
        }

        if ($this->request->getPost('config_admin_limit')) {
            $data['config_admin_limit'] = $this->request->getPost('config_admin_limit');
        } elseif (!empty($setting_info['config_admin_limit'])) {
            $data['config_admin_limit'] = $setting_info['config_admin_limit'];
        } else {
            $data['config_admin_limit'] = '';
        }

        if ($this->request->getPost('config_customer_activity')) {
            $data['config_customer_activity'] = $this->request->getPost('config_customer_activity');
        } elseif (!empty($setting_info['config_customer_activity'])) {
            $data['config_customer_activity'] = $setting_info['config_customer_activity'];
        } else {
            $data['config_customer_activity'] = '';
        }

        if ($this->request->getPost('config_customer_online')) {
            $data['config_customer_online'] = $this->request->getPost('config_customer_online');
        } elseif (!empty($setting_info['config_customer_online'])) {
            $data['config_customer_online'] = $setting_info['config_customer_online'];
        } else {
            $data['config_customer_online'] = 0;
        }

        if ($this->request->getPost('config_login_attempts')) {
            $data['config_login_attempts'] = $this->request->getPost('config_login_attempts');
        } elseif (!empty($setting_info['config_login_attempts'])) {
            $data['config_login_attempts'] = $setting_info['config_login_attempts'];
        } else {
            $data['config_login_attempts'] = '';
        }

        $project_status_model = new \Admin\Models\Localisation\Project_statuses();
        $data['project_statuses'] = $project_status_model->findAll();

        if ($this->request->getPost('config_project_status_id')) {
            $data['config_project_status_id'] = $this->request->getPost('config_project_status_id');
        } elseif (!empty($setting_info['config_project_status_id'])) {
            $data['config_project_status_id'] = $setting_info['config_project_status_id'];
        } else {
            $data['config_project_status_id'] = '';
        }

        if ($this->request->getPost('config_project_completed_status')) {
            $data['config_project_completed_status'] = $this->request->getPost('config_project_completed_status');
        } elseif (!empty($setting_info['config_project_completed_status'])) {
            $data['config_project_completed_status'] = $setting_info['config_project_completed_status'];
        } else {
            $data['config_project_completed_status'] = '';
        }

        if ($this->request->getPost('config_project_expired_status')) {
            $data['config_project_expired_status'] = $this->request->getPost('config_project_expired_status');
        } elseif (!empty($setting_info['config_project_expired_status'])) {
            $data['config_project_expired_status'] = $setting_info['config_project_expired_status'];
        } else {
            $data['config_project_expired_status'] = '';
        }

        if ($this->request->getPost('config_freelancer_fee')) {
            $data['config_freelancer_fee'] = $this->request->getPost('config_freelancer_fee');
        } elseif (!empty($setting_info['config_freelancer_fee'])) {
            $data['config_freelancer_fee'] = $setting_info['config_freelancer_fee'];
        } else {
            $data['config_freelancer_fee'] = '';
        }

        if ($this->request->getPost('config_processing_fee')) {
            $data['config_processing_fee'] = $this->request->getPost('config_processing_fee');
        } elseif (!empty($setting_info['config_processing_fee'])) {
            $data['config_processing_fee'] = $setting_info['config_processing_fee'];
        } else {
            $data['config_processing_fee'] = '';
        }

        if ($this->request->getPost('config_logo')) {
            $data['config_logo'] = $this->request->getPost('config_logo');
        } elseif (!empty($setting_info['config_logo'])) {
            $data['config_logo'] = $setting_info['config_logo'];
        } else {
            $data['config_logo'] = '';
        }

        if ($this->request->getPost('config_logo') && is_file(DIR_IMAGE . $this->request->getPost('config_logo'))) {
            $data['logo'] = resizeImage($this->request->getPost('config_logo'), 100, 100);
        } elseif ($this->registry->get('config_logo') && is_file(DIR_IMAGE . $this->registry->get('config_logo'))) {
            $data['logo'] = resizeImage($this->registry->get('config_logo'), 100, 100);
        } else {
            $data['logo'] = resizeImage('no_image.jpg', 100, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);


        if ($this->request->getPost('config_maintenance')) {
            $data['config_maintenance'] = $this->request->getPost('config_maintenance');
        } elseif (!empty($setting_info['config_maintenance'])) {
            $data['config_maintenance'] = $setting_info['config_maintenance'];
        } else {
            $data['config_maintenance'] = 0;
        }

        // Social Networks
        if ($this->request->getPost('config_facebook')) {
            $data['config_facebook'] = $this->request->getPost('config_facebook');
        } elseif (!empty($setting_info['config_facebook'])) {
            $data['config_facebook'] = $setting_info['config_facebook'];
        } else {
            $data['config_facebook'] = '#';
        }

        if ($this->request->getPost('config_twitter')) {
            $data['config_twitter'] = $this->request->getPost('config_twitter');
        } elseif (!empty($setting_info['config_twitter'])) {
            $data['config_twitter'] = $setting_info['config_twitter'];
        } else {
            $data['config_twitter'] = '#';
        }

        if ($this->request->getPost('config_pintrest')) {
            $data['config_pintrest'] = $this->request->getPost('config_pintrest');
        } elseif (!empty($setting_info['config_pintrest'])) {
            $data['config_pintrest'] = $setting_info['config_pintrest'];
        } else {
            $data['config_pintrest'] = '#';
        }

        if ($this->request->getPost('config_linkedin')) {
            $data['config_linkedin'] = $this->request->getPost('config_linkedin');
        } elseif (!empty($setting_info['config_linkedin'])) {
            $data['config_linkedin'] = $setting_info['config_linkedin'];
        } else {
            $data['config_linkedin'] = '#';
        }

        if ($this->request->getPost('config_instagram')) {
            $data['config_instagram'] = $this->request->getPost('config_instagram');
        } elseif (!empty($setting_info['config_instagram'])) {
            $data['config_instagram'] = $setting_info['config_instagram'];
        } else {
            $data['config_instagram'] = '#';
        }

        $data['entry_freelancer_fee'] = sprintf(lang('setting/setting.list.entry_freelancer_fee'), $this->registry->get('config_name'));

        return $this->document->output('setting/setting', $data);
    }
    
    protected function validateForm()
    {
        if (! $this->validate([
                'config_meta_title' => [
                    'label' => 'Title',
                    'rules' => 'required|min_length[3]'
                ],
                'config_name' => [
                    'label' => 'Site Name',
                    'rules' => 'required|min_length[3]|max_length[32]'
                ],
                'config_owner' => [
                    'label' => 'Site Owner',
                    'rules' => 'required|min_length[3]|max_length[64]'
                ],
                'config_address' => [
                    'label' => 'Site Address',
                    'rules' => 'required|min_length[10]|max_length[256]'
                ],
                'config_email' => [
                    'label' => 'E-Mail Address',
                    'rules' => 'required|valid_email'
                ],
                'config_telephone' => [
                    'label' => 'Telephone',
                    'rules' => 'required|min_length[3]|max_length[32]'
                ],
                'config_admin_limit' => [
                    'label' => 'Admin List Limit',
                    'rules' => 'required'
                ],
                'config_login_attempts' => [
                    'label' => 'Login Attempts',
                    'rules' => 'required|numeric|greater_than[0]'
                ],
          ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('setting/setting.error_permission'));
            return false;
        }
        return true;
    }




    //--------------------------------------------------------------------
}
