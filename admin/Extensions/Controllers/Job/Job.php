<?php namespace Admin\Controllers\Extension\Job;

class Job extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->jobs = new \Admin\Models\Extension\Job\Jobs();

        $this->document->setTitle(lang('extension/job/job.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('extension/job/job.list.text_add'));

        $this->jobs = new \Admin\Models\Extension\Job\Jobs();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->jobs->addJob($this->request->getPost());
            return redirect()->to(base_url('index.php/extension/job/job?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('job/job.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('extension/job/job.list.text_edit'));

        $this->jobs = new \Admin\Models\Extension\Job\Jobs();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->jobs->editJob($this->request->getVar('job_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/extension/job/job?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('job/job.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = array();

        $this->jobs = new \Admin\Models\Extension\Job\Jobs();
   
        $this->document->setTitle(lang('extension/job/job.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $job_id) {
                $this->jobs->deleteJob($job_id);
                $json['success'] = lang('job/job.text_success');
                $json['redirect'] = 'index.php/extension/job/job?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('job/job.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('extension/job/job.list.heading_title'),
            'href' => base_url('index.php/extension/job/job?user_token=' . $this->session->get('user_token')),
        );

        // Data
        $data['jobs'] = array();
        $results = $this->jobs->getJobs();

        foreach ($results as $result) {
            if ($result['type'] == 1) {
                $type = lang('extension/job/job.list.text_full_time');
            } elseif ($result['type'] == 2) {
                $type = lang('extension/job/job.list.text_part_time');
            } elseif ($result['type'] == 3) {
                $type = lang('extension/job/job.list.text_intern');
            } else {
                $type = lang('extension/job/job.list.text_temporary');
            }
            
            $data['jobs'][] = array(
                'job_id'    => $result['job_id'],
                'name'      => $result['name'],
                'type'      => $type,
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'       => base_url('index.php/extension/job/job/edit?user_token=' . $this->session->get('user_token') . '&job_id=' . $result['job_id']),
                'delete'     => base_url('index.php/extension/job/job/delete?user_token=' . $this->session->get('user_token') . '&job_id=' . $result['job_id']),
            );
        }

        $data['add'] = base_url('index.php/extension/job/job/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/extension/job/job/delete?user_token=' . $this->session->get('user_token'));
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=bid');

        $data['user_token'] = $this->request->getGet('user_token');


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

        $this->document->output('extension/job/job_list', $data);
    }

    protected function getForm()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('extension/job/job.list.heading_title'),
            'href' => base_url('index.php/extension/job/job/edit?user_token=' . $this->session->get('user_token')),
        );

        $data['text_form'] = !$this->request->getGet('job_id') ? lang('extension/job/job.list.text_add') : lang('extension/job/job.list.text_edit');

        $data['cancel'] = base_url('index.php/extension/job/job?user_token=' . $this->session->get('user_token'));

        $data['user_token'] = $this->request->getGet('user_token');

        if (!$this->request->getGet('job_id')) {
            $data['action'] = base_url('index.php/extension/job/job/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/extension/job/job/edit?user_token=' . $this->session->get('user_token') . '&job_id=' . $this->request->getGet('job_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getGet('job_id') && ($this->request->getMethod() != 'post')) {
            $job_info = $this->jobs->getJob($this->request->getGet('job_id'));
        }

        if (isset($job_info['job_id'])) {
            $data['job_id'] = $job_info['job_id'];
        } else {
            $data['job_id'] = $this->request->getVar('job_id');
        }
        

        if ($this->request->getPost('job_description')) {
            $data['job_description'] = $this->request->getPost('job_description');
        } elseif (!empty($this->request->getVar('job_id'))) {
            $data['job_description'] = $this->jobs->getJobDescription($this->request->getVar('job_id'));
        } else {
            $data['job_description'] = '';
        }

        if ($this->request->getPost('type')) {
            $data['type'] = $this->request->getPost('type');
        } elseif (!empty($job_info)) {
            $data['type'] = $job_info['type'];
        } else {
            $data['type'] = '';
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($job_info)) {
            $data['sort_order'] = $job_info['sort_order'];
        } else {
            $data['sort_order'] = '';
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
        $customers_model = new \Admin\Models\Customer\Customers();
        $data['employers'] = $customers_model->getCustomers();

        if ($this->request->getPost('employer_id')) {
            $data['employer_id'] = $this->request->getPost('employer_id');
        } elseif (!empty($job_info)) {
            $data['employer_id'] = $job_info['employer_id'];
        } else {
            $data['employer_id'] = 0;
        }

        // Seo Urls
        $seo_url = new \Admin\Models\Design\Seo_urls();

        if ($this->request->getPost('seo_url')) {
            $data['seo_url'] = $this->request->getPost('seo_url');
        } elseif ($this->request->getGet('job_id')) {
            $data['seo_url'] = $seo_url->getKeywordByQuery('job_id=' . $this->request->getGet('job_id'));
        } else {
            $data['seo_url'] = array();
        }

        $this->document->output('extension/job/job_form', $data);
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

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('job/job.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('job/job.error_permission'));
            return false;
        } else {
            return true;
        }
    }
        
    //--------------------------------------------------------------------
}
