<?php namespace Catalog\Controllers\Account;

use \Catalog\Models\Extension\Job\JobModel;
use \Catalog\Models\Tool\DownloadModel;

class Jobs extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $this->template->setTitle(lang('account/jobs.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => base_url('account/dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/jobs.heading_title'),
            'href' => base_url('account_project'),
        ];

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        $data['heading_title'] = lang('account/jobs.heading_title');

        $data['customer_id'] = $customer_id;

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/jobs', $data);
    }

    public function getApplicantJobs()
    {
        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'p.date_added';
        }

        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = $this->registry->get('theme_default_projects_limit') ?? 15;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
        'customer_id'  => $customer_id,
         'sort_by'     => $sort_by,
         'order_by'    => $order_by,
         'limit'       => $limit,
         'start'       => ($page - 1) * $limit,
        ];

        $data['jobs'] = [];

        $jobModel = new JobModel();
        $results = $jobModel->getApplicantJobs($filter_data);
        $total = $jobModel->getTotalApplicantJobs($filter_data);
        

        foreach ($results as $result) {
            switch ($result['type']) {
                case 1:
                    $type = lang('extension/job/job.text_full_time');
                    break;
                case 2:
                    $type = lang('extension/job/job.text_part_time');
                    break;
                case 3:
                    $type = lang('extension/job/job.text_intern');
                    break;
                case 4:
                    $type = lang('extension/job/job.text_temporary');
                    break;
                default:
                    $type = lang('extension/job/job.text_full_time');
                    break;
            }

            switch ($result['status']) {
                case 1:
                    $status = lang('extension/job/job.text_under_review');
                    break;
                case 2:
                    $status = lang('extension/job/job.text_screened');
                    break;
                case 3:
                    $status = lang('extension/job/job.text_short_listed');
                    break;
                default:
                    $status = lang('extension/job/job.text_under_review');
                    break;
            }

            $data['jobs'][] = [
                'job_id'     => $result['job_id'],
                'name'       => $result['name'],
                'status'     => $status,
                'type'       => $type,
                'customer'   => $result['customer'],
                'salary'     => ($result['salary'] > 0) ? $this->currencyFormat($result['salary']) : 'Not Disclosed',
                'date_added' => $this->dateDifference($result['date_added']),

            ];
        }

        $data['column_name'] = lang('freelancer/project.column_name');

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        echo view('extension/job/applicant_job_list', $data);
    }

    public function getEmployerJobs()
    {
        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'p.date_added';
        }

        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = $this->registry->get('theme_default_projects_limit') ?? 15;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
         'customer_id' => $customer_id,
         'sort_by'     => $sort_by,
         'order_by'    => $order_by,
         'limit'       => $limit,
         'start'       => ($page - 1) * $limit,
        ];

        $data['jobs'] = [];

        $jobModel = new JobModel();
        $results = $jobModel->getRecruiterJobs($filter_data);
        $total = $jobModel->getTotalRecruiterJobs($filter_data);
        

        foreach ($results as $result) {
            switch ($result['type']) {
                case 1:
                    $type = lang('extension/job/job.text_full_time');
                    break;
                case 2:
                    $type = lang('extension/job/job.text_part_time');
                    break;
                case 3:
                    $type = lang('extension/job/job.text_intern');
                    break;
                case 4:
                    $type = lang('extension/job/job.text_temporary');
                    break;
                default:
                    $type = lang('extension/job/job.text_full_time');
                    break;
            }

            switch ($result['status']) {
                case 0:
                    $status = lang('extension/job/job.text_ceased');
                    break;
                case 1:
                    $status = lang('extension/job/job.text_open');
                    break;
                case 2:
                    $status = lang('extension/job/job.text_ceased');
                    break;
                default:
                    $status = lang('extension/job/job.text_under_review');
                    break;
            }

            $data['jobs'][] = [
                'job_id'     => $result['job_id'],
                'name'       => $result['name'],
                'status'     => $status,
                'type'       => $type,
                'total'      => $jobModel->getTotalApplicantsByJobID($result['job_id']),
                'customer'   => $result['customer'],
                'salary'     => ($result['salary'] > 0) ? $this->currencyFormat($result['salary']) : 'Not Disclosed',
                'date_added' => $this->dateDifference($result['date_added']),
                'view'       => base_url('account/jobs/getJobCandidatesList?job_id=') . $result['job_id'] . '&employer_id=' . $result['employer_id'],
            ];
        }

        $data['column_name'] = lang('freelancer/project.column_name');

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        echo view('extension/job/employer_job_list', $data);
    }

    public function getJobCandidatesList()
    {
        $this->template->setTitle(lang('Manage Candidates'));

        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        if ($this->request->getVar('job_id')) {
            $job_id = $this->request->getVar('job_id');
        } else {
            $job_id = 0;
        }

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'p.date_added';
        }

        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = $this->registry->get('theme_default_projects_limit') ?? 15;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
         'job_id'      => $job_id,
         'employer_id' => $customer_id,
         'sort_by'     => $sort_by,
         'order_by'    => $order_by,
         'limit'       => $limit,
         'start'       => ($page - 1) * $limit,
        ];

        $data['candidates'] = [];

        $jobModel = new JobModel();
        $downloadModel = new DownloadModel();

        $results = $jobModel->getJobCandidates($filter_data);
        $total = $jobModel->getTotalJobCandidates($filter_data);
        
        foreach ($results as $result) {

            switch ($result['status']) {
                case 1:
                    $status = lang('extension/job/job.text_under_review');
                    break;
                case 2:
                    $status = lang('extension/job/job.text_screened');
                    break;
                case 3:
                    $status = lang('extension/job/job.text_short_listed');
                    break;
                default:
                    $status = lang('extension/job/job.text_under_review');
                    break;
            }

            $data['candidates'][] = [
                'job_applicant_id' => $result['job_applicant_id'],
                'job_id'           => $result['job_id'],
                'name'             => $result['name'],
                'email'            => $result['email'],
                'status'           => $status,
                'download'         => base_url('tool/download?download_id=' . $result['download_id']),
                'date_added'       => lang('en.mediumDate', [strtotime($result['date_added'])]),
            ];
        }

        $data['job_name'] = $jobModel->getJobNameByID($job_id);
        $data['total_candidates'] = $jobModel->getTotalApplicantsByJobID($job_id);

        $data['text_under_review'] = lang('extension/job/job.text_under_review');
        $data['text_screened'] = lang('extension/job/job.text_screened');
        $data['text_short_listed'] = lang('extension/job/job.text_short_listed');

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');
        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        $this->template->output('extension/job/candidates_list', $data);
    }

    public function setJobApplicationStatus()
    {
        $json = [];
        if ($this->request->getMethod() == 'post')
        {
            $jobModel = new JobModel();
            $jobModel->setApplicantStatus($this->request->getPost('job_applicant_id'), $this->request->getPost('status'));
            $json['success'] = lang('Success! Job Application status has been changed.');
        }
        return $this->response->setJSON($json);
    }

    public function add()
    {
        $json = [];
        
        if ($this->request->getMethod() == 'post') {
            $jobModel = new JobModel();

            if (! $this->validate([
                'job_description.name' => [
                    'label' => 'Job Name',
                    'rules' => 'required',
                ],
                'job_description.description' => [
                    'label' => 'Job Description',
                    'rules' => 'required',
                ],
                'job_description.meta_keyword' => [
                    'label' => 'Job Tags',
                    'rules' => 'required',
                ],
            ])) {
                $json['error'] = $this->validator->getErrors();
            }

            if (! $json) {
                $jobModel->addJob($this->request->getPost());
                $json['success'] = lang('extension/job/job.text_success');
            }
        }
        return $this->response->setJSON($json);
    }

    public function ceaseJob()
    {
        $json = [];
        if ($this->request->getMethod() == 'post') {
            $jobModel = new JobModel();
            $jobModel->update($this->request->getVar('job_id'), ['status' => 0]);
            $json['success'] = 'Success! Job has been ceased';
        }
        return $this->response->setJSON($json);
    }


    //--------------------------------------------------------------------
}
