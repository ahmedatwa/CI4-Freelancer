<?php namespace Catalog\Controllers\freelancer;

use Catalog\Models\Catalog\ProjectModel;

class Project extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();

        $this->template->setTitle(lang('project/project.text_my_projects'));

        $this->getList();
    }

    public function view()
    {
        $projectModel = new ProjectModel();

        $this->template->setTitle(lang('project/project.text_my_projects'));

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
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


        if ($project_info) {
            $data['project_id']  = $project_info['project_id'];
            $data['name']        = $project_info['name'];

            $data['days_left']   = lang('freelancer/project.text_expire', [$this->dateDifference($project_info['date_added'], $project_info['runtime'])]);
            $data['employer']    = $project_info['employer'];
            $data['employer_id'] = $project_info['employer_id'];
            $data['status'] = $projectModel->getStatusByProjectId($project_info['project_id']);

        }

        $data['heading_title'] = lang('project/project.text_my_projects');

        $data['upload'] = base_url('tool/upload');
        $data['customer_id'] = $customer_id;
        $data['project_id'] = $project_id;

        $data['initial_preview_data'] = $projectModel->getFilesByProjectId($project_id);

        $data['initial_preview_config_data'] = $projectModel->getFilesPreviewConfig($project_id);



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
        } else {
            $customer_id = 0;
        }


        $filter_data = [
            'employer_id' => $customer_id,
            'sortBy'      => 'p.date_added',
            'orderBy'     => 'DESC',
            'limit'       => 20,
            'start'       => 0,
        ];
    
        $data['projects'] = [];
        
        $results = $projectModel->getProjects($filter_data);
        $projects_total = $projectModel->getTotalProjects();

        foreach ($results as $result) {
            
            $data['projects'][] = [
                'project_id' => $result['project_id'],
                'name'       => $result['name'],
                'budget'     => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'       => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'date_added' => $this->dateDifference($result['date_added']),
                'total_bids' => $projectModel->getTotalBidsByProjectId($result['project_id']),
                'days_left'  => $this->dateAfter($this->addDays($result['date_added'], $result['runtime'])) ? lang('freelancer/project.text_expired') : lang('en.mediumDate', [strtotime($this->addDays($result['date_added'], $result['runtime']))]),
                'avgBids'    => $projectModel->getAvgBidsByProjectId($result['project_id']),
                'status'     => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'    => $result['runtime'],
                'view'       => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'    => base_url('freelancer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
          
        }

        $data['project_statuses'] = [];

        $projectStatusesModel = new \Catalog\Models\Localization\ProjectStatusModel();
        $projectStatuses = $projectStatusesModel->getProjectSatuses();
        foreach ($projectStatuses as $status) {
            $data['project_statuses'][] = [
                'status_id' => $status['status_id'],
                'name' => $status['name']
            ];
        }

    
        $data['heading_title']     = lang('freelancer/project.text_my_projects');
        $data['column_status']     = lang('freelancer/project.column_status');
        $data['column_action']     = lang('freelancer/project.column_action');
        $data['column_name']       = lang('freelancer/project.column_name');
        $data['button_view']       = lang('freelancer/project.button_view');
        $data['button_cancel']     = lang('freelancer/project.button_cancel');
        $data['column_freelancer'] = lang('freelancer/project.column_freelancer');
        $data['column_budget']     = lang('freelancer/project.column_budget');
        $data['column_bids']       = lang('freelancer/project.column_bids');
        $data['column_avg_bids']   = lang('freelancer/project.column_avg_bids');
        $data['column_expiry']     = lang('freelancer/project.column_expiry');
        $data['column_type']       = lang('freelancer/project.column_type');
        $data['entry_name']        = lang('freelancer/project.entry_name');
        $data['entry_status']      = lang('freelancer/project.entry_status');
        $data['text_select']       = lang('en.text_select');
        $data['']                  = lang('freelancer/project.column_status');
        $data['']                  = lang('freelancer/project.column_status');
        $data['']                  = lang('freelancer/project.column_status');
        $data['']                  = lang('freelancer/project.column_status');
        $data['']                  = lang('freelancer/project.column_status');
        $data['']                  = lang('freelancer/project.column_status');
        $data['']                  = lang('freelancer/project.column_status');


        $data['customer_id'] = $this->request->getVar('cid');
        
        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');


        $this->template->output('freelancer/project_list', $data);
    }

    // Account Dashboard
    public function bidders()
    {
        if ($this->request->getVar('pid')) {
            $pid = $this->request->getVar('pid');
        } else {
            $pid = 0;
        }

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
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
            'href' => base_url('account/dashboard/project?pid=' . $pid . '&cid=' . $customer_id),
        ];

        $filter_data = [
            'orderBy'    => 'p.date_added',
            'sortBy'     => 'DESC',
            'pid' => $pid,
            'limit'      => $limit,
            'start'      => ($page - 1) * $limit,
         ];

        if ($pid) {
            $projectModel = new ProjectModel();
            $project_info = $projectModel->getProject($pid);
        }

        $data['name'] = $project_info['name'];
        $data['href'] = base_url('freelancer/project&pid=' . $pid);
         
        $bidModel = new \Catalog\Models\Extension\Bid\BidModel();

        $data['bidders'] = [];

        $results = $bidModel->getBids($filter_data);
        $total = $bidModel->getTotalBidsByProjectId($pid);
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();

        foreach ($results as $result) {
            $data['bidders'][] = [
                'bid_id'     => $result['bid_id'],
                'freelancer' => $result['freelancer'],
                'email'      => $result['email'],
                'price'      => $this->currencyFormat($result['price']),
                'delivery'   => $result['delivery'] . ' ' . lang($this->locale . '.text_days'),
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'profile'    => route_to('freelancers/profile', $result['customer_id']),
                'type'        => ($result['status'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'image'      => ($result['image']) ? $this->resize($result['image'], 80, 80) : $this->resize('catalog/avatar.jpg', 80, 80),
                'rating'     => $reviewModel->getAvgReviewByFreelancerId($result['freelancer_id'])
            ];
        }

        $data['heading_title'] = lang('project/project.text_manage_bidders');
        $data['text_total_bidders'] = sprintf(lang('project/project.text_total_bidders'), $total);

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $total);

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('freelancer/project_bidders', $data);

    } 

    public function getProjects()
    {
        $json = [];

        $projectModel = new ProjectModel();

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } else {
            $customer_id = 0;
        }

        if ($this->request->getVar('status_id')) {
            $status_id = $this->request->getVar('status_id');
        } else {
            $status_id = 0;
        }

        $filter_data = [
            'employer_id' => $customer_id,
            'status_id'   => $status_id,
            'sortBy'      => 'p.date_added',
            'orderBy'     => 'DESC',
            'limit'       => 20,
            'start'       => 0,
        ];

        $results = $projectModel->getProjects($filter_data);

        foreach ($results as $result) {
            $json[] = [
                'project_id' => $result['project_id'],
                'name'       => $result['name'],
                'budget'     => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'       => ($result['type'] == 1) ? lang('project/project.text_fixed_price') : lang('project/project.text_per_hour'),
                'date_added' => $this->dateDifference($result['date_added']),
                'total_bids' => $projectModel->getTotalBidsByProjectId($result['project_id']),
                'expiry'  => $this->dateAfter($this->addDays($result['date_added'], $result['runtime'])) ? lang('freelancer/project.text_expired') : lang('en.mediumDate', [strtotime($this->addDays($result['date_added'], $result['runtime']))]),
                'avgBids'    => $projectModel->getAvgBidsByProjectId($result['project_id']),
                'status'     => $projectModel->getStatusByProjectId($result['project_id']) ?? 'Open',
                'expired'    => $result['runtime'],
                'view'       => base_url('freelancer/project/view?pid=' . $result['project_id'] . '&cid=' . $customer_id),
                'bidders'    => base_url('freelancer/project/bidders?pid=' . $result['project_id'] . '&cid=' . $customer_id),
            ];
        }


        return $this->response->setJSON($json);
    }   

    //--------------------------------------------------------------------
}
