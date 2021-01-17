<?php namespace Catalog\Controllers\Employer;

use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Account\CustomerModel;
use \Catalog\Models\Freelancer\MilestoneModel;
use \Catalog\Models\Extension\Bid\BidModel;
use \Catalog\Models\Freelancer\BalanceModel;
use \Catalog\Models\Employer\EmployerModel;
use \Catalog\Models\Freelancer\DisputeModel;
use \Catalog\Models\Account\ReviewModel;
use \Catalog\Models\Account\MessageModel;

class Project extends \Catalog\Controllers\BaseController
{
    public function view()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $this->template->setTitle(lang('employer/project.text_my_projects'));

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
            'href' => route_to('accoun_dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('employer/project.text_view'),
            'href' => route_to('employer_project_view', $project_id),
        ];

        $projectModel = new ProjectModel();

        if ($project_id) {
            $project_info = $projectModel->getProject($project_id);
        }

        $bidModel = new BidModel();

        if ($project_info) {
            $data['project_id']  = $project_info['project_id'];
            $data['name']        = $project_info['name'];
            $data['type']        = ($project_info['type'] == 1) ? 'Fixed Rate' : 'Hourly Rate';

            $data['days_left']   = lang('employer/project.text_expire', [$this->dateDifference($project_info['date_added'], $project_info['runtime'])]);
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
            
            if ($bid_info['freelancer_id'] == $customer_id) {
                $data['created_for'] = $project_info['employer_id'];
            } else {
                $data['created_for'] = $bid_info['freelancer_id'];
            }

            $data['freelancer_id'] = $bid_info['freelancer_id'];

            $data['freelancer_profile'] = ($bid_info['freelancer_id']) ? route_to('freelancer_profile', $bid_info['freelancer_id'], $freelancer_info['username']) : '';

            $data['status'] = $projectModel->getStatusByProjectId($project_info['project_id']);
            // Project PMs Data
            $messageModel = new MessageModel();
            $message_info = $messageModel->getMessageThread($this->customer->getCustomerID());
        
            $data['thread_id'] = $message_info['thread_id'] ?? '';
            $data['receiver_id'] = $message_info['receiver_id'] ?? '';
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
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

        $this->template->output('employer/project_info', $data);
    }

    public function bids()
    {
        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 20;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];


        $data['breadcrumbs'][] = [
            'text' => lang('project/project.text_manage_bidders'),
            'href' => route_to('account_dashboard'),
        ];

        $filter_data = [
            'orderBy'       => 'p.date_added',
            'sortBy'        => 'DESC',
            'project_id'    => $project_id,
            'limit'         => $limit,
            'start'         => ($page - 1) * $limit,
         ];

        if ($project_id) {
            $projectModel = new ProjectModel();
            $project_info = $projectModel->getProject($project_id);
        }

        $data['name'] = $project_info['name'];
        $data['href'] = base_url('employer/project&pid=' . $project_id);
         
        $bidModel = new BidModel();

        $data['bidders'] = [];

        $results = $bidModel->getBids($filter_data);
        $total = $bidModel->getTotalBidsByProjectId($project_id);
        $reviewModel = new ReviewModel();


        foreach ($results as $result) {
            $data['bidders'][] = [
                'bid_id'        => $result['bid_id'],
                'freelancer_id' => $result['freelancer_id'],
                'freelancer'    => $result['username'],
                'email'         => $result['email'],
                'description'   => nl2br($result['description']),
                'price'         => $this->currencyFormat($result['quote']),
                'delivery'      => $result['delivery'] . ' ' . lang($this->locale . '.text_days'),
                'status'        => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'type'          => ($result['status'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'image'         => ($result['image']) ? $this->resize($result['image'], 80, 80) : $this->resize('catalog/avatar.jpg', 80, 80),
                'rating'        => $reviewModel->getAvgReviewByFreelancerId($result['freelancer_id']),
                'isSelected'    => $bidModel->isAwarded($result['freelancer_id'], $result['project_id']),
                'profile'       => route_to('freelancer_profile', $result['freelancer_id'], $result['username'])
            ];
        }

        $data['heading_title'] = lang('project/project.text_manage_bidders');
        $data['text_total_bidders'] = sprintf(lang('project/project.text_total_bidders'), $total);

        $data['customer_id'] = $customer_id;
        $data['project_id'] = $project_id;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $total);

        return view('employer/bids_list', $data);
    }

