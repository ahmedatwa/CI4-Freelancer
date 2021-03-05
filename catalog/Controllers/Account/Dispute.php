<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Localization\ProjectStatusModel;

class Dispute extends BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $projectModel = new ProjectModel();

        $this->template->setTitle(lang('account/dispute.heading_title'));
            
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
            'text' => lang('account/dispute.heading_title'),
            'href' => base_url('account_project'),
        ];

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        $data['heading_title'] = lang('account/dispute.heading_title');

        $data['customer_id'] = $customer_id;
        
        $data['langData'] = lang('account/dispute.list');
        
        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/dispute', $data);
    }

    public function getDisputes()
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
             'sort_by'     => $sort_by,
             'order_by'    => $order_by,
             'limit'       => $limit,
             'start'       => ($page - 1) * $limit,
        ];

        $data['disputes'] = [];

        $disputeModel = new DisputeModel();
        $customerModel = new CustomerModel;

        $results = $disputeModel->getDisputes($filter_data);
        $total = $disputeModel->getTotalDisputes($filter_data);

        foreach ($results as $result) {
            $dispute_action = $disputeModel->getDisputeAction($result['dispute_action_id']);
            $name = $customerModel->where('customer_id', $result['employer_id'])->findColumn('username');

            $data['disputes'][] = [
                'dispute_id' => $result['project_id'],
                'employer'   => $name[0],
                'project_id' => $result['project_id'],
                'comment'    => $result['comment'],
                'status'     => $result['status'],
                'action'     => $dispute_action ?? '-',
                'date_added' => lang('en.longDate', [strtotime($result['date_added'])]),

            ];
        }

        $data['customer_id'] = $customer_id;

        $data['langData'] = lang('freelancer/dispute.list');
        
        return view('freelancer/dispute_list', $data);
    }

    public function openDispute()
    {
        $json = [];

        $disputeModel = new DisputeModel();

        if (! $this->validate([
           'comment' => "required|min_length[20]",
        ])) {
            $json['error'] = $this->validator->getErrors();
        }

        if ($this->request->getMethod() == 'post') {
            if (! $json) {
                $dispute_data = [
                    'created_by'        => $this->request->getPost('freelancer_id'),
                    'employer_id'       => $this->request->getPost('employer_id'),
                    'freelancer_id'     => $this->request->getPost('freelancer_id'),
                    'project_id'        => $this->request->getPost('project_id'),
                    'comment'           => $this->request->getPost('comment'),
                    'dispute_reason_id' => $this->request->getPost('dispute_reason_id'),
                ];

                $disputeModel->insert($dispute_data);

                $json['success'] = lang('freelancer/dispute.text_success');
            }
        }
        
        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
