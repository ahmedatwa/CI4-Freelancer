<?php namespace Catalog\Controllers\Freelancer;

use Catalog\Models\Freelancer\DepositModel;

class Deposit extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('freelancer/deposit.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('freelancer/freelancer.heading_title'),
            'href' => base_url('freelancer/freelancer'),
        ];

        $data['heading_title'] = lang('freelancer/deposit.heading_title');
        $data['text_fee']      = lang('freelancer/deposit.text_fee');
        $data['text_total']    = lang('freelancer/deposit.text_total');
        $data['entry_amount']  = lang('freelancer/deposit.entry_amount');
        $data['']              = lang('freelancer/deposit.button_view');
        $data['']              = lang('freelancer/deposit.button_view');

        $data['processing_fee'] = $this->registry->get('config_processing_fee');

        $data['currency'] = $this->session->get('currency') ? $this->session->get('currency') : $this->registry->get('config_currency');
   
        $data['customer_id'] = $this->session->get('customer_id') ?? 0;

        $this->template->output('freelancer/deposit', $data);
    }


    public function addFunds()
    {
        $json = [];

        if ($this->request->getVar('customer_id')) {

            $customer_id = $this->request->getVar('customer_id');

            if ($this->request->getMethod() == 'post') {
                $depositModel = new DepositModel();
                $data = [
                    'customer_id' => $customer_id,
                    'amount'   => $this->request->getPost('amount'),
                    'currency'   => $this->request->getPost('currency'),
                    'status'      => strtolower($this->request->getPost('status')),
                ];

                $depositModel->insertFunds($data);

                $json['success'] = lang('freelancer/deposit.text_success');
            }
        }
        return $this->response->setJSON($json);
    }

    
    //--------------------------------------------------------------------
}
