<?php namespace Admin\Controllers\Module;

use \Admin\Models\Setting\SettingModel;

class Freelancer extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('module/freelancer.list.heading_title'));

        $settingModel = new SettingModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                $settingModel->editSetting('module_freelancer', $this->request->getPost());

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
                'text' => lang('module/freelancer.list.heading_title'),
                'href' => base_url('index.php/module/freelancer?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => base_url('index.php/module/freelancer?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        if (! $this->request->getVar('module_id')) {
            $data['action'] = base_url('index.php/module/freelancer?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/module/freelancer?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
        }

        $data['cancel'] = base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getVar('module_id') && ($this->request->getMethod() != 'post')) {
            $module_info = $modules->getModule($this->request->getVar('module_id'));
        }

        if ($this->request->getPost('module_freelancer_status')) {
            $data['module_freelancer_status'] = $this->request->getPost('module_freelancer_status');
        } elseif ($this->registry->get('module_freelancer_status')) {
            $data['module_freelancer_status'] = $this->registry->get('module_freelancer_status');
        } else {
            $data['module_freelancer_status'] = 0;
        }

        if ($this->request->getPost('module_freelancer_limit')) {
            $data['module_freelancer_limit'] = $this->request->getPost('module_freelancer_limit');
        } elseif ($this->registry->get('module_freelancer_limit')) {
            $data['module_freelancer_limit'] = $this->registry->get('module_freelancer_limit');
        } else {
            $data['module_freelancer_limit'] = 8;
        }

        $this->document->output('module/freelancer', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'module/freelancer')) {
            $this->session->setFlashdata('error_warning', lang('module/freelancer.error_permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
