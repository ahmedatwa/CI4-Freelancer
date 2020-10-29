<?php namespace Catalog\Controllers\freelancer;

use Catalog\Models\Catalog\ProjectModel;

class Project extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged() ) {
            return redirect('account_login');
        }

        $projectModel = new ProjectModel();

        $this->template->setTitle(lang('project/project.text_my_projects'));

        $this->getList();
    }

    public function view()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged() ) {
            return redirect('account_login');
        }

        $projectModel = new ProjectModel();

        $this->template->setTitle(lang('project/project.text_my_projects'));

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

        if ($project_id) {
            $project_info = $projectModel->getProject($project_id);
        } else {
            $project_info = [];
        }

        $bidModel = new \Catalog\Models\Extension\Bid\BidModel();

        if ($project_info) {
            $data['project_id']  = $project_info['project_id'];
            $data['name']        = $project_info['name'];

            $data['days_left']   = lang('freelancer/project.text_expire', [$this->dateDifference($project_info['date_added'], $project_info['runtime'])]);
            $data['employer']    = $project_info['employer'];
            $data['employer_id'] = $project_info['employer_id'];
            $data['budget'] = $this->currencyFormat($project_info['budget_min']) . '-' . $this->currencyFormat($project_info['budget_max']);
            $data['total_bids'] = $bidModel->getTotalBidsByProjectId($project_id);

            $data['status'] = $projectModel->getStatusByProjectId($project_info['project_id']);

        }

        $data['heading_title'] = lang('project/project.text_my_projects');

        $data['upload'] = base_url('tool/upload');
        $data['customer_id'] = $customer_id;
        $data['project_id'] = $project_id;

        $data['initial_preview_data'] = $projectModel->getFilesByProjectId($project_id);

        $data['initial_preview_config_data'] = $projectModel->getFilesPreviewConfig($project_id);

        $data['pid'] = $project_id;
        $data['employer_id'] = $customer_id;

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');


        $this->template->output('project/project_info', $data);
    }

    public function getList()
    {
        $projectModel = new ProjectModel();

        $this->template->setTitle(lang('project/project.text_my_projects'));
            
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
            'text' => lang('project/project.text_my_projects'),
            'href' => base_url('freelancer/project'),
        ];

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }


        $filter_data = [
            'employer_id' => $customer_id,
            'status_id'   => '8,6',
            'sortBy'      => 'p.date_added',
            'orderBy'     => 'DESC',
            'limit'       => 20,
            'start'       => 0,
        ];
    
        $data['open_projects'] = [];
        
        $results = $projectModel->getProjects($filter_data);
        $projects_total = $projectModel->getTotalProjects();

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
                'view'       => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'    => base_url('freelancer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
          
        }


        // in progress
        $filter_data = [
            'employer_id' => $customer_id,
            'status_id'   => '4',
            'sortBy'      => 'p.date_added',
            'orderBy'     => 'DESC',
            'limit'       => 20,
            'start'       => 0,
        ];
    
        $data['work_projects'] = [];
        
        $results = $projectModel->getProjects($filter_data);
        $projects_total = $projectModel->getTotalProjects();

        foreach ($results as $result) {
            $data['work_projects'][] = [
                'project_id' => $result['project_id'],
                'employer_id' => $result['employer_id'],
                'freelancer_id' => $result['freelancer_id'],
                'name'       => $result['name'],
                'budget'     => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'       => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'date_added' => $this->dateDifference($result['date_added']),
                'total_bids' => $projectModel->getTotalBidsByProjectId($result['project_id']),
                'expiry'     => $this->addDays($result['date_added'], $result['runtime']),
                'avgBids'    => $projectModel->getAvgBidsByProjectId($result['project_id']),
                'status'     => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'    => $result['runtime'],
                'view'       => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'    => base_url('freelancer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
          
        }

        // Past 
        $filter_data = [
            'employer_id' => $customer_id,
            'status_id'   => '5,7',
            'sortBy'      => 'p.date_added',
            'orderBy'     => 'DESC',
            'limit'       => 20,
            'start'       => 0,
        ];
    
        $data['past_projects'] = [];
        
        $results = $projectModel->getProjects($filter_data);
        $projects_total = $projectModel->getTotalProjects();

        foreach ($results as $result) {
            $data['past_projects'][] = [
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
                'view'       => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'    => base_url('freelancer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
          
        }

        // Freelancer in Progress 
        $data['freelancer_progress_projects'] = [];
        
        $results = $results = $projectModel->getFreelancerProjects($customer_id);
        foreach ($results as $result) {
            $data['freelancer_progress_projects'][] = [
                'project_id' => $result['project_id'],
                'name'       => $result['name'],
                'budget'     => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'       => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'status'     => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'view'       => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
          
        }

        // Status
        $data['project_statuses'] = [];
        $projectStatusesModel = new \Catalog\Models\Localization\ProjectStatusModel();
        $projectStatuses = $projectStatusesModel->getProjectSatuses();
        foreach ($projectStatuses as $status) {
            $data['project_statuses'][] = [
                'status_id' => $status['status_id'],
                'name' => $status['name']
            ];
        }

        // Dispute Reasons
        $data['dispute_reasons'] = [];
        $disputeModel = new \Catalog\Models\Freelancer\DisputeModel();
        $dispute_reasons = $disputeModel->getDisputeReasons();
        foreach ($dispute_reasons as $reason) {
            $data['dispute_reasons'][] = [
                'dispute_reason_id' => $reason['dispute_reason_id'],
                'name'              => $reason['name']
            ];
        }
    
        $data['heading_title']     = lang('freelancer/project.text_my_projects');
        $data['button_view']       = lang('freelancer/project.button_view');
        $data['button_cancel']     = lang('freelancer/project.button_cancel');
        
        $data['column_freelancer'] = lang('freelancer/project.column_freelancer');
        $data['column_budget']     = lang('freelancer/project.column_budget');
        $data['column_bids']       = lang('freelancer/project.column_bids');
        $data['column_avg_bids']   = lang('freelancer/project.column_avg_bids');
        $data['column_expiry']     = lang('freelancer/project.column_expiry');
        $data['column_type']       = lang('freelancer/project.column_type');
        $data['column_status']     = lang('freelancer/project.column_status');
        $data['column_action']     = lang('freelancer/project.column_action');
        $data['column_name']       = lang('freelancer/project.column_name');

        $data['entry_name']        = lang('freelancer/project.entry_name');
        $data['entry_status']      = lang('freelancer/project.entry_status');
        $data['text_select']       = lang('en.text_select');

        $data['customer_id'] = $customer_id;
        $data['pid'] = $customer_id;
        
        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('freelancer/project_list', $data);
    }

    // Account Dashboard
    public function bids()
    {
        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
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
            'text' => lang('project/project.heading_title'),
            'href' => base_url('account/dashboard?cid=' . $customer_id),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/project.text_manage_bidders'),
            'href' => base_url('account/dashboard/project?pid=' . $project_id . '&cid=' . $customer_id),
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
        $data['href'] = base_url('freelancer/project&pid=' . $project_id);
         
        $bidModel = new \Catalog\Models\Extension\Bid\BidModel();

        $data['bidders'] = [];

        $results = $bidModel->getBids($filter_data);
        $total = $bidModel->getTotalBidsByProjectId($project_id);
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();


        foreach ($results as $result) {
            $data['bidders'][] = [
                'bid_id'        => $result['bid_id'],
                'freelancer_id' => $result['freelancer_id'],
                'freelancer'    => $result['freelancer'],
                'email'         => $result['email'],
                'price'         => $this->currencyFormat($result['quote']),
                'delivery'      => $result['delivery'] . ' ' . lang($this->locale . '.text_days'),
                'status'        => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'profile'       => route_to('freelancers/profile', $result['customer_id']),
                'type'          => ($result['status'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'image'         => ($result['image']) ? $this->resize($result['image'], 80, 80) : $this->resize('catalog/avatar.jpg', 80, 80),
                'rating'        => $reviewModel->getAvgReviewByFreelancerId($result['freelancer_id']),
                'isSelected'      => $bidModel->isAwarded($result['freelancer_id']),
            ];
        }

        $data['heading_title'] = lang('project/project.text_manage_bidders');
        $data['text_total_bidders'] = sprintf(lang('project/project.text_total_bidders'), $total);

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $total);

        return view ('freelancer/project_bids', $data);

    } 

    // getProjects
    // public function getProjects()
    // {

    //     $projectModel = new ProjectModel();

    //     if ($this->request->getVar('cid')) {
    //         $customer_id = $this->request->getVar('cid');
    //     } else {
    //         $customer_id = 0;
    //     }

    //     if ($this->request->getVar('status_id')) {
    //         $status_id = $this->request->getVar('status_id');
    //     } else {
    //         $status_id = 0;
    //     }

    //     $filter_data = [
    //         'employer_id' => $customer_id,
    //         'status_id'   => $status_id,
    //         'sortBy'      => 'p.date_added',
    //         'orderBy'     => 'DESC',
    //         'limit'       => 20,
    //         'start'       => 0,
    //     ];

    //     $results = $projectModel->getProjects($filter_data);

    //     foreach ($results as $result) {
    //         $json[] = [
    //             'project_id' => $result['project_id'],
    //             'name'       => $result['name'],
    //             'budget'     => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
    //             'type'       => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
    //             'date_added' => $this->dateDifference($result['date_added']),
    //             'total_bids' => $projectModel->getTotalBidsByProjectId($result['project_id']),
    //             'expiry'     => $this->addDays($result['date_added'], $result['runtime']),
    //             'avgBids'    => $projectModel->getAvgBidsByProjectId($result['project_id']),
    //             'status'     => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
    //             'expired'    => $result['runtime'],
    //             'view'       => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
    //             'bidders'    => base_url('freelancer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
    //         ];
    //     }

    //     return $this->response->setJSON($json);
    // }   
    // get Project Messages
    public function getProjectMessages()
    {   
        $projectModel = new ProjectModel();

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } else {
            $customer_id = 0;
        }

        $filter_data = [
            'project_id'    => $project_id,
            'customer_id'    => $customer_id,
         ];
         
        $data['project_messages'] = [];

        $results = $projectModel->getProjectMessagesById($filter_data);

        $customerModel = new \Catalog\Models\Account\customerModel();

        foreach ($results as $result) {
            $data['project_messages'][] = [
                'message'       => $result['message'],
                'employer_id'   => $result['employer_id'],
                'freelancer_id' => $result['freelancer_id'],
                'freelancer'    => $customerModel->where('customer_id', $result['freelancer_id'])->findColumn('username'),
                'employer'      =>  $customerModel->where('customer_id', $result['employer_id'])->findColumn('username'),
                'date_added'    => $this->dateDifference($result['date_added']),
            ];
        }  

        $data['customer_id'] = $this->session->get('customer_id'); 

        $data['heading_title'] = lang('project/project.text_manage_bidders');

        return view ('freelancer/project_messages', $data);
    }

    // get Project Messages
    public function getProjectMilestones()
    {   
        $projectModel = new ProjectModel();

        if ($this->request->getVar('project_id')) {
            $project_id = $this->request->getVar('project_id');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } else {
            $customer_id = 0;
        }

        $filter_data = [
            'project_id'    => $project_id,
            'customer_id'    => $customer_id,
         ];
         
        $data['project_milestones'] = [];

        $results = $projectModel->getMilestonesByProjectId($project_id);

        foreach ($results as $result) {
            $data['project_milestones'][] = [
                'project_id'  => $result['project_id'],
                'amount'      => $result['amount'],
                'description' => $result['description'],
                'status'      => $result['status'],
                'date_added'  => $this->dateDifference($result['date_added']),
                'deadline'    => $this->addDays($result['date_added'], $result['deadline']),
                'cancel'      => '',//$projectModel->update($project_id, ['status' => 0]),
                'pay'      => '',//$projectModel->update($project_id, ['status' => 0]),
            ];
        }  

        $data['customer_id'] = $this->session->get('customer_id'); 

        $data['heading_title'] = lang('project/project.text_manage_bidders');

        return view ('freelancer/project_milestone', $data);

    }

    public function awardWinner()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && $this->request->getVar('pid')) {
            $projectModel = new ProjectModel();
                $projectModel->addWinner($this->request->getPost());
                $json['success'] = lang('freelancer/project.text_success_winner');
        }

        return $this->response->setJSON($json);
    }

    public function addMilestone()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && $this->request->getVar('pid')) {
            $projectModel = new ProjectModel();
                $projectModel->insertMilestone($this->request->getPost());
                $json['success'] = lang('freelancer/project.text_success_milestone');
        }

        return $this->response->setJSON($json);
    }
 
    public function sendMessage()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && $this->request->getVar('pid')) {
            $projectModel = new ProjectModel();

            if (! $this->validate([
                'message'  => 'required'
            ]))
            {
                $json['error'] = $this->validator->getError('message');
            }

            if (!$json) {
                $projectModel->addMessage($this->request->getPost());
                $json['success'] = lang('freelancer/project.text_success_pm');
            }

        }

        return $this->response->setJSON($json);
    }

    // getProjects
    // public function getFreelancerProjects()
    // {
    //     $json = [];

    //     $projectModel = new ProjectModel();

    //     if ($this->request->getVar('cid')) {
    //         $freelancer_id = $this->request->getVar('cid');
    //     } elseif ($this->session->get('freelancer_id')) {
    //         $freelancer_id = $this->session->get('freelancer_id');
    //     } else {
    //         $freelancer_id = 0;
    //     }

    //     $results = $projectModel->getFreelancerProjects($freelancer_id);

    //     foreach ($results as $result) {
    //         $json[] = [
    //             'project_id' => $result['project_id'],
    //             'name'       => $result['name'],
    //             'budget'     => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
    //             'type'       => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
    //             'date_added' => $this->dateDifference($result['date_added']),
    //             'status'     => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
    //             'view'       => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $freelancer_id),
    //         ];
    //     }

    //     return $this->response->setJSON($json);
    // }   


    
    //--------------------------------------------------------------------
}
