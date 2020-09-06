<?php namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\Customers;

class Login extends BaseController
{
    protected $customers;

    public function index()
    {
        $this->customers = new Customers();

        $json = array();

        if (($this->request->getMethod() == 'post') && $this->validationRules()) {
            if ($this->request->getPost('redirect')) {
                $json['redirect'] = $this->request->getPost('redirect');
            } else {
                $json['redirect'] = base_url('/');
            }
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

        if ($this->request->getVar('redirect')) {
            $data['redirect'] = base_url('index.php/' . $this->request->getVar('redirect'));
        } else {
            $data['redirect'] = '';
        }
        return $this->response->setJSON($json);
    }

    protected function validationRules()
    {
        // Fields Validation Rules
        if (! $this->validate([
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[4]',
        ])) 
        {
            $this->session->setFlashData('error_warning', lang('account/login.text_warning'));
        }
        
        // Check how many login attempts have been made.
        $login_info = $this->customers->getLoginAttempts($this->request->getPost('email'));

        if ($login_info && ($login_info['total'] >= getSettingItem('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->session->setFlashData('error_warning', lang('account/login.error_attempts'));
            return false;
        }
        
        if ( !$this->customer->login($this->request->getPost('email'), $this->request->getPost('password'))) {
                 $this->session->setFlashData('error_warning', lang('account/login.text_warning'));
                 $this->customers->addLoginAttempt($this->request->getPost('email'), $this->request->getIPAddress());
                 return false;
        } else {
                 $this->customers->deleteLoginAttempts($this->request->getPost('email'));
        }

        return true;
    }

    //--------------------------------------------------------------------
}
