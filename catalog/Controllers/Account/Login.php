<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Login extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('account/login.heading_title'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/login.heading_title'),
            'href' => base_url('account/login'),
        ];

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
                return redirect()->to(base_url('account/dashboard'));
            }
        

        $data['heading_title']  = lang('account/login.heading_title');
        $data['text_login']     = lang('account/login.text_login');
        $data['text_forgotten'] = lang('account/login.text_forgotten');
        $data['text_register']  = sprintf(lang('account/login.text_register'), base_url('account/register'));
        $data['entry_email']    = lang('account/login.entry_email');
        $data['entry_password'] = lang('account/login.entry_password');
        $data['button_login']   = lang('account/login.button_login');


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

        if ($this->request->getVar('redirect')) {
            $data['redirect'] = base_url($this->request->getVar('redirect'));
        } else {
            $data['redirect'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $data['action'] = base_url('account/login');

        $this->template->output('account/login', $data);
    }

    protected function validateForm()
    {
        // Fields Validation Rules
        if (! $this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[4]',
        ])) 
        {
            $this->session->setFlashData('error_warning', lang('account/login.text_warning'));
        }

        $customerModel = new CustomerModel();
        // Check how many login attempts have been made.
        $login_info = $customerModel->getLoginAttempts($this->request->getPost('email'));

        if ($login_info && ($login_info['total'] >= $this->registry->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->session->setFlashData('error_warning', lang('account/login.error_attempts'));
            return false;
        }
        
        if ( !$this->customer->login($this->request->getPost('email'), $this->request->getPost('password'))) {
                 $this->session->setFlashData('error_warning', lang('account/login.text_warning'));
                 $customerModel->addLoginAttempt($this->request->getPost('email'), $this->request->getIPAddress());
                 return false;
        } else {
                $customerModel->deleteLoginAttempts($this->request->getPost('email'));
        }

        return true;
    }

    //--------------------------------------------------------------------
}
