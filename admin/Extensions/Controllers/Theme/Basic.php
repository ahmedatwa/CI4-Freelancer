<?php namespace Extensions\Controllers\Theme;

class Basic extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/theme/default_theme.list.heading_title'));

        $setting_model = new \Admin\Models\Setting\Settings();

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

        $data['breadcrumbs'] = array();
  
        $data['breadcrumbs'][] = array(
        'text' => lang('en.text_home'),
        'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token'))
      );
  
        $data['breadcrumbs'][] = array(
        'text' => lang('setting/extension.list.heading_title'),
        'href' => base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=theme')
      );
  
        $data['breadcrumbs'][] = array(
        'text' => lang('extension/theme/default_theme.list.heading_title'),
        'href' => base_url('index.php/extension/theme/default/user_token=' . $this->session->get('user_token'))
      );

        $data['action'] = base_url('index.php/extension/theme/default_theme?user_token=' . $this->session->get('user_token'));

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


        $directories = directory_map(ROOTPATH . 'catalog/Views/template/', 1);

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
        
        if ($this->request->getPost('theme_default_status')) {
            $data['theme_default_status'] = $this->request->getPost('theme_default_status');
        } elseif (isset($setting_info['theme_default_status'])) {
            $data['theme_default_status'] = $setting_info['theme_default_status'];
        } else {
            $data['theme_default_status'] = '';
        }
        
        if ($this->request->getPost('theme_default_product_description_length')) {
            $data['theme_default_product_description_length'] = $this->request->getPost('theme_default_product_description_length');
        } elseif (isset($setting_info['theme_default_product_description_length'])) {
            $data['theme_default_product_description_length'] = $setting_info['theme_default_product_description_length'];
        } else {
            $data['theme_default_product_description_length'] = 100;
        }
        
        if ($this->request->getPost('theme_default_image_category_width')) {
            $data['theme_default_image_category_width'] = $this->request->getPost('theme_default_image_category_width');
        } elseif (isset($setting_info['theme_default_image_category_width'])) {
            $data['theme_default_image_category_width'] = $setting_info['theme_default_image_category_width'];
        } else {
            $data['theme_default_image_category_width'] = 80;
        }
        
        if ($this->request->getPost('theme_default_image_category_height')) {
            $data['theme_default_image_category_height'] = $this->request->getPost('theme_default_image_category_height');
        } elseif (isset($setting_info['theme_default_image_category_height'])) {
            $data['theme_default_image_category_height'] = $setting_info['theme_default_image_category_height'];
        } else {
            $data['theme_default_image_category_height'] = 80;
        }
        
        if ($this->request->getPost('theme_default_image_thumb_width')) {
            $data['theme_default_image_thumb_width'] = $this->request->getPost('theme_default_image_thumb_width');
        } elseif (isset($setting_info['theme_default_image_thumb_width'])) {
            $data['theme_default_image_thumb_width'] = $setting_info['theme_default_image_thumb_width'];
        } else {
            $data['theme_default_image_thumb_width'] = 228;
        }
        
        if ($this->request->getPost('theme_default_image_thumb_height')) {
            $data['theme_default_image_thumb_height'] = $this->request->getPost('theme_default_image_thumb_height');
        } elseif (isset($setting_info['theme_default_image_thumb_height'])) {
            $data['theme_default_image_thumb_height'] = $setting_info['theme_default_image_thumb_height'];
        } else {
            $data['theme_default_image_thumb_height'] = 228;
        }
        
        if ($this->request->getPost('theme_default_image_popup_width')) {
            $data['theme_default_image_popup_width'] = $this->request->getPost('theme_default_image_popup_width');
        } elseif (isset($setting_info['theme_default_image_popup_width'])) {
            $data['theme_default_image_popup_width'] = $setting_info['theme_default_image_popup_width'];
        } else {
            $data['theme_default_image_popup_width'] = 500;
        }
        
        if ($this->request->getPost('theme_default_image_popup_height')) {
            $data['theme_default_image_popup_height'] = $this->request->getPost('theme_default_image_popup_height');
        } elseif (isset($setting_info['theme_default_image_popup_height'])) {
            $data['theme_default_image_popup_height'] = $setting_info['theme_default_image_popup_height'];
        } else {
            $data['theme_default_image_popup_height'] = 500;
        }
        
        if ($this->request->getPost('theme_default_image_product_width')) {
            $data['theme_default_image_product_width'] = $this->request->getPost('theme_default_image_product_width');
        } elseif (isset($setting_info['theme_default_image_product_width'])) {
            $data['theme_default_image_product_width'] = $setting_info['theme_default_image_product_width'];
        } else {
            $data['theme_default_image_product_width'] = 228;
        }
        
        if ($this->request->getPost('theme_default_image_product_height')) {
            $data['theme_default_image_product_height'] = $this->request->getPost('theme_default_image_product_height');
        } elseif (isset($setting_info['theme_default_image_product_height'])) {
            $data['theme_default_image_product_height'] = $setting_info['theme_default_image_product_height'];
        } else {
            $data['theme_default_image_product_height'] = 228;
        }
        
        if ($this->request->getPost('theme_default_image_additional_width')) {
            $data['theme_default_image_additional_width'] = $this->request->getPost('theme_default_image_additional_width');
        } elseif (isset($setting_info['theme_default_image_additional_width'])) {
            $data['theme_default_image_additional_width'] = $setting_info['theme_default_image_additional_width'];
        } else {
            $data['theme_default_image_additional_width'] = 74;
        }
        
        if ($this->request->getPost('theme_default_image_additional_height')) {
            $data['theme_default_image_additional_height'] = $this->request->getPost('theme_default_image_additional_height');
        } elseif (isset($setting_info['theme_default_image_additional_height'])) {
            $data['theme_default_image_additional_height'] = $setting_info['theme_default_image_additional_height'];
        } else {
            $data['theme_default_image_additional_height'] = 74;
        }
        
        if ($this->request->getPost('theme_default_image_related_width')) {
            $data['theme_default_image_related_width'] = $this->request->getPost('theme_default_image_related_width');
        } elseif (isset($setting_info['theme_default_image_related_width'])) {
            $data['theme_default_image_related_width'] = $setting_info['theme_default_image_related_width'];
        } else {
            $data['theme_default_image_related_width'] = 80;
        }
        
        if ($this->request->getPost('theme_default_image_related_height')) {
            $data['theme_default_image_related_height'] = $this->request->getPost('theme_default_image_related_height');
        } elseif (isset($setting_info['theme_default_image_related_height'])) {
            $data['theme_default_image_related_height'] = $setting_info['theme_default_image_related_height'];
        } else {
            $data['theme_default_image_related_height'] = 80;
        }
                                
        if ($this->request->getPost('theme_default_image_location_width')) {
            $data['theme_default_image_location_width'] = $this->request->getPost('theme_default_image_location_width');
        } elseif (isset($setting_info['theme_default_image_location_width'])) {
            $data['theme_default_image_location_width'] = $setting_info['theme_default_image_location_width'];
        } else {
            $data['theme_default_image_location_width'] = 268;
        }
        
        if ($this->request->getPost('theme_default_image_location_height')) {
            $data['theme_default_image_location_height'] = $this->request->getPost('theme_default_image_location_height');
        } elseif (isset($setting_info['theme_default_image_location_height'])) {
            $data['theme_default_image_location_height'] = $setting_info['theme_default_image_location_height'];
        } else {
            $data['theme_default_image_location_height'] = 50;
        }
        
        $this->document->output('extension/theme/default_theme', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/theme/default_theme')) {
            $this->session->setFlashdata('error_warning', lang('extension/theme/default_theme.error_permission'));
            return false;
        } else {
            return true;
        }
    }
}
