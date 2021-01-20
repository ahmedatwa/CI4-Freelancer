<?php namespace Catalog\Controllers\Account;

use \Catalog\Models\Account\CustomerModel;

class Register extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if ($this->customer->isLogged()) {
            return redirect()->route('account_dashboard');
        }

        $this->template->setTitle(lang('account/register.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/register.heading_title'),
            'href' => route_to('account_register') ? route_to('account_register') : base_url('account/register'),
        ];
        
        $data['entry_email']     = lang('account/register.entry_email');
        $data['entry_password']  = lang('account/register.entry_password');
        $data['entry_confirm']   = lang('account/register.entry_confirm');
        $data['heading_title']   = lang('account/register.heading_title');
        $data['text_login']      = sprintf(lang('account/register.text_login'), route_to('account_login') ? route_to('account_login') : base_url('account/login'));
        $data['text_register']   = lang('account/register.text_register');
        $data['button_register'] = lang('account/register.button_register');

        $this->template->output('account/register', $data);
    }

    public function create()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (! $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_unique[customer.email]',
                'errors' => [
                    'is_unique' => 'Warning: E-Mail Address is already registered!'
                ],
            ],
            'password' => 'required|min_length[4]',
            'confirm'  => 'required_with[password]|matches[password]',
            ])) {
                $json['errors'] = $this->validator->getErrors();
                $json['error_warning'] = lang('account/register.text_warning');
            }
        
            if (! $json && ($this->request->getMethod() == 'post')) {
                $customerModel = new CustomerModel();
                $customer_id = $customerModel->addCustomer($this->request->getPost());

                // Clear any previous login attempts for unregistered accounts.
                $customerModel->deleteLoginAttempts($this->request->getPost('email'));

                $this->customer->login($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getPost('password'));

                $this->session->setFlashdata('success', lang('account/register.text_success'));
                $json['redirect'] = base_url('account/success');
            }
        }


        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
