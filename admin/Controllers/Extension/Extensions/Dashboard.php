<?php namespace Admin\Controllers\Extension\Extensions;

use Admin\Models\Setting\Extensions;

class Dashboard extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/extensions/dashboard.list.heading_title'));

        $this->extensions = new Extensions();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/extensions/dashboard.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->install('dashboard', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extension/dashboard/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extension/dashboard/' . $this->request->getVar('extension'));

            $setting_model = new \Admin\Models\Setting\Settings();
            $dashboard_data = array(
                'dashboard_' . $this->request->getVar('extension') . '_status' => 1,
                'dashboard_' . $this->request->getVar('extension') . '_width' => 30,
                'dashboard_' . $this->request->getVar('extension') .  '_sort_order' => 0,
            );
            $setting_model->editSetting('dashboard_' . $this->request->getVar('extension'), $dashboard_data);

            $this->session->setFlashdata('success', lang('extension/extensions/dashboard.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->uninstall('dashboard', $this->request->getVar('extension'));
            $this->session->setFlashdata('success', lang('extension/extensions/dashboard.text_success'));
        }

        $this->getList();
    }

    protected function getList()
    {        
        
        if ($this->session->getFlashdata('warning')) {
            $data['error_warning'] = $this->session->getFlashdata('warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $installedExtensions = $this->extensions->getInstalled('dashboard');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Controllers/Extension/Dashboard/' . $value . '.php')) {
                $this->extensions->uninstall('dashboard', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = array();
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Controllers/Extension/Dashboard', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = array(
                    'name'       => lang('extension/dashboard/' . strtolower($basename) . '.list.heading_title'),
                    'width'      => $this->registry->get('dashboard_' . strtolower($basename) . '_width'),
                    'status'     => ($this->registry->get('dashboard_' . strtolower($basename) . '_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'sort_order' => $this->registry->get('dashboard_' . strtolower($basename) . '_sort_order'),
                    'install'    => base_url('index.php/extension/extensions/dashboard/install?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/extensions/dashboard/uninstall?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extension/dashboard/' . strtolower($basename) .'?user_token=' . $this->session->get('user_token')),
                );
            }
        }

        $this->document->output('extension/extensions/dashboard', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/extensions/dashboard')) {
            $this->session->setFlashdata('warning', lang('extension/extensions/dashboard.error_permission'));
            return false;
        } 
        return true;
    }

    // --------------------------------------------------------------
}
