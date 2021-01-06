<?php namespace Catalog\Controllers\freelancer;

use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Account\CustomerModel;
use \Catalog\Models\Catalog\MileStoneModel;
use \Catalog\Models\Extension\Bid\BidModel;
use \Catalog\Models\Freelancer\BalanceModel;
use \Catalog\Models\Freelancer\FreelancerModel;
use \Catalog\Models\Freelancer\DisputeModel;

class Project extends \Catalog\Controllers\BaseController
{
    public function view()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $this->template->setTitle(lang('freelancer/project.text_my_projects'));

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

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
            'text' => lang('freelancer/project.text_view'),
            'href' => base_url('freelancer/project/view?pid=' . $project_id),
        ];

        $projectModel = new ProjectModel();

        if ($project_id) {
            $project_info = $projectModel->getProject($project_id);
        } else {
            $project_info = [];
        }

        $bidModel = new BidModel();

        if ($project_info) {
            $data['project_id']  = $project_info['project_id'];
            $data['name']        = $project_info['name'];
            $data['type']        = ($project_info['type'] == 1) ? 'Fixed Rate' : 'Hourly Rate';

            $data['days_left']   = lang('freelancer/project.text_expire', [$this->dateDifference($project_info['date_added'], $project_info['runtime'])]);
            $data['employer']    = $project_info['employer'];
            $data['employer_id'] = $project_info['employer_id'];
            $data['budget'] = $this->currencyFormat($project_info['budget_min']) . '-' . $this->currencyFormat($project_info['budget_max']);
            $data['total_bids'] = $bidModel->getTotalBidsByProjectId($project_id);
            // get Bid info
            $bid_info = $bidModel->getBidByProjectId($project_id);

            $data['bid_amount'] = ($bid_info['quote']) ? $this->currencyFormat($bid_info['quote']) : '';

            $customerModel = new CustomerModel();
            $freelancer_info = $customerModel->getCustomer($bid_info['freelancer_id']);

            $data['freelancer'] = $freelancer_info['username'] ?? '';

            $data['freelancer_id'] = $bid_info['freelancer_id'];

            $data['freelancer_profile'] = ($bid_info['freelancer_id']) ? route_to('freelancer_profile', $bid_info['freelancer_id'], $freelancer_info['username']) : '';

            $data['status'] = $projectModel->getStatusByProjectId($project_info['project_id']);
        }

        $data['heading_title'] = lang('project/project.text_my_projects');

        $data['upload'] = base_url('tool/upload');
        $data['customer_id'] = $customer_id;

        $data['initial_preview_data'] = $projectModel->getFilesByProjectId($project_id);

        $data['initial_preview_config_data'] = $projectModel->getFilesPreviewConfig($project_id);

        // upload extensions allowed
        $file_ext_allowed = preg_replace('~\r?\n~', "\n", $this->registry->get('config_file_ext_allowed'));

        $filetypes = explode("\n", $file_ext_allowed);
        
        foreach ($filetypes as $filetype) {
            $data['allowedFileExtensions'][] = trim($filetype);
        }

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');


        $this->template->output('freelancer/project_info', $data);
    }

    public function getInProgressProjects()
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
         'freelancer_id' => $customer_id,
         'status_id'   => '4',
         'sort_by'    => $sort_by,
         'order_by'   => $order_by,
         'limit'      => $limit,
         'start'      => ($page - 1) * $limit,
        ];

        $data['progress_projects'] = [];

        $projectModel = new ProjectModel();

        $results = $projectModel->getProjects($filter_data);
        $total = $projectModel->getTotalProjects($filter_data);

        foreach ($results as $result) {
            $data['progress_projects'][] = [
                'project_id'    => $result['project_id'],
                'freelancer_id' => $result['freelancer_id'],
                'employer_id'   => $result['employer_id'],
                'name'          => $result['name'],
                'budget'        => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'          => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'status'        => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'status_id'     => $result['status_id'],
                'view'          => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
        }

        $data['column_name']       = lang('freelancer/project.column_name');
        $data['column_project_id'] = lang('freelancer/project.column_project_id');
        $data['column_budget']     = lang('freelancer/project.column_budget');
        $data['column_type']       = lang('freelancer/project.column_type');
        $data['column_bids']       = lang('freelancer/project.column_bids');
        $data['column_avg_bids']   = lang('freelancer/project.column_avg_bids');
        $data['column_expiry']     = lang('freelancer/project.column_expiry');
        $data['column_status']     = lang('freelancer/project.column_status');
        $data['column_action']     = lang('freelancer/project.column_action');

        $data['config_project_completed_status'] = $this->registry->get('config_project_completed_status');
        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        return view('freelancer/progress_project_list', $data);
    }

        public function getPastProjects()
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
         'freelancer_id' => $customer_id,
         'status_id'   => '2',
         'sort_by'     => $sort_by,
         'order_by'    => $order_by,
         'limit'       => $limit,
         'start'       => ($page - 1) * $limit,
        ];

        $data['past_projects'] = [];

        $projectModel = new ProjectModel();
        $bidModel = new BidModel();
        $disputeModel = new DisputeModel();

        $results = $projectModel->getProjects($filter_data);
        $total = $projectModel->getTotalProjects($filter_data);

        foreach ($results as $result) {
            $paidStatus = $bidModel->where('project_id', $result['project_id'])->findColumn('status');

            if ($paidStatus[0] == 0) {
                $paid = lang('employer/project.text_unpaid');
            } elseif ($paidStatus[0] == 1) {
                $paid = lang('employer/project.text_paid');
            } else {
                $paid = lang('employer/project.text_partial');
            }
            
            $amount = $bidModel->where('project_id', $result['project_id'])->findColumn('quote');

            $inDispute =  $disputeModel->inDispute($result['project_id']);

            $data['past_projects'][] = [
                'project_id'    => $result['project_id'],
                'employer_id'   => $result['employer_id'],
                'freelancer_id'   => $result['freelancer_id'],
                'name'          => $result['name'],
                'budget'        => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'          => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'date_added'    => $this->dateDifference($result['date_added']),
                'amount'        => $amount[0],
                'paid'          => ($amount[0] == 0) ? '-' : $paid,
                'status'        => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'inDispute'     => $inDispute,

            ];
        }

        // Dispute Reasons
        $data['dispute_reasons'] = [];
        $disputeModel = new DisputeModel();
        $dispute_reasons = $disputeModel->getDisputeReasons();
        foreach ($dispute_reasons as $reason) {
            $data['dispute_reasons'][] = [
                'dispute_reason_id' => $reason['dispute_reason_id'],
                'name'              => $reason['name']
            ];
        }

        $data['column_name']       = lang('freelancer/project.column_name');
        $data['column_project_id'] = lang('freelancer/project.column_project_id');
        $data['column_budget']     = lang('freelancer/project.column_budget');
        $data['column_type']       = lang('freelancer/project.column_type');
        $data['column_bids']       = lang('freelancer/project.column_bids');
        $data['column_avg_bids']   = lang('freelancer/project.column_avg_bids');
        $data['column_status']     = lang('freelancer/project.column_status');
        $data['column_status']     = lang('freelancer/project.column_status');
        $data['column_amount']     = lang('freelancer/project.column_amount');
        $data['column_paid']       = lang('freelancer/project.column_paid');
        $data['column_action']     = lang('freelancer/project.column_action');

        $balanceModel = new BalanceModel();
        $data['balance'] = $this->currencyFormat($balanceModel->getBalanceByCustomerID($this->customer->getCustomerId()));

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        return view('freelancer/past_project_list', $data);
    }

    // get Freelancer Bids
    public function getFreelancerBids()
    {
        $freelancerModel = new FreelancerModel();

        $seoUrl = service('seo_url');

        if ($this->request->getVar('customer_id')) {
            $freelancer_id = $this->request->getVar('customer_id');
        } elseif ($this->customer->getCustomerId()) {
            $freelancer_id = $this->customer->getCustomerId()   ;
        } else {
            $freelancer_id = 0;
        }

        $data['bids'] = [];

        $results = $freelancerModel->getFreelancerBidsById($freelancer_id);
        
        foreach ($results as $result) {
            $data['bids'][] = [
                'bid_id'        => $result['bid_id'],
                'project_id'    => $result['project_id'],
                'employer_id'   => $result['employer_id'],
                'name'          => $result['name'],
                'quote'         => $this->currencyFormat($result['quote']),
                'delivery'      => $result['delivery'],
                'selected'      => ($result['selected']) ? 'Awarded' : '',
                'accepted'      => $result['accepted'],
                'status'        => ($result['accepted']) ? 'Accepted' : 'Awarded',
                'date_added'    => $this->dateDifference($result['date_added']),
                'href'          => route_to('single_project', $result['project_id'], $seoUrl->getKeywordByQuery('project_id=' . $result['project_id']))
            ];
        }

        $data['customer_id'] = $this->customer->getCustomerId();

        return view('freelancer/bids_list', $data);
    }


    public function completeProject()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {

            $freelancerModel = new FreelancerModel();

            $freelancerModel->updateProjectStatus($this->request->getVar('project_id'), $this->request->getPost());

            $json['success'] = lang('freelancer/project.text_success_complete');
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
