<?php namespace Admin\Controllers\Extension;

use \Admin\Models\Setting\ExtensionModel;
use \Admin\Models\User\UserGroupModel;
use \Admin\Models\Setting\SettingModel;

class Report extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/report.list.heading_title'));

        $extensionModel = new ExtensionModel();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/report.list.heading_title'));

        $extensionModel = new ExtensionModel();

        if ($this->validateForm()) {
            $extensionModel->install('report', $this->request->getVar('extension'));

            $userGroupModel = new UserGroupModel();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/report/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/report/' . $this->request->getVar('extension'));
            // Call install Method is exists
            // $reportsModel = new reportModel();
            // if (method_exists($reportsModel, 'install')) {
            //     $reportsModel->install();
            // }

            $this->session->setFlashdata('success', lang('extension/report.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('extension/report.list.heading_title'));

        $extensionModel = new ExtensionModel();

        if ($this->validateForm()) {
            $extensionModel->uninstall('report', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            // $reportsModel = new ReportModel();
            // if (method_exists($reportsModel, 'uninstall')) {
            //     $reportsModel->uninstall();
            // }

            $this->session->setFlashdata('success', lang('extension/report.text_success'));
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

        $extensionModel = new ExtensionModel();

        $installedExtensions = $extensionModel->getInstalled('report');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Report/' . ucfirst($value) . '.php')) {
                $extensionModel->uninstall('report', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Report', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                $data['extensions'][] = [
                    'name'       => lang('report/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('report_' . strtolower($basename) . '_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/report/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/report/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extensions/report/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $this->document->output('extension/report', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/report')) {
            $this->session->setFlashdata('warning', lang('extension/report.error_permission'));
            return false;
        }
        return true;
    }
    
    // --------------------------------------------------------------
}
