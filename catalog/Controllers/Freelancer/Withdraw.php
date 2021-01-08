<?php namespace Catalog\Controllers\Freelancer;

use \Catalog\Models\Freelancer\WithdrawModel;
use \Catalog\Models\Account\CustomerModel;
use \Catalog\Models\Freelancer\BalanceModel;

class Withdraw extends \Catalog\Controllers\BaseController
{
    public function add()
    {
        $json = [];

        $this->template->setTitle(lang('freelancer/freelancer.heading_title'));

        $withdrawModel = new WithdrawModel();

        if ($this->request->getMethod() == 'post') {
            $withdrawModel->addRequest($this->request->getPost());

            $json['success'] = lang('freelancer/withdraw.text_success');
        }
        
        return $this->response->setJSON($json);
    }

    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
            return redirect('account_login');
        }

        $this->template->setTitle(lang('freelancer/freelancer.heading_title'));

        $withdrawModel = new WithdrawModel();

        helper('number');

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('freelancer/freelancer.heading_title'),
            'href' => base_url('freelancer/freelancer'),
        ];

        if ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        $balanceModel = new BalanceModel();

        $data['withdrawals'] = [];

        $results = $withdrawModel->getWithdrawalByCustomerId($customer_id);

        foreach ($results as $result) {
            $data['withdrawals'][] = [
                'withdraw_id' => $result['withdraw_id'],
                'amount'      => number_format($result['amount'], 2),
                'status'      => $result['status'],
                'date_added'  => $this->dateDifference($result['date_added']),
                'date_processed' => ($result['date_processed']) ? $this->dateDifference($result['date_processed']) : '0000-00-00 00:00:00',
            ];
        }

        $customer_balance = $balanceModel->getBalanceByCustomerID($this->session->get('customer_id'))['total'];

        $data['currency'] = $this->session->get('currency') ?? $this->registry->get('config_currency');

        $data['balance'] = $this->currencyFormat($customer_balance);

        if ($this->request->getPost('amount')) {
            $data['amount'] = $this->request->getPost('amount');
        } elseif ($customer_balance) {
            $data['amount'] = number_format((float)$customer_balance, 2, '.', '');
        } else {
            $data['amount'] = '';
        }

        if ($this->request->getPost('customer_id')) {
            $data['customer_id'] = $this->request->getPost('customer_id');
        } else {
            $data['customer_id'] = $customer_id;
        }

        if ($this->request->getPost('status_id')) {
            $data['status_id'] = $this->request->getPost('customer_id');
        } elseif ($this->registry->get('config_withdraw_status_id')) {
            $data['status_id'] = $this->registry->get('config_withdraw_status_id');
        } else {
            $data['status_id'] = 1;
        }

        $data['action'] = base_url('freelancer/withdrwa/add');

        $data['heading_title'] = lang('freelancer/withdraw.heading_title');
        $data['entry_amount']  = lang('freelancer/withdraw.entry_amount');
        $data['text_balance']  = lang('freelancer/withdraw.text_balance');
        $data['text_total']    = lang('freelancer/withdraw.text_total');
        $data['button_submit'] = lang('freelancer/withdraw.button_submit');
        $data['column_amount'] = lang('freelancer/withdraw.column_amount');
        $data['column_status'] = lang('freelancer/withdraw.column_status');
        $data['column_date'] = lang('freelancer/withdraw.column_date');
        $data['column_date_added'] = lang('freelancer/withdraw.column_date_added');

        $this->template->output('freelancer/withdraw', $data);
    }

    //--------------------------------------------------------------------
}
