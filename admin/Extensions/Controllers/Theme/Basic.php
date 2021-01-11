<?php namespace Extensions\Controllers\Theme;

use \Admin\Models\Setting\SettingModel;

class Basic extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('theme/basic.list.heading_title'));

        $setting_model = new SettingModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $setting_model->editSetting('theme_default', $this->request->getPost());

            return redirect()->to(base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=theme'))
                             ->with('success', lang('extension/theme/default.text_success'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = [];
  
        $data['breadcrumbs'][] = [
        'text' => lang('en.text_home'),
        'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token'))
      ];
  
        $data['breadcrumbs'][] = [
        'text' => lang('setting/extension.list.heading_title'),
        'href' => base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=theme')
      ];
  
        $data['breadcrumbs'][] = [
        'text' => lang('theme/basic.list.heading_title'),
        'href' => base_url('index.php/extensions/theme/default/user_token=' . $this->session->get('user_token'))
      ];

        $data['action'] = base_url('index.php/extensions/theme/basic?user_token=' . $this->session->get('user_token'));

        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=theme');

        if ($this->request->getMethod() != 'post') {
            $setting_info = $setting_model->getSetting('theme_default');
        }
        
        if ($this->request->getPost('theme_default_directory')) {
            $data['theme_default_directory'] = $this->request->getPost('theme_default_directory');
        } elseif (isset($setting_info['theme_default_directory'])) {
            $data['theme_default_directory'] = $setting_info['theme_default_directory'];
        } else {
            $data['theme_default_directory'] = 'default';
        }

        $data['directories'] = [];

        helper('filesystem');

        $directories = directory_map(ROOTPATH . 'catalog/Views/', 1);

        foreach ($directories as $directory) {
            $data['directories'][] = basename($directory);
        }

        if ($this->request->getPost('theme_default_product_limit')) {
            $data['theme_default_product_limit'] = $this->request->getPost('theme_default_product_limit');
        } elseif (isset($setting_info['theme_default_product_limit'])) {
            $data['theme_default_product_limit'] = $setting_info['theme_default_product_limit'];
        } else {
            $data['theme_default_product_limit'] = 15;
        }

        $data['colors'] = directory_map(str_replace('admin/', '', FCPATH) . 'catalog/default/stylesheet/colors', 1);

        if ($this->request->getPost('theme_default_color')) {
            $data['theme_default_color'] = $this->request->getPost('theme_default_color');
        } elseif (isset($setting_info['theme_default_color'])) {
            $data['theme_default_color'] = $setting_info['theme_default_color'];
        } else {
            $data['theme_default_color'] = 'blue';
        }
        
        if ($this->request->getPost('theme_default_status')) {
            $data['theme_default_status'] = $this->request->getPost('theme_default_status');
        } elseif (isset($setting_info['theme_default_status'])) {
            $data['theme_default_status'] = $setting_info['theme_default_status'];
        } else {
            $data['theme_default_status'] = '';
        }

        if ($this->request->getPost('theme_default_projects_limit')) {
            $data['theme_default_projects_limit'] = $this->request->getPost('theme_default_projects_limit');
        } elseif (isset($setting_info['theme_default_projects_limit'])) {
            $data['theme_default_projects_limit'] = $setting_info['theme_default_projects_limit'];
        } else {
            $data['theme_default_projects_limit'] = 15;
        }
        
        
        $this->document->moduleOutput('Extensions', 'theme/basic', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extensions/theme/basic')) {
            $this->session->setFlashdata('error_warning', lang('theme/basic.error_permission'));
            return false;
        } else {
            return true;
        }
    }
}
