<?php namespace Admin\Controllers\Common;

class Forgotten extends \Admin\Controllers\BaseController
{
    protected $users;

    public function index()
    {
        $data['title'] = lang('common/forgotten.text_title');

        $users = new \Admin\Models\User\Users();

        if ($this->user->isLogged() && $this->session->has('user_token') == !is_null($this->request->getGet('user_token'))) {
            return redirect()->to(base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')));
        }

        if (($this->request->getMethod(true) == 'POST') && $this->Rules()) {
            $users->editCode($this->request->getPost('email'), token('alpha', 40));
            
            $this->session->setFlashData('success', lang('common/forgotten.textSuccess'));

            return redirect()->to(base_url('index.php/common/login'));
        }

        if ($this->session->get('error')) {
            $data['error'] = $this->session->get('error');
        } else {
            $data['error'] = '';
        }


        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        $data['action'] = base_url('index.php/common/forgotten');
        $data['cancel']  = base_url('index.php/common/login');

        echo view('common/forgotten', $data);
    }

    protected function Rules()
    {
        $users = new \Admin\Models\User\Users();

        if (! $this->validate([
            'email' => 'required|valid_email',
        ]) || ! $users->getTotalUsersByEmail($this->request->getPost('email'))) {
            $this->session->setFlashData('error', lang('common/forgotten.errorEmail'));
        }
        return true;
    }
} //------------------------------------------------
