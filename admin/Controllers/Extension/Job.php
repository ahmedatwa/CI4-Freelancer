<?php namespace Admin\Controllers\Extension;

use \Admin\Models\Setting\Extensions;
use \Extensions\Models\Job\JobModel;
use \Admin\Models\User\Users_group;
use \Admin\Models\Setting\Settings;

class Job extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/job.list.heading_title'));

        $extensionsModel = new Extensions();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/job.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->install('job', $this->request->getVar('extension'));

            $userGroupModel = new Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/job/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/job/' . $this->request->getVar('extension'));

            $settingModel = new Settings();
            $settingModel->editSetting('job_extension', ['job_extension_status' => 1]);
            // Call install Method is exists
            $jobModel = new JobModel();
            if (method_exists($jobModel, 'install')) {
                $jobModel->install();
            }

            $this->session->setFlashdata('success', lang('extension/job.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->uninstall('job', $this->request->getVar('extension'));

            // Call uninstall Method is exists
            $jobModel = new JobModel();
            if (method_exists($jobModel, 'uninstall')) {
                $jobModel->uninstall();
            }

            $settingModel = new Settings();
            $settingModel->editSetting('job_extension', ['job_extension_status' => 0]);

            $this->session->setFlashdata('success', lang('extension/job.text_success'));
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

        $installedExtensions = $extensionsModel->getInstalled('job');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Job/' . ucfirst($value) . '.php')) {
                $extensionsModel->uninstall('job', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Job', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = [
                    'name'       => lang('job/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('job_extension_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/job/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/job/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extensions/job/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $this->document->output('extension/job', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/job')) {
            $this->session->setFlashdata('warning', lang('extension/job.error_permission'));
            return false;
        } 
        return true;
    }
    
    // --------------------------------------------------------------
}