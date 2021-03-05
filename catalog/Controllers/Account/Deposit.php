<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\DepositModel;

class Deposit extends BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged() ) {
            return redirect('account_login');
        }

        $this->template->setTitle(lang('account/deposit.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('freelancer/freelancer.heading_title'),
            'href' => base_url('freelancer/freelancer'),
        ];

        $data['processing_fee'] = $this->registry->get('config_processing_fee');

        if ($this->request->getCookie(config('App')->cookiePrefix . 'currency')) {
            $data['currency'] = \Config\Services::encrypter()->decrypt(base64_decode($this->request->getCookie(config('App')->cookiePrefix . 'currency', FILTER_SANITIZE_STRING)));
        } else {
            $data['currency'] = $this->registry->get('config_currency');
        }
   
        $data['customer_id'] = $this->session->get('customer_id') ?? 0;

        $data['langData'] = lang('account/deposit.list');

        $this->template->output('account/deposit', $data);
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
                    'amount'      => $this->request->getPost('amount'),
                    'currency'    => $this->request->getPost('currency'),
                    'status'      => strtolower($this->request->getPost('status')),
                ];

                $depositModel->deposit($data);

                $json['success'] = lang('account/deposit.text_success');
            }
        }
        return $this->response->setJSON($json);
    }

    
    //--------------------------------------------------------------------
}
