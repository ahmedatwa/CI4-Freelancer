<?php namespace Admin\Controllers\Extension\Extensions;

use Admin\Models\Setting\Extensions;

class Job extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/extensions/job.list.heading_title'));

        $this->extensions = new Extensions();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/extensions/job.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->install('job', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extension/job/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extension/job/' . $this->request->getVar('extension'));

            $setting_model = new \Admin\Models\Setting\Settings();
            $job_data = ['job_status' => 1];
            $setting_model->editSetting('job', $job_data);
            // Call install Method is exists
            $job_model = new \Admin\Models\Extension\Job\Jobs();
            if (method_exists($job_model, 'install')) {
                $job_model->install();
            }

            $this->session->setFlashdata('success', lang('extension/extensions/job.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->uninstall('job', $this->request->getVar('extension'));

            // Call uninstall Method is exists
            $job_model = new \Admin\Models\Extension\Job\Jobs();
            if (method_exists($job_data, 'install')) {
                $job_model->uninstall();
            }

            $this->session->setFlashdata('success', lang('extension/extensions/job.text_success'));
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

        $installedExtensions = $this->extensions->getInstalled('job');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Controllers/Extension/job/' . $value . '.php')) {
                $this->extensions->uninstall('job', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = array();
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Controllers/Extension/job', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = array(
                    'name'       => lang('extension/job/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('job_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/extensions/job/install?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/extensions/job/uninstall?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extension/job/' . strtolower($basename) .'?user_token=' . $this->session->get('user_token')),
                );
            }
        }

        $this->document->output('extension/extensions/job', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/extensions/job')) {
            $this->session->setFlashdata('warning', lang('extension/extensions/job.error_permission'));
            return false;
        } 
        return true;
    }
    
    // --------------------------------------------------------------
}
