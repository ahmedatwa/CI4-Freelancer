<?php namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\Customers;

class Register extends BaseController
{
    protected $customers;

    public function index()
    {
        $this->customers = new Customers();

        $json = array();

        if (($this->request->getMethod() == 'post') && $this->validationRules()) {

            $customer_id = $this->customers->addCustomer($this->request->getPost());

            // Clear any previous login attempts for unregistered accounts.
            $this->customers->deleteLoginAttempts($this->request->getPost('email'));

            $this->customer->login($this->request->getPost('email'), $this->request->getPost('password'));

            $json['success'] = lang('cccount/register.text_success');
            $json['redirect'] = base_url('/');
        } else {
            $json['error_warning'] = $this->session->getFlashdata('error_warning');
            $json['validator'] = $this->validator->getErrors();
        }
    
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

        return $this->response->setJSON($json);

    }

    protected function validationRules()
    {
        // Fields Validation Rules
        if (! $this->validate([
            'email'    => 'required|valid_email|is_unique[customer.email]',
            'password' => 'required|min_length[4]',
            'confirm'  => 'required_with[password]|matches[password]',
            ])) {
            
            $this->session->setFlashData('error_warning', lang('cccount/register.text_warning'));
        } else {
            return true;
        }
    }

    //--------------------------------------------------------------------
}
