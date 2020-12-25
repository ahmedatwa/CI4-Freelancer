<?php namespace Admin\Controllers\Common;

use \Admin\Models\User\UserModel;

class Login extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('common/login.text_title'));
        
        if ($this->user->isLogged() && $this->session->get('user_token')) {
            return redirect()->to(base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')));
        }

        if (($this->request->getMethod() == 'post') && $this->validateFrom()) {
            // set the user_token
            $this->session->set('user_token', token('alnum', 32));
            
            if ($this->request->getPost('redirect')) {
                return redirect()->to($this->request->getPost('redirect') . '?user_token=' . $this->session->get('user_token'));
            } else {
                // Register Login Event
                \CodeIgniter\Events\Events::trigger('activity_user_login');

                return redirect()->to(base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')));
            }
        }

        // user_token validation
        if (($this->request->getVar('user_token') &&  ! $this->request->getGet('user_token')) || ($this->request->getGet('user_token') &&  $this->request->getVar('user_token') && $this->request->getGet('user_token') != $this->request->getVar('user_token'))) {
            $this->session->setFlashData('warning', lang('en.error.error_token'));
            //clear session
            $this->user->logout();
        }

        if ($this->session->getFlashdata('warning')) {
            $data['warning'] = $this->session->getFlashdata('warning');
        } else {
            $data['warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $data['action'] = base_url('index.php/common/login');
        $data['forgot'] = base_url('index.php/common/forgotten');

        $data['base'] = slash_item('baseURL');
    
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
            $data['redirect'] = base_url('index.php/' . $this->request->getVar('redirect'));
        } else {
            $data['redirect'] = '';
        }

        $data['text_title']           = lang('common/login.text_title');
        $data['button_login']         = lang('common/login.button_login');
        $data['heading_title']        = lang('common/login.heading_title');
        $data['text_forget_password'] = lang('common/login.text_forget_password');
        $data['text_keep_signed']     = lang('common/login.text_keep_signed');
        $data['entry_email']          = lang('common/login.entry_email');
        $data['entry_password']       = lang('common/login.entry_password');

        return $this->document->output('common/login', $data);
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

        // Fields Validation Rules
        if (! $this->validate([
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[4]'
        ]) || !$this->user->login($this->request->getPost('email', FILTER_SANITIZE_EMAIL), $this->request->getPost('password'))) {
            // Register Fail Login Event
            \CodeIgniter\Events\Events::trigger('login_attempts', $this->request->getPost('email', FILTER_SANITIZE_EMAIL));
            $this->session->setFlashData('warning', lang('common/login.text_warning'));
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------
}
