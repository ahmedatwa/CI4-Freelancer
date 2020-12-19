<?php namespace Admin\Controllers\Module;

use \Admin\Models\Setting\SettingModel;

class Category extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('module/category.list.heading_title'));

        $settingModel = new SettingModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $settingModel->editSetting('module_category', $this->request->getPost());

            return redirect()->to(base_url('index.php/setting/module?user_token=' . $this->session->get('user_token')))
                             ->with('success', lang('setting/module.text_success'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard', 'user_token=' . $this->session->get('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/account.list.text_module'),
            'href' => base_url('index.php/setting/module?user_token=' . $this->session->get('user_token'))
        ];

        if (! $this->request->getVar('module_id')) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/category.list.heading_title'),
                'href' => base_url('index.php/module/category?user_token=' . $this->session->get('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => base_url('index.php/module/category?user_token=' . $this->session->get('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        if (! $this->request->getVar('module_id')) {
            $data['action'] = base_url('index.php/module/category?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/module/category?user_token=' . $this->session->get('user_token') . '&module_id=' . $this->request->getVar('module_id'));
        }

        $data['cancel'] = base_url('index.php/setting/module?user_token=' . $this->session->get('user_token'));

        if ($this->request->getVar('module_id') && ($this->request->getMethod() != 'post')) {
            $module_info = $modules->getModule($this->request->getVar('module_id'));
        }

        if ($this->request->getPost('module_category_status')) {
            $data['module_category_status'] = $this->request->getPost('module_category_status');
        } elseif (!empty($module_info)) {
            $data['module_category_status'] = $module_info['module_category_status'];
        } else {
            $data['module_category_status'] = '';
        }

        $this->document->output('module/category', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'module/category')) {
            $this->session->setFlashdata('error_warning', lang('module/category.error_permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
