<?php namespace Extensions\Controllers\Job;

use \Extensions\Models\Job\JobModel;
use \Admin\Models\Customer\Customers;

class Job extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $jobModel = new JobModel();

        $this->document->setTitle(lang('job/job.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('job/job.list.heading_title'));

        $jobModel = new JobModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $jobModel->addJob($this->request->getPost());
            return redirect()->to(base_url('index.php/extensions/job/job?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('job/job.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('job/job.list.heading_title'));

        $jobModel = new JobModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $jobModel->editJob($this->request->getVar('job_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/extensions/job/job?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('job/job.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $jobModel = new JobModel();
   
        $this->document->setTitle(lang('extension/job/job.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $job_id) {
                $jobModel->deleteJob($job_id);
                $json['success'] = lang('job/job.text_success');
                $json['redirect'] = 'index.php/extensions/job/job?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('job/job.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('job/job.list.heading_title'),
            'href' => base_url('index.php/extensions/job/job?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['jobs'] = [];

        $jobModel = new JobModel();

        $results = $jobModel->getJobs();

        foreach ($results as $result) {
            if ($result['type'] == 1) {
                $type = lang('job/job.list.text_full_time');
            } elseif ($result['type'] == 2) {
                $type = lang('job/job.list.text_part_time');
            } elseif ($result['type'] == 3) {
                $type = lang('job/job.list.text_intern');
            } else {
                $type = lang('job/job.list.text_temporary');
            }
            
            $data['jobs'][] = [
                'job_id' => $result['job_id'],
                'name'   => $result['name'],
                'type'   => $type,
                'status' => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'   => base_url('index.php/extensions/job/job/edit?user_token=' . $this->request->getVar('user_token') . '&job_id=' . $result['job_id']),
                'delete' => base_url('index.php/extensions/job/job/delete?user_token=' . $this->request->getVar('user_token') . '&job_id=' . $result['job_id']),
            ];
        }

        $data['add']    = base_url('index.php/extensions/job/job/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/extensions/job/job/delete?user_token=' . $this->request->getVar('user_token'));
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=job');

        $data['user_token'] = $this->request->getVar('user_token');


        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $this->document->moduleOutput('Extensions', 'job/job_list', $data);
    }

    protected function getForm()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('job/job.list.heading_title'),
            'href' => base_url('index.php/extensions/job/job/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('job_id') ? lang('job/job.list.text_add') : lang('job/job.list.text_edit');

        $data['cancel'] = base_url('index.php/extensions/job/job?user_token=' . $this->request->getVar('user_token'));

        $data['user_token'] = $this->request->getVar('user_token');

        if (!$this->request->getVar('job_id')) {
            $data['action'] = base_url('index.php/extensions/job/job/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/extensions/job/job/edit?user_token=' . $this->request->getVar('user_token') . '&job_id=' . $this->request->getVar('job_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $jobModel = new JobModel();

        if ($this->request->getVar('job_id') && ($this->request->getMethod() != 'post')) {
            $job_info = $jobModel->getJob($this->request->getVar('job_id'));
        }

        if (isset($job_info['job_id'])) {
            $data['job_id'] = $job_info['job_id'];
        } else {
            $data['job_id'] = $this->request->getVar('job_id');
        }
        

        if ($this->request->getPost('job_description')) {
            $data['job_description'] = $this->request->getPost('job_description');
        } elseif (!empty($this->request->getVar('job_id'))) {
            $data['job_description'] = $jobModel->getJobDescription($this->request->getVar('job_id'));
        } else {
            $data['job_description'] = '';
        }

        if ($this->request->getPost('type')) {
            $data['type'] = $this->request->getPost('type');
        } elseif (!empty($job_info)) {
            $data['type'] = $job_info['type'];
        } else {
            $data['type'] = 1;
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($job_info)) {
            $data['sort_order'] = $job_info['sort_order'];
        } else {
            $data['sort_order'] = 0;
        }

        if ($this->request->getPost('salary')) {
            $data['salary'] = $this->request->getPost('salary');
        } elseif (!empty($job_info)) {
            $data['salary'] = $job_info['salary'];
        } else {
            $data['salary'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($job_info)) {
            $data['status'] = $job_info['status'];
        } else {
            $data['status'] = 1;
        }

        // Employer
        $customerModel = new Customers();
        $data['customers'] = $customerModel->getCustomers();

        if ($this->request->getPost('customer_id')) {
            $data['customer_id'] = $this->request->getPost('customer_id');
        } elseif (!empty($job_info)) {
            $data['customer_id'] = $job_info['employer_id'];
        } else {
            $data['customer_id'] = 0;
        }

        $this->document->moduleOutput('Extensions', 'job/job_form', $data);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('job_description') as $language_id => $value) {
            if (! $this->validate([
                    "job_description.name" => [
                    'label' => 'Job Name',
                    'rules' => 'required|min_length[3]|max_length[64]'
                ],
                "job_description.description" => [
                    'label' => 'Job Description',
                    'rules' => 'required|min_length[3]'
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', 'extensions/job/job')) {
            $this->session->setFlashdata('error_warning', lang('job/job.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'extensions/job/job')) {
            $this->session->setFlashdata('error_warning', lang('job/job.error_permission'));
            return false;
        } else {
            return true;
        }
    }
        
    //--------------------------------------------------------------------
}