    public function getOpenProjects()
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
            'employer_id' => $customer_id,
            'status_id'   => '8,6',
            'sort_by'     => $sort_by,
            'order_by'    => $order_by,
            'limit'       => $limit,
            'start'       => ($page - 1) * $limit,
        ];

        $data['open_projects'] = [];

        $projectModel = new ProjectModel();

        $results = $projectModel->getProjects($filter_data);
        $total = $projectModel->getTotalProjects($filter_data);

        foreach ($results as $result) {
            $data['open_projects'][] = [
                'project_id' => $result['project_id'],
                'name'       => $result['name'],
                'budget'     => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'       => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'date_added' => $this->dateDifference($result['date_added']),
                'total_bids' => $projectModel->getTotalBidsByProjectId($result['project_id']),
                'expiry'     => $this->addDays($result['date_added'], $result['runtime']),
                'avgBids'    => $projectModel->getAvgBidsByProjectId($result['project_id']),
                'status'     => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'    => $result['runtime'],
                'view'       => base_url('employer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'    => base_url('employer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
        }

        $data['column_project_id'] = lang('employer/project.column_project_id');
        $data['column_name']       = lang('employer/project.column_name');
        $data['column_budget']     = lang('employer/project.column_budget');
        $data['column_type']       = lang('employer/project.column_type');
        $data['column_bids']       = lang('employer/project.column_bids');
        $data['column_avg_bids']   = lang('employer/project.column_avg_bids');
        $data['column_expiry']     = lang('employer/project.column_expiry');
        $data['column_status']     = lang('employer/project.column_status');
        $data['column_action']     = lang('employer/project.column_action');

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        return view('employer/open_project_list', $data);
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
         'employer_id' => $customer_id,
         'status_id'   => '4',
         'sort_by'     => $sort_by,
         'order_by'    => $order_by,
         'limit'       => $limit,
         'start'       => ($page - 1) * $limit,
        ];

        $data['work_projects'] = [];

        $projectModel = new ProjectModel();

        $results = $projectModel->getProjects($filter_data);
        $total = $projectModel->getTotalProjects($filter_data);

        foreach ($results as $result) {
            $data['work_projects'][] = [
                'project_id'    => $result['project_id'],
                'employer_id'   => $result['employer_id'],
                'freelancer_id' => $result['freelancer_id'],
                'name'          => $result['name'],
                'budget'        => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'          => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'date_added'    => $this->dateDifference($result['date_added']),
                'total_bids'    => $projectModel->getTotalBidsByProjectId($result['project_id']),
                'expiry'        => $this->addDays($result['date_added'], $result['runtime']),
                'avgBids'       => $projectModel->getAvgBidsByProjectId($result['project_id']),
                'status'        => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'       => $result['runtime'],
                'view'          => base_url('employer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'       => base_url('employer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
        }

        $data['column_project_id'] = lang('employer/project.column_project_id');
        $data['column_name']       = lang('employer/project.column_name');
        $data['column_budget']     = lang('employer/project.column_budget');
        $data['column_type']       = lang('employer/project.column_type');
        $data['column_status']     = lang('employer/project.column_status');
        $data['column_action']     = lang('employer/project.column_action');

        $data['customer_id'] = $customer_id;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        return view('employer/progress_project_list', $data);
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
         'employer_id' => $customer_id,
         'status_id'   => '5,7,1,2',
         'sort_by'     => $sort_by,
         'order_by'    => $order_by,
         'limit'       => $limit,
         'start'       => ($page - 1) * $limit,
        ];

        $data['past_projects'] = [];

        $projectModel = new ProjectModel();
        $bidModel = new BidModel();
        $MilestoneModel = new MilestoneModel();
        $disputeModel = new DisputeModel();

        $results = $projectModel->getProjects($filter_data);
        $total = $projectModel->getTotalProjects($filter_data);

        foreach ($results as $result) {
            $paidStatus = $bidModel->where('project_id', $result['project_id'])->findColumn('paid');

            $milestoneAmount = $MilestoneModel->where(['project_id' => $result['project_id'], 'status' => 2])->findColumn('amount');

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
                'freelancer_id' => $result['freelancer_id'],
                'name'          => $result['name'],
                'budget'        => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'          => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'date_added'    => $this->dateDifference($result['date_added']),
                'total_bids'    => $projectModel->getTotalBidsByProjectId($result['project_id']),
                'expiry'        => $this->addDays($result['date_added'], $result['runtime']),
                'avgBids'       => $projectModel->getAvgBidsByProjectId($result['project_id']),
                'status'        => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'       => $result['runtime'],
                'view'          => base_url('employer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'       => base_url('employer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'amount'        => $amount[0] - $milestoneAmount[0],
                'paid'          => ($amount[0] == 0) ? '-' : $paid,
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

        $data['column_project_id'] = lang('employer/project.column_project_id');
        $data['column_name']       = lang('employer/project.column_name');
        $data['column_project_id'] = lang('employer/project.column_project_id');
        $data['column_budget']     = lang('employer/project.column_budget');
        $data['column_type']       = lang('employer/project.column_type');
        $data['column_bids']       = lang('employer/project.column_bids');
        $data['column_avg_bids']   = lang('employer/project.column_avg_bids');
        $data['column_status']     = lang('employer/project.column_status');
        $data['column_status']     = lang('employer/project.column_status');
        $data['column_amount']     = lang('employer/project.column_amount');
        $data['column_paid']       = lang('employer/project.column_paid');
        $data['column_action']     = lang('employer/project.column_action');

        $balanceModel = new BalanceModel();
        $data['balance'] = $this->currencyFormat($balanceModel->getBalanceByCustomerID($this->customer->getCustomerId())['total']);

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        return view('employer/past_project_list', $data);
    }

    // Award Freelancer
    public function awardWinner()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && $this->request->getVar('pid')) {
            $freelancerModel = new EmployerModel();

            $freelancerModel->addWinner($this->request->getPost());

            $json['success'] = lang('employer/project.text_success_winner');
        }

        return $this->response->setJSON($json);
    }
    //--------------------------------------------------------------------
}
