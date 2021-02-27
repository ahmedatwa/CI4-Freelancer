<?php 

namespace Catalog\Controllers\Employer;

use Catalog\Controllers\BaseController;
use Catalog\Models\Employer\EmployerModel;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Freelancer\MilestoneModel;
use Catalog\Models\Extension\Bid\BidModel;
use Catalog\Models\Freelancer\BalanceModel;
use Catalog\Models\Freelancer\DisputeModel;
use Catalog\Models\Account\MessageModel;

class Project extends BaseController
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

        if ($project_id) {
            $employerModel = new EmployerModel();
            $project_info = $employerModel->getEmployerProject($project_id);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($project_info) {
            $bidModel = new BidModel();

            $data['project_id']  = $project_info['project_id'];
            $data['name']        = $project_info['name'];
            $data['type']        = ($project_info['type']) ? lang($this->locale . '.list.text_fixed_price') : lang($this->locale . '.list.text_per_hour');

            $data['days_left']   = lang('employer/project.text_expire', [$this->dateDifference($project_info['date_added'], $project_info['runtime'])]);
            $data['employer']    = $project_info['employer'];
            $data['employer_id'] = $project_info['employer_id'];
            $data['budget']      = $this->currencyFormat($project_info['budget_min']) . '-' . $this->currencyFormat($project_info['budget_max']);
            $data['total_bids']  = $bidModel->getTotalBidsByProjectId($project_id);
            // get Bid info
            $bid_info = $bidModel->getBidByProjectId($project_id);

            if (! is_null($bid_info)) {
                $customerModel = new CustomerModel();

                $data['bid_amount']         = $this->currencyFormat($bid_info['quote']);
                $freelancer_info            = $customerModel->getCustomer($bid_info['freelancer_id']);

                $data['freelancer']         = $freelancer_info['username'];
                $data['freelancer_id']      = $bid_info['freelancer_id'];
                $data['freelancer_profile'] = ($bid_info['freelancer_id']) ? route_to('freelancer_profile', $bid_info['freelancer_id'], $freelancer_info['username']) : '';
                
                if ($bid_info['freelancer_id'] == $customer_id) {
                    $data['created_for'] = $project_info['employer_id'];
                } else {
                    $data['created_for'] = $bid_info['freelancer_id'];
                }
            } else {
                $data['bid_amount'] = '';
                $data['freelancer'] = '';
                $data['freelancer_id'] = '';
                $data['freelancer_profile'] = '';
            }         

            $data['status'] = $employerModel->getProjectStatusByProjectId($project_info['project_id']);
            // Project PMs Data
            $messageModel = new MessageModel();
            $message_info = $messageModel->getMessageThread($this->customer->getID());
        
            $data['thread_id'] = $message_info['thread_id'] ?? '';
            $data['receiver_id'] = $message_info['receiver_id'] ?? '';
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['upload']      = base_url('tool/upload');
        $data['back']        = base_url('account/projects');
        $data['customer_id'] = $customer_id;

        $data['initial_preview_data'] = $employerModel->getFilesByProjectId($project_id);
        $data['initial_preview_config_data'] = $employerModel->getFilesPreviewConfig($project_id);

        // upload extensions allowed
        $file_ext_allowed = preg_replace('~\r?\n~', "\n", $this->registry->get('config_file_ext_allowed'));
        $filetypes = explode("\n", $file_ext_allowed);
        
        foreach ($filetypes as $filetype) {
            $data['allowedFileExtensions'][] = trim($filetype);
        }

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $data['langData'] = lang('project/project.list');

        $this->template->output('employer/project_info', $data);
    }

    public function getOpenProjects()
    {
        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->customer->getID()) {
            $customer_id = $this->customer->getID();
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

        $data['projects'] = [];

        $employerModel = new EmployerModel();

        $results = $employerModel->getEmployerProjects($filter_data);

        foreach ($results as $result) {
            $data['projects'][] = [
                'project_id' => $result['project_id'],
                'name'       => $result['name'],
                'budget'     => $this->currencyFormat($result['budget_min']) . ' - ' . $this->currencyFormat($result['budget_max']),
                'type'       => ($result['type'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'date_added' => $this->dateDifference($result['date_added']),
                'total_bids' => $employerModel->getTotalBidsByProjectId($result['project_id']),
                'expiry'     => $this->addDays($result['date_added'], $result['runtime']),
                'avgBids'    => $employerModel->getEmployerAvgBidsByProjectId($result['project_id']),
                'status'     => $employerModel->getProjectStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'    => $result['runtime'],
                'view'       => base_url('employer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'    => base_url('employer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
        }

        $data['langData'] = lang('employer/project.list');

        return view('employer/open_project_list', $data);
    }

    public function getInProgressProjects()
    {

        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->customer->getID()) {
            $customer_id = $this->customer->getID();
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

        $data['projects'] = [];

        $employerModel = new EmployerModel();

        $results = $employerModel->getEmployerProjects($filter_data);

        foreach ($results as $result) {
            $data['projects'][] = [
                'project_id'    => $result['project_id'],
                'employer_id'   => $result['employer_id'],
                'freelancer_id' => $result['freelancer_id'],
                'name'          => $result['name'],
                'budget'        => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'          => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'date_added'    => $this->dateDifference($result['date_added']),
                'total_bids'    => $employerModel->getTotalBidsByProjectId($result['project_id']),
                'expiry'        => $this->addDays($result['date_added'], $result['runtime']),
                'avgBids'       => $employerModel->getEmployerAvgBidsByProjectId($result['project_id']),
                'status'        => $employerModel->getProjectStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'       => $result['runtime'],
                'view'          => base_url('employer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'       => base_url('employer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
        }

        $data['customer_id'] = $customer_id;

        $data['langData'] = lang('employer/project.list');

        return view('employer/progress_project_list', $data);
    }
    
    public function getPastProjects()
    {

        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->customer->getID()) {
            $customer_id = $this->customer->getID();
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

        $data['projects'] = [];

        $employerModel  = new EmployerModel();
        $bidModel       = new BidModel();
        $milestoneModel = new MilestoneModel();
        $disputeModel   = new DisputeModel();

        $results = $employerModel->getEmployerProjects($filter_data);

        foreach ($results as $result) {
            $paidStatus      = $bidModel->where('project_id', $result['project_id'])->findColumn('paid');
            $milestoneAmount = $milestoneModel->where(['project_id' => $result['project_id'], 'status' => 2])->findColumn('amount');
            $quoteAmount     = $bidModel->where('project_id', $result['project_id'])->findColumn('quote');
            $inDispute       = $disputeModel->inDispute($result['project_id']);
            
            if (isset($paidStatus[0])) {
                if ($paidStatus[0]== 0) {
                    $paid = lang('employer/project.text_unpaid');
                } elseif ($paidStatus[0] == 1) {
                    $paid = lang('employer/project.text_paid');
                } else {
                    $paid = lang('employer/project.text_partial');
                }
            }
            
            $data['projects'][] = [
                'project_id'    => $result['project_id'],
                'employer_id'   => $result['employer_id'] ?? 0,
                'freelancer_id' => $result['freelancer_id'] ?? '',
                'name'          => $result['name'],
                'budget'        => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'          => ($result['type'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'date_added'    => $this->dateDifference($result['date_added']),
                'total_bids'    => $employerModel->getTotalBidsByProjectId($result['project_id']),
                'expiry'        => $this->addDays($result['date_added'], $result['runtime']),
                'avgBids'       => $employerModel->getEmployerAvgBidsByProjectId($result['project_id']),
                'status'        => $employerModel->getProjectStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'       => $result['runtime'],
                'view'          => base_url('employer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'       => base_url('employer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'amount'        => (! is_null($quoteAmount) ? $quoteAmount[0] : 0) - (! is_null($milestoneAmount) ? $milestoneAmount[0] : 0),
                'paid'          => ((! is_null($quoteAmount) ? $quoteAmount[0] : 0) == 0) ? '-' : $paid,
                'inDispute'     => $inDispute,
            ];
        }

        // Dispute Reasons
        $data['dispute_reasons'] = [];
        $dispute_reasons = $disputeModel->getDisputeReasons();
        foreach ($dispute_reasons as $reason) {
            $data['dispute_reasons'][] = [
                'dispute_reason_id' => $reason['dispute_reason_id'],
                'name'              => $reason['name']
            ];
        }

        $balanceModel = new BalanceModel();
        $data['balance'] = $this->currencyFormat($balanceModel->getBalanceByCustomerID($this->customer->getID())['total']);

        $data['langData'] = lang('employer/project.list');

        return view('employer/past_project_list', $data);
    }
    //--------------------------------------------------------------------
}