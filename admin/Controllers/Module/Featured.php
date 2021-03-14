<?php 

namespace Admin\Controllers\Module;

use Admin\Controllers\BaseController;
use Admin\Models\Setting\SettingModel;

class Featured extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('module/featured.list.heading_title'));

        $settingModel = new SettingModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $settingModel->editSetting('module_featured', $this->request->getPost());

            return redirect()->to(base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token')))
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
            'href' => base_url('index.php/common/dashboard', 'user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/account.list.text_module'),
            'href' => base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (! $this->request->getVar('module_id')) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/featured.list.heading_title'),
                'href' => base_url('index.php/module/featured?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => base_url('index.php/module/featured?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        if (! $this->request->getVar('module_id')) {
            $data['action'] = base_url('index.php/module/featured?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/module/featured?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
        }

        $data['cancel'] = base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getVar('module_id') && ($this->request->getMethod() != 'post')) {
            $module_info = $modules->getModule($this->request->getVar('module_id'));
        }

        if ($this->request->getPost('module_featured_status')) {
            $data['module_featured_status'] = $this->request->getPost('module_featured_status');
        } elseif ($this->registry->get('module_featured_status')) {
            $data['module_featured_status'] = $this->registry->get('module_featured_status');
        } else {
            $data['module_featured_status'] = 0;
        }

        if ($this->request->getPost('module_featured_limit')) {
            $data['module_featured_limit'] = $this->request->getPost('module_featured_limit');
        } elseif ($this->registry->get('module_featured_limit')) {
            $data['module_featured_limit'] = $this->registry->get('module_featured_limit');
        } else {
            $data['module_featured_limit'] = 8;
        }

        $this->document->output('module/featured', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'module/featured')) {
            $this->session->setFlashdata('error_warning', lang('module/featured.error_permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
