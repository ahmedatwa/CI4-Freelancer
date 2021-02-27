<?php

namespace Catalog\Controllers\Employer;

use Catalog\Controllers\BaseController;
use Catalog\Models\Freelancer\BalanceModel;
use Catalog\Models\Freelancer\DisputeModel;
use Catalog\Models\Account\CustomerModel;

class Employer extends BaseController
{
    public function transferFunds()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $balanceModel = new BalanceModel();

            $balance = $balanceModel->getBalanceByCustomerID($this->session->get('customer_id'))['total'];

            // Emploer Balance Validation
            if (($balance == 0) || $this->request->getPost('amount') > $balance) {
                $json['error'] = sprintf(lang('freelancer/freelancer.error_balance'), route_to('freelancer_deposit'));
            }

            if (! $json) {
                $balanceModel->transferProjectFunds($this->request->getPost());
                $json['success'] = lang('freelancer/freelancer.text_transaction');
            }
        }

        return $this->response->setJSON($json);
    }

    public function getDisputes()
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
         'employer_id'   => $customer_id,
         'sort_by'       => $sort_by,
         'order_by'      => $order_by,
         'limit'         => $limit,
         'start'         => ($page - 1) * $limit,
        ];

        $data['disputes'] = [];

        $disputeModel = new DisputeModel();
        $customerModel = new CustomerModel;

        $results = $disputeModel->getDisputes($filter_data);
        $total = $disputeModel->getTotalDisputes($filter_data);

        foreach ($results as $result) {
            $dispute_action = $disputeModel->getDisputeAction($result['dispute_action_id']);
            $name = $customerModel->where('customer_id', $result['freelancer_id'])->findColumn('username');

            $data['disputes'][] = [
                'dispute_id' => $result['project_id'],
                'freelancer' => isset($name[0]) ? $name[0] : '',
                'project_id' => $result['project_id'],
                'comment'    => $result['comment'],
                'status'     => $result['status'],
                'action'     => $dispute_action ?? '-',
                'date_added' => lang($this->locale . '.longDate', [strtotime($result['date_added'])]),

            ];
        }

        $data['customer_id'] = $customer_id;

        $data['langData'] = lang('employer/dispute.list');

        return view('employer/dispute_list', $data);
    }

    public function openDispute()
    {
        $json = [];

        if (($this->request->getMethod() == 'post') && $this->request->isAJAX()) {
            $disputeModel = new DisputeModel();

            if (! $this->validate([
                'comment' => "required|min_length[20]",
            ])) {
                $json['error'] = $this->validator->getErrors();
            }

            if (! $json) {
                $dispute_data = [
                    'created_by'        => $this->request->getPost('employer_id'),
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
