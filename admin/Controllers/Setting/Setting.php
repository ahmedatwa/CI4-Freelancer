<?php namespace Admin\Controllers\Setting;

use \Admin\Models\Setting\SettingModel;
use \Admin\Models\Setting\ExtensionModel;
use \Admin\Models\Localisation\LanguageModel;
use \Admin\Models\Localisation\ProjectStatusModel;
use \Admin\Models\Localisation\CurrencyModel;

class Setting extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $settingModel = new SettingModel();

        $this->document->setTitle(lang('setting/setting.text_title'));

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $settingModel->editSetting('config', $this->request->getPost());
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
            $settingModel = new SettingModel();
            $setting_info = $settingModel->getSetting();
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

        $extensionModel = new ExtensionModel();

        $extensions = $extensionModel->getInstalled('theme');

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
        $languageModel = new LanguageModel();
        $data['languages'] = $languageModel->where('status', 1)->findAll();

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

        $currencyModel = new CurrencyModel;
        $data['currencies'] = $currencyModel->where('status', 1)->findAll();

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

        $projectStatusModel = new ProjectStatusModel();
        $data['project_statuses'] = $projectStatusModel->findAll();

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

        if ($this->request->getPost('config_upgrade_sponser')) {
            $data['config_upgrade_sponser'] = $this->request->getPost('config_upgrade_sponser');
        } elseif (!empty($setting_info['config_upgrade_sponser'])) {
            $data['config_upgrade_sponser'] = $setting_info['config_upgrade_sponser'];
        } else {
            $data['config_upgrade_sponser'] = '';
        }

        if ($this->request->getPost('config_upgrade_highlight')) {
            $data['config_upgrade_highlight'] = $this->request->getPost('config_upgrade_highlight');
        } elseif (!empty($setting_info['config_upgrade_highlight'])) {
            $data['config_upgrade_highlight'] = $setting_info['config_upgrade_highlight'];
        } else {
            $data['config_upgrade_highlight'] = '';
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

        if ($this->request->getPost('config_file_ext_allowed')) {
            $data['config_file_ext_allowed'] = $this->request->getPost('config_file_ext_allowed');
        } else {
            $data['config_file_ext_allowed'] = $setting_info['config_file_ext_allowed'];
        }

        if ($this->request->getPost('config_file_mime_allowed')) {
            $data['config_file_mime_allowed'] = $this->request->getPost('config_file_mime_allowed');
        } else {
            $data['config_file_mime_allowed'] = $setting_info['config_file_mime_allowed'];
        }

        // Social Networks
        if ($this->request->getPost('config_social_networks')) {
            $data['config_social_networks'] = $this->request->getPost('config_social_networks');
        } elseif (!empty($setting_info['config_social_networks'])) {
            $data['config_social_networks'] = $setting_info['config_social_networks'];
        } else {
            $data['config_social_networks'] = [];
        }

        if ($this->request->getPost('config_global_alert')) {
            $data['config_global_alert'] = $this->request->getPost('config_global_alert');
        } elseif (!empty($setting_info['config_global_alert'])) {
            $data['config_global_alert'] = $setting_info['config_global_alert'];
        } else {
            $data['config_global_alert'] = '';
        }

        if ($this->request->getPost('config_chat_widget')) {
            $data['config_chat_widget'] = $this->request->getPost('config_chat_widget');
        } elseif (!empty($setting_info['config_chat_widget'])) {
            $data['config_chat_widget'] = $setting_info['config_chat_widget'];
        } else {
            $data['config_chat_widget'] = '';
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

        if (! $this->user->hasPermission('modify', 'setting/setting')) {
            $this->session->setFlashdata('error_warning', lang('setting/setting.error_permission'));
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------
}
