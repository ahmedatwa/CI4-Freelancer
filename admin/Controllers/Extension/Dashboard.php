<?php namespace Admin\Controllers\Extension;

use Admin\Models\Setting\Extensions;

class Dashboard extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/dashboard.list.heading_title'));

        $extensionsModel = new Extensions();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/dashboard.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->install('dashboard', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/dashboard/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/dashboard/' . $this->request->getVar('extension'));

            $settingModel = new \Admin\Models\Setting\Settings();
            $dashboard_data = [
                'dashboard_' . $this->request->getVar('extension') . '_status' => 1,
                'dashboard_' . $this->request->getVar('extension') . '_width' => 6,
                'dashboard_' . $this->request->getVar('extension') .  '_sort_order' => 0,
            ];
            
            $settingModel->editSetting('dashboard_' . $this->request->getVar('extension'), $dashboard_data);

            $this->session->setFlashdata('success', lang('extension/dashboard.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->uninstall('dashboard', $this->request->getVar('extension'));
            $this->session->setFlashdata('success', lang('extension/dashboard.text_success'));
        }

        $this->getList();
    }

    protected function getList()
    {      
        $extensionsModel = new Extensions();  
        
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

        $installedExtensions = $extensionsModel->getInstalled('dashboard');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Dashboard/' . $value . '.php')) {
                $extensionsModel->uninstall('dashboard', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = array();
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Dashboard', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = array(
                    'name'       => lang('dashboard/' . strtolower($basename) . '.list.heading_title'),
                    'width'      => $this->registry->get('dashboard_' . strtolower($basename) . '_width'),
                    'status'     => ($this->registry->get('dashboard_' . strtolower($basename) . '_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'sort_order' => $this->registry->get('dashboard_' . strtolower($basename) . '_sort_order'),
                    'install'    => base_url('index.php/extension/dashboard/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/dashboard/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extensions/dashboard/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                );
            }
        }

        $this->document->output('extension/dashboard', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/dashboard')) {
            $this->session->setFlashdata('warning', lang('extension/dashboard.error_permission'));
            return false;
        } 
        return true;
    }

    // --------------------------------------------------------------
}
