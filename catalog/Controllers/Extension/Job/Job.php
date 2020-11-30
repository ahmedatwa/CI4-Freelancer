<?php namespace Catalog\Controllers\Extension\Job;

use \Catalog\Models\Extension\Job\JobModel;
use \Catalog\Models\Account\CustomerModel;

class Job extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $jobModel = new JobModel();
        $seoUrl = service('seo_url');

        $this->template->setTitle(lang('extension/job/job.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/job/job.heading_title'),
            'href' => '',
        ];

        if ($this->request->getVar('type')) {
            $filter_type = explode('_', $this->request->getVar('type'));
        } else {
            $filter_type = [];
        }

        if ($this->request->getVar('tags')) {
            $filter_tags = str_replace('_', ',', $this->request->getVar('tags'));
        } else {
            $filter_tags = '';
        }

        if ($this->request->getVar('keyword')) {
            $filter_keyword = $this->request->getVar('keyword');
        } else {
            $filter_keyword = null;
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

        helper('text');

        $filter_data = [
             'filter_type'        => $filter_type,
             'filter_keyword'     => $filter_keyword,
             'filter_tags'        => $filter_tags,
             'sort_by'            => $sort_by,
             'order_by'           => $order_by,
             'limit'              => $limit,
             'start'              => ($page - 1) * $limit,
        ];
    
        $data['jobs'] = [];
        
        $results = $jobModel->getJobs($filter_data);
        $total = $jobModel->getTotalJobs($filter_data);

        foreach ($results as $result) {
            // SEO Query
            $keyword = $seoUrl->getKeywordByQuery('job_id=' . $result['job_id']);

            if ($result['type'] == 1) {
                $type = lang('extension/job/job.text_full_time');
            } elseif ($result['type'] == 2) {
                $type = lang('extension/job/job.text_part_time');
            } elseif ($result['type'] == 3) {
                $type = lang('extension/job/job.text_intern');
            } else {
                $type = lang('extension/job/job.text_temporary');
            }

            $data['jobs'][] = [
                'project_id'  => $result['job_id'],
                'name'        => $result['name'],
                'description' => ($result['description']) ? word_limiter($result['description'], 100) : '',
                'meta_keyword'=> ($result['meta_keyword']) ? explode(',', $result['meta_keyword']) : '',
                'type'        => $type,
                'date_added'  => lang('en.mediumDate', [strtotime($result['date_added'])]),
                'href'        => ($keyword) ? route_to('local_job', $result['job_id'], $keyword) : base_url('extension/job/job?job_id=' . $result['job_id']),
            ];
        }

        
        $uri = $this->request->uri;
 
        $data['sorts'] = [];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_newest'),
            'value' => 'j.date_added-ASC',
            'href'  => $uri->addQuery('sort_by', 'date_added')->addQuery('order_by', 'ASC')
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_oldest'),
            'value' => 'j.date_added-DESC',
            'href'  => $uri->addQuery('sort_by', 'date_added')->addQuery('order_by', 'DESC')
        ];


        $data['types'] = [];

        $data['types'][] = [
            'id'    => 1,
            'value' => 1,
            'text'  => lang('extension/job/job.text_full_time'),
        ];
        $data['types'][] = [
            'id'    => 2,
            'value' => 2,
            'text'  => lang('extension/job/job.text_part_time'),
        ];
        $data['types'][] = [
            'id'    => 3,
            'value' => 3,
            'text'  => lang('extension/job/job.text_intern'),
        ];
        $data['types'][] = [
            'id'    => 4,
            'value' => 4,
            'text'  => lang('extension/job/job.text_temporary'),
        ];


        $data['tags'] = [];
        

        $data['heading_title']       = lang('extension/job/job.heading_title');
        $data['text_search_keyword'] = lang('extension/job/job.text_search_keyword');
        $data['button_search']       = lang('extension/job/job.button_search');
        $data['text_found']          = lang('extension/job/job.text_found', [$total]);
        $data['text_sidebar']        = lang('extension/job/job.text_sidebar');
        $data['text_type']           = lang('extension/job/job.text_type');
        $data['text_tags']           = lang('extension/job/job.text_tags');
        $data['text_select']         = lang('en.text_select');

        $data['add_project'] = route_to('add-project') ? route_to('add-project') : base_url('project/project/add');

        $data['filter_type']    = $filter_type;
        $data['filter_tags']    = $filter_tags;
        $data['filter_keyword'] = $filter_keyword;
        $data['sort_by']        = $sort_by;
        $data['order_by']       = $order_by;
        $data['limit']          = $limit;
        $data['page']           = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        $this->template->output('extension/job/job_list', $data);
    }

    // Single Project View
    public function info()
    {
        $jobModel = new jobModel();
        $seoUrl = service('seo_url');

        if ($this->request->uri->getSegment(4)) {
            $keyword = $this->request->uri->getSegment(4);
        } else {
            $keyword = '';
        }

        if ($this->request->getVar('job_id')) {
            $job_id = $this->request->getVar('job_id');
        } elseif ($this->request->uri->getSegment(3)) {
            $job_id = substr($this->request->uri->getSegment(3), 1);
        } else {
            $job_id = 0;
        }

        if ($this->session->getFlashdata('success')) {
        	$data['success'] = $this->session->getFlashdata('success');
        } else {
        	$data['success'] = '';
        }

        $this->template->setTitle($keyword .' | '. $this->registry->get('config_name'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/job/job.text_jobs'),
            'href' => route_to('local_jobs') ? route_to('local_jobs') : base_url('project/category'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $keyword ?? lang('extension/job/job.text_jobs'),
            'href' => '',
        ];

        if ($this->customer->isLogged()) {
            $data['freelancer_id'] = $this->customer->getCustomerId();
        } else {
            $data['freelancer_id'] = 0;
        }

        $data['logged']          = $this->customer->isLogged();
        $data['config_currency'] = $this->session->get('currency') ?? $this->registry->get('config_currency');
        $data['register']        = route_to('register') ? route_to('register') : base_url('acocunt/register');
        $data['add_project']     = route_to('add-project') ? route_to('add-project') : base_url('project/project/add');
        
        if ($job_id) {
            $job_info = $jobModel->getJob($job_id);
        } else {
            $job_info = [];
        }

        if ($job_info) {

            $data['job_id']        = $job_info['job_id'];
            $data['name']          = $job_info['name'];
            $data['tags']          = explode(',', $job_info['meta_keyword']);
            $data['description']   = $job_info['description'];
            $data['date_added']    = $this->dateDifference($job_info['date_added']);
            $data['salary']        = ($job_info['salary'] > 0) ? $this->currencyFormat($job_info['salary']) : 'Hidden';

            
            $data['employer']      = ($job_info['employer'] == '') ? $job_info['employer'] : '@' . $job_info['username'];
            //$data['employer_id'] = $job_info['employer_id'];
            $data['status']        = '';//$jobModel($project_info['project_id']);

            // type
            switch ($job_info['type']) {
                case 1:
                    $data['type'] = lang('extension/job/job.text_full_time');
                    break;
                case 2:
                    $data['type'] = lang('extension/job/job.text_part_time');
                    break;
                case 3:
                    $data['type'] = lang('extension/job/job.text_intern');
                    break;
                case 4:
                    $data['type'] = lang('extension/job/job.text_temporary');
                    break;    
                default:
                    $data['type'] = lang('extension/job/job.text_full_time');
                    break;
            }

            // Apply Job Modal
            if ($this->customer->getCustomerId()) {
                $customerModel = new CustomerModel();
                $data['alreadyApplied'] = $jobModel->alreadyApplied($this->customer->getCustomerId());
                $customer_info = $customerModel->find($this->customer->getCustomerId());
                $data['customer_id'] = $customer_info['customer_id'];
                $data['email']       = $customer_info['email'];
                $data['firstname']   = $customer_info['firstname'];
                $data['lastname']    = $customer_info['lastname'];
                $data['email']       = $customer_info['email'];
            } else {
                $data['alreadyApplied'] = false;
                $data['customer_id'] = 0;
                $data['email']       = '';
                $data['firstname']   = '';
                $data['lastname']    = '';
                $data['email']       = '';
            }

            // more Employer projects
            $data['categories'] = [];
            $data['other_projects'] = [];
            
            // $filter_data = [
            //     'start' => 0,
            //     'limit' => 5,
            //     'current_project' => $job_info['job_id']
            // ];

            // $other_projects = $jobModel->getProjects($filter_data);

            // foreach ($other_projects as $result) {
            //     $keyword = $seoUrl->getKeywordByQuery('project_id=' . $result['project_id']);
            //     $data['other_projects'][] = [
            //     'project_id'  => $result['project_id'],
            //     'name'        => $result['name'],
            //     'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
            //     'href'        => ($keyword) ? route_to('single_project', $keyword) : base_url('project/project/project?pid=' . $result['project_id']),
            // ];
            }
        

        $data['text_description'] = lang('extension/job/job.text_description');
        $data['button_apply'] = lang('extension/job/job.button_apply');

        // optional upgrades
        $data['config_upgrade_sponser'] = $this->registry->get('config_upgrade_sponser');
        $data['config_upgrade_highlight'] = $this->registry->get('config_upgrade_highlight');

        $data['isLogged'] = $this->customer->isLogged();
        $data['login'] = route_to('account_login');
        $this->session->set('redirect_url', current_url());

        // upload extensions allowed
        $file_ext_allowed = preg_replace('~\r?\n~', "\n", $this->registry->get('config_file_ext_allowed'));

        $filetypes = explode("\n", $file_ext_allowed);
        
        foreach ($filetypes as $filetype) {
            $data['allowedFileExtensions'][] = trim($filetype);
        }

        $this->template->output('extension/job/job_info', $data);
    }

    public function filter()
    {
        $json = [];

        if ($this->request->getVar('url')) {
            
            $uri = new \CodeIgniter\HTTP\URI($this->request->getVar('url'));

            if ($this->request->getPost('skills')) {
                $uri->addQuery('skills', $this->request->getPost('skills'));
            }

            if ($this->request->getPost('type')) {
                $uri->addQuery('type', $this->request->getPost('type'));
            }

            if ($this->request->getPost('clear')) {
                $uri->stripQuery($this->request->getPost('clear'));
            }

            $json['uri'] = (string) $uri;
        }
        
        return $this->response->setJSON($json);
    }

    public function apply()
    {
      $json = [];

      if ($this->request->getMethod() == 'post') {
          $jobModel = new JobModel();

          if (! $this->customer->isLogged()) {
               // Set the previous url in session
               $this->session->set('redirect_url', $this->request->getVar('uri'));
              $json['error']['login'] = sprintf(lang('extension/job/job.text_login'), route_to('account_login'), route_to('account_register'));
          }

         if (! $this->validate([
                'email' => 'required|valid_email',
                'firstname'  => 'required|alpha',
                'lastname'   => 'required|alpha',
                'download_id' => [
                    'label' => 'C.V', 
                    'rules' => 'required'
                ],
         ])) {
            $json['error']['validation'] = $this->validator->getErrors();
        }

        if (! $json) {

            $jobModel->insertApplicant($this->request->getPost());
            $json['success'] = lang('extension/job/job.text_apply_success');
        }

      }

      return $this->response->setJSON($json);
    }
   
    
    // --------------------------------------------------------------
}
