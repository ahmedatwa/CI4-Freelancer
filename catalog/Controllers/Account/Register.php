<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Register extends \Catalog\Controllers\BaseController
{
    public function index()
    {
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

        $customerModel = new CustomerModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {

        $customer_id = $customerModel->addCustomer($this->request->getPost());

            // Clear any previous login attempts for unregistered accounts.
            $customerModel->deleteLoginAttempts($this->request->getPost('email'));
            //helper('text');
            //$customerModel->editCode($this->request->getPost('email'), random_string('alnum', 40));
            $this->session->setFlashdata('success', lang('account/register.text_success'));
        }

        $data['entry_email']     = lang('account/register.entry_email');
        $data['entry_password']  = lang('account/register.entry_password');
        $data['entry_confirm']   = lang('account/register.entry_confirm');
        $data['heading_title']   = lang('account/register.heading_title');
        $data['text_login']      = sprintf(lang('account/register.text_login'), route_to('account_login') ? route_to('account_login') : base_url('account/login'));
        $data['text_register']   = lang('account/register.text_register');
        $data['button_register'] = lang('account/register.button_register');


        $data['action'] = route_to('account_register') ? route_to('account_register') : base_url('account/register');

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->request->getPost('confirm')) {
            $data['confirm'] = $this->request->getPost('confirm');
        } else {
            $data['confirm'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $this->template->output('account/register', $data);
    }

    protected function validateForm()
    {
        // Fields Validation Rules
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
            $this->session->setFlashData('error_warning', lang('account/register.text_warning'));
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------
}
