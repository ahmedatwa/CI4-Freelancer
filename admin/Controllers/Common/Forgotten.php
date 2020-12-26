<?php namespace Admin\Controllers\Common;

use \Admin\Models\User\UserModel;

class Forgotten extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('common/forgotten.list.heading_title'));

        $userModel = new UserModel();

        if ($this->user->isLogged() && $this->session->has('user_token') == !is_null($this->request->getVar('user_token'))) {
            return redirect()->to(base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')));
        }

        $data['cancel'] = base_url('index.php/common/login');

        $this->document->output('common/forgotten', $data);
    }

    public function resetPassword()
    {
        $json = [];

        if ($this->request->isAJAX()) {
            $userModel = new UserModel();
            if (! $this->validate([
             'email' => 'required|valid_email',
            ])) {
                $json['error'] = $this->validator->getError('email');
            }

            if (! $userModel->getTotalUsersByEmail($this->request->getPost('email', FILTER_SANITIZE_EMAIL))) {
                $json['error_record'] = lang('common/forgotten.error_email');
            }

            $throttler = \Config\Services::throttler();
            if ($throttler->check($this->request->getIPAddress(), 60, MINUTE) === false) {
                $json['throttler'] = $this->response->setStatusCode(429);
            }

            if ((! $json) && ($this->request->getMethod() == 'post')) {
                $userModel->editCode($this->request->getPost('email', FILTER_SANITIZE_EMAIL), token('alpha', 40));
                $json['success'] = lang('common/forgotten.text_success');
                $json['redirect'] = 'index.php/common/login';
            }
        }
        
        return $this->response->setJSON($json);
    }
} //------------------------------------------------
