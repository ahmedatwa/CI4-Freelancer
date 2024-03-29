<?php namespace Admin\Controllers\Common;

use \Admin\Models\User\UserModel;

class Login extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('common/login.list.heading_title'));
        $this->document->addScript('assets/vendor/tilt/tilt.jquery.min.js');

        if ($this->user->isLogged() && $this->session->get('user_token')) {
            return redirect()->to(base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')));
        }

        // user_token validation
        if (($this->request->getVar('user_token') &&  ! $this->request->getGet('user_token')) || ($this->request->getGet('user_token') &&  $this->request->getVar('user_token') && $this->request->getGet('user_token') != $this->request->getVar('user_token'))) {
            $this->session->setFlashData('warning', lang('en.error.error_token'));
            //clear session
            $this->user->logout();
        }

        $data['forgot'] = sprintf(lang('common/login.list.text_forget_password'), base_url('index.php/common/forgotten'));
        $data['login']  = base_url('index.php/common/login');
        $data['base']   = slash_item('baseURL');
    
        if (!empty($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        if (!empty($this->request->getPost('password'))) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        if ($this->request->getVar('redirect')) {
            $data['redirect'] = base_url('index.php/' . $this->request->getVar('redirect', FILTER_SANITIZE_URL));
        } else {
            $data['redirect'] = '';
        }

        return $this->document->output('common/login', $data);
    }

    public function authLogin()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            if (! $this->validate([
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[4]',
        ]) || ! $this->user->login($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getPost('password'))) {
                // Register Fail Login Event
                \CodeIgniter\Events\Events::trigger('login_attempts', $this->request->getPost('email', FILTER_SANITIZE_EMAIL));
                $json['validator'] = $this->validator->getErrors();
                $json['error'] = lang('common/login.text_warning');
            }

            if ($this->session->getFlashdata('warning')) {
                $json['warning'] = $this->session->getFlashdata('warning');
            }

            $throttler = \Config\Services::throttler();
            if ($throttler->check($this->request->getIPAddress(), 60, MINUTE) === false) {
                $json['throttler'] = $this->response->setStatusCode(429);
            }

            if ((! $json) && ($this->request->getMethod() == 'post')) {
                // set the user_token
                $this->session->set('user_token', token('alnum', 32));
        
                if ($this->request->getPost('redirect', FILTER_VALIDATE_URL)) {
                    $json['redirect'] = $this->request->getPost('redirect', FILTER_VALIDATE_URL) . '?user_token=' . $this->session->get('user_token');
                } else {
                    // Register Login Event
                    \CodeIgniter\Events\Events::trigger('activity_user_login');
                    $json['redirect'] = 'index.php/common/dashboard?user_token=' . $this->session->get('user_token');
                }
            }
        }
        
        return $this->response->setJSON($json);
    }

    protected function validateFrom()
    {
        // Check how many login attempts have been made.
        $userModel = new UserModel();

        $login_info = $userModel->getLoginAttempts($this->request->getPost('email', FILTER_SANITIZE_EMAIL));
        if ($login_info && ($login_info['total'] >= $this->registry->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
            $this->session->setFlashData('warning', lang('common/login.error_attempts'));
            return false;
        } else {
            $userModel->deleteLoginAttempts($this->request->getPost('email', FILTER_SANITIZE_EMAIL));
        }
        
        return true;
    }

    //--------------------------------------------------------------------
}
