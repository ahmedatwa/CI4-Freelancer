<?php namespace Admin\Controllers\Common;

use \Admin\Models\User\UserModel;

class Forgotten extends \Admin\Controllers\BaseController
{

    public function index()
    {
        $data['title'] = lang('common/forgotten.text_title');

        $userModel = new UserModel();

        if ($this->user->isLogged() && $this->session->has('user_token') == !is_null($this->request->getVar('user_token'))) {
            return redirect()->to(base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')));
        }

        if (($this->request->getMethod(true) == 'POST') && $this->validateForm()) {
            $userModel->editCode($this->request->getPost('email', FILTER_SANITIZE_EMAIL), token('alpha', 40));
            
            $this->session->setFlashData('success', lang('common/forgotten.text_success'));

            return redirect()->to(base_url('index.php/common/login'));
        }

        if ($this->session->get('error')) {
            $data['error'] = $this->session->get('error');
        } else {
            $data['error'] = '';
        }


        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email', FILTER_SANITIZE_EMAIL);
        } else {
            $data['email'] = '';
        }

        $data['action'] = base_url('index.php/common/forgotten');
        $data['cancel'] = base_url('index.php/common/login');

        $this->document->output('common/forgotten', $data);
    }

    protected function validateForm()
    {
        $userModel = new UserModel();

        if (! $this->validate([
            'email' => 'required|valid_email',
        ]) || ! $userModel->getTotalUsersByEmail($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
            $this->session->setFlashData('error', lang('common/forgotten.error-email'));
        }
        return true;
    }
} //------------------------------------------------
