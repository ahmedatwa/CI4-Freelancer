<?php namespace Admin\Controllers\Finance;

use \Admin\Models\Finance\WithdrawalModel;

class Withdrawal extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $withdrawalModel = new WithdrawalModel();

        $this->document->setTitle(lang('finance/withdrawal.list.heading_title'));

        $this->getList();
    }

    public function edit()
    {
        $this->document->setTitle(lang('finance/withdrawal.list.text_edit'));

        $withdrawalModel = new WithdrawalModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $withdrawalModel->update($this->request->getVar('withdraw_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/finance/withdrawal?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('finance/withdrawal.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $withdrawalModel = new WithdrawalModel();
   
        $this->document->setTitle(lang('finance/withdrawal.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $withdraw_id) {
                $disputeModel->delete($withdraw_id);
                $json['success'] = lang('finance/withdrawal.text_success');
                $json['redirect'] = 'index.php/finance/withdrawal?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('finance/withdrawal.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('finance/withdrawal.list.heading_title'),
            'href' => base_url('index.php/finance/withdrawal?user_token=' . $this->session->get('user_token')),
        ];

        // Data
        $filter_data = [
            'start'    => 0,
            'limit'    => $this->registry->get('config_admin_limit'),
        ];

        $data['withdrawals'] = [];

        $withdrawalModel = new WithdrawalModel();

        $results = $withdrawalModel->getWithdawRequests();

        foreach ($results as $result) {

            $data['withdrawals'][] = [
                'withdraw_id'    => $result['withdraw_id'],
                'customer'       => $result['username'],
                'status'         =>  $result['status'],
                'amount'         =>  currency_format($result['amount']),
                'date_added'     => DateShortFormat($result['date_added']),
                'date_processed' => DateShortFormat($result['date_processed']),
                'edit'           => base_url('index.php/finance/withdrawal/edit?user_token=' . $this->session->get('user_token') . '&withdraw_id=' . $result['withdraw_id']),
                'delete'         => base_url('index.php/finance/withdrawal/delete?user_token=' . $this->session->get('user_token') . '&withdraw_id=' . $result['withdraw_id']),
            ];
        }

        $data['add'] = base_url('index.php/finance/withdrawal/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/finance/withdrawal/delete?user_token=' . $this->session->get('user_token'));

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

        $data['withdraw_statuses'] = $withdrawalModel->getWithdrawStatuses();

        $this->document->output('finance/withdrawal_list', $data);
    }

    protected function getForm()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('finance/withdrawal.list.heading_title'),
            'href' => base_url('index.php/finance/withdrawal/edit?user_token=' . $this->session->get('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('withdraw_id') ? lang('finance/withdrawal.list.text_add') : lang('finance/withdrawal.list.text_edit');

        $data['cancel'] = base_url('index.php/finance/withdrawal?user_token=' . $this->session->get('user_token'));

        $data['user_token'] = $this->request->getVar('user_token');

        if (!$this->request->getVar('withdraw_id')) {
            $data['action'] = base_url('index.php/finance/withdrawal/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/finance/withdrawal/edit?user_token=' . $this->session->get('user_token') . '&withdraw_id=' . $this->request->getVar('withdraw_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $withdrawalModel = new WithdrawalModel();

        if ($this->request->getVar('withdraw_id') && ($this->request->getMethod() != 'post')) {
            $withdrawal_info = $withdrawalModel->find($this->request->getVar('withdraw_id'));
        }
        
        $data['withdraw_statuses'] = $withdrawalModel->getWithdrawStatuses();

        if ($this->request->getPost('withdraw_status_id')) {
            $data['withdraw_status_id'] = $this->request->getPost('withdraw_status_id');
        } elseif (!empty($withdrawal_info)) {
            $data['withdraw_status_id'] = $withdrawal_info['withdraw_status_id'];
        } else {
            $data['withdraw_status_id'] = 0;
        }

        if (!empty($withdrawal_info['withdraw_id'])) {
           $data['withdraw_id'] = $withdrawal_info['withdraw_id'];
        } else {
           $data['withdraw_id'] = 0; 
        }

        if (!empty($withdrawal_info['amount'])) {
           $data['amount'] = $withdrawal_info['amount'];
        } else {
           $data['amount'] = 0; 
        }

        if (!empty($withdrawal_info['customer_id'])) {
           $data['customer_id'] = $withdrawal_info['customer_id'];
        } else {
           $data['customer_id'] = 0; 
        }

        $this->document->output('finance/withdrawal_form', $data);
    }

    public function history() {

        $data['histories'] = [];

        $withdrawalModel = new WithdrawalModel();

        $results = $withdrawalModel->getWithdrawHistories($this->request->getVar('withdraw_id'));

        foreach ($results as $result) {
            $data['histories'][] = [
                'notify'     => $result['notify'] ? lang('en.list.text_yes') : lang('en.list.text_no'),
                'status'     => $result['status'],
                'comment'    => nl2br($result['comment']),
                'date_added' => lang('en.medium_date', [strtotime($result['date_added'])])
            ];
        }

        $data['column_date_added'] = lang('finance/withdrawal.list.column_date_added');
        $data['column_comment']    = lang('finance/withdrawal.list.column_comment');
        $data['column_status']     = lang('finance/withdrawal.list.column_status');
        $data['column_notify']     = lang('finance/withdrawal.list.column_notify');

         return view('finance/withdrawal_history', $data);
    }
    
    public function addHistory() {

        $json = [];

        if (! $this->user->hasPermission('modify', 'finance/withdrawal')) {
            $json['error'] = lang('finance/withdrawal.error_permission');
        }

        if (! $json) {
            $withdrawalModel = new WithdrawalModel();

            $withdrawalModel->addWithdrawHistory($this->request->getVar('withdraw_id'), $this->request->getPost('withdraw_status_id'), $this->request->getPost('comment'), $this->request->getPost('notify'), $this->request->getPost('amount'), $this->request->getPost('customer_id'));

            $json['success'] = lang('finance/withdrawal.text_success');
          }

        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        if (! $this->user->hasPermission('modify', 'finance/withdrawal')) {
            $this->session->setFlashdata('error_warning', lang('finance/withdrawal.error_permission'));
            return false;
        }

        return true;
    }
        
    //--------------------------------------------------------------------
}
