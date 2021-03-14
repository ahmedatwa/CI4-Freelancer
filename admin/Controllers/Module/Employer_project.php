<?php 

namespace Admin\Controllers\Module;

use Admin\Controllers\BaseController;
use Admin\Models\Setting\SettingModel;
use Admin\Models\Setting\ModuleModel;

class Employer_project extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('employer_project.list.heading_title'));

        $settingModel = new SettingModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $settingModel->editSetting('module_employer_project', $this->request->getPost());

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
            'text' => lang('module/employer_project.list.text_module'),
            'href' => base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (! $this->request->getVar('module_id')) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/employer_project.list.heading_title'),
                'href' => base_url('index.php/module/employer_project?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => base_url('index.php/module/employer_project?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        if (! $this->request->getVar('module_id')) {
            $data['action'] = base_url('index.php/module/employer_project?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/module/employer_project?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
        }

        $data['cancel'] = base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('module_employer_project_status')) {
            $data['module_employer_project_status'] = $this->request->getPost('module_employer_project_status');
        } elseif ($this->registry->get('module_employer_project_status')) {
            $data['module_employer_project_status'] = $this->registry->get('module_employer_project_status');
        } else {
            $data['module_employer_project_status'] = '';
        }

        if ($this->request->getPost('module_employer_project_limit')) {
            $data['module_employer_project_limit'] = $this->request->getPost('module_employer_project_limit');
        } elseif ($this->registry->get('module_employer_project_limit')) {
            $data['module_employer_project_limit'] = $this->registry->get('module_employer_project_limit');
        } else {
            $data['module_employer_project_limit'] = '';
        }

        $this->document->output('module/employer_project', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'module/employer_project')) {
            $this->session->setFlashdata('error_warning', lang('module/employer_project.error_permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
