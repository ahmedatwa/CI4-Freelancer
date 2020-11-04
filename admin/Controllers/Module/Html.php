<?php namespace Admin\Controllers\Module;

use \Admin\Models\Setting\Modules;

class Html extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('module/html.list.heading_title'));

        $modules = new Modules();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            if (! $this->request->getVar('module_id')) {
                $modules->addModule('html', $this->request->getPost());
            } else {
                $modules->editModule($this->request->getVar('module_id'), $this->request->getPost());
            }

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
            'text' => lang('module/html.list.text_extension'),
            'href' => base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/html.list.heading_title'),
                'href' => base_url('index.php/module/html?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => base_url('index.php/module/html?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        if (! $this->request->getVar('module_id')) {
            $data['action'] = base_url('index.php/module/html?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/module/html?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
        }

        $data['cancel'] = base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getVar('module_id') && ($this->request->getMethod() != 'post')) {
            $module_info = $modules->getModule($this->request->getVar('module_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('module_description')) {
            $data['module_description'] = $this->request->getPost('module_description');
        } elseif (!empty($module_info)) {
            $data['module_description'] = $module_info['module_description'];
        } else {
            $data['module_description'] = [];
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        $this->document->output('module/html', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name'   => 'required|min_length[3]|max_length[64]',
            ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }

        if (!$this->user->hasPermission('modify', 'module/html')) {
            $this->session->setFlashdata('error_warning', lang('module/html.error_permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
