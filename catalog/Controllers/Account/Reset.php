<?php namespace Catalog\Controllers\Account;

use \Catalog\Models\Account\CustomerModel;

class Reset extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if ($this->customer->isLogged()) {
            return redirect()->route('account_dashboard');
        } 

        if ($this->request->getVar('code')) {
            $code = $this->request->getVar('code');
        } else {
            $code = '';
        }

        $customerModel = new CustomerModel();

        $customer_info = $customerModel->getCustomerByCode($code);

        if ($customer_info) {
            $this->template->setTitle(lang('account/reset.heading_title'));

            if (($this->request->getMethod() == 'post') && $this->validateForm()) {

                $customerModel->editPassword($customer_info['email'], $this->request->getPost('password'));

                $this->session->setFlashdata('success', lang('account/reset.text_success'));

                return redirect()->to(route_to('account_login') ? route_to('account_login') : base_url('account/login'));
            }

            $data['breadcrumbs'] = [];

            $data['breadcrumbs'][] = [
                'text' => lang($this->locale .'.text_home'),
                'href' => base_url()
            ];

            $data['breadcrumbs'][] = [
                'text' => lang('account/reset.text_account'),
                'href' => route_to('account_dashboard')
            ];

            $data['breadcrumbs'][] = [
                'text' => lang('account/reset.heading_title'),
                'href' => base_url('account/reset')
            ];

    
            $data['action'] = route_to('account_reset') .'?code=' . $code;

            $data['back'] = route_to('account_login');

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

			$data['heading_title']  = lang('account/reset.heading_title');
			$data['text_login']     = lang('account/reset.text_login');
			$data['entry_password'] = lang('account/reset.entry_password');
			$data['entry_confirm']  = lang('account/reset.entry_confirm');
			$data['button_reset']   = lang('account/reset.button_reset');


            $this->template->output('account/reset', $data);
        } else {
            $this->session->set('error', lang('account/reset.error_code'));

            return redirect()->route('account_login');
        }
    }

    protected function validateForm()
    {
        if (! $this->validate([
            'password'    => 'required|min_length[4]|max_length[40]',
            'confirm'     => 'required_with[password]|matches[password]',
        ])) {
            $this->session->setFlashData('error_warning', lang('account/login.text_warning'));
            return false;
        }

        return true;
    }

    //---------------------------------------------------------------
}
