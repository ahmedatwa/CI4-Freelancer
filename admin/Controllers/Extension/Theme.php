<?php namespace Admin\Controllers\Extension;

use Admin\Models\Setting\Extensions;

class Theme extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/theme.list.heading_title'));

        $extensionsModel = new Extensions();

        $this->getList();
    }

    public function install()
    {
        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            
            $extensionsModel->install('theme', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/theme/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/theme/' . $this->request->getVar('extension'));

            $this->session->setFlashdata('success', lang('extension/theme.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('extension/theme.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->uninstall('theme', $this->request->getVar('extension'));

            $this->session->setFlashdata('success', lang('extension/theme.text_success'));
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

        $installedExtensions = $extensionsModel->getInstalled('theme');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Theme/' . $value . '.php')) {
                $extensionsModel->uninstall('theme', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = array();
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Theme', 1);

        $data['extensions'] = [];
        
        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');

                $data['extensions'][] = [
                    'name'      => lang('theme/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('theme_default_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'   => base_url('index.php/extension/theme/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall' => base_url('index.php/extension/theme/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed' => in_array(strtolower($basename), $installedExtensions),
                    'edit'      => base_url('index.php/extensions/theme/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $this->document->output('extension/theme', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/theme')) {
            $this->session->setFlashdata('warning', lang('extension/theme.error_permission'));
            return false;
        }
        return true;
    }

    // -----------------------------------------------------------
}
