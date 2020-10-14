<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Forgotten extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('account/forgotten.heading_title'));

        $customerModel = new CustomerModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {

            helper('text');

            $customerModel->editCode($this->request->getPost('email'), random_string('alnum', 40));

            $this->session->setFlashdata('success', lang('account/forgotten.text_success'));

            return redirect()->to(base_url('account/login'));
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('account/forgotten.text_home'),
            'href' => base_url(),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('account/forgotten.heading_title'),
            'href' => base_url('account/forgot'),
        ];

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

        $data['heading_title']   = lang('account/forgotten.heading_title');
        $data['text_heading']    = lang('account/forgotten.text_heading');
        $data['text_subheading'] = lang('account/forgotten.text_subheading');
        $data['text_login']      = lang('account/forgotten.text_login');
        $data['entry_email']     = lang('account/forgotten.entry_email');
        $data['button_reset']    = lang('account/forgotten.button_reset');

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        $data['action'] = base_url('account/forgotten');

        $data['login'] = base_url('account/login');

        $this->template->output('account/forgotten', $data);
    }

   
    protected function validateForm()
    {
        $customerModel = new CustomerModel();
        
        if (! $this->validate([
              'email' => "required|valid_email",
           ])  || !$customerModel->getTotalCustomersByEmail($this->request->getPost('email')) ) {

                $this->session->setFlashData('error_warning', lang('account/forgotten.error_email'));

            return false;
        }

        return true;
    }

   // ------------------------------------------------------------- 
} 
