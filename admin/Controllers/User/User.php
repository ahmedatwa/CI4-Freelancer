<?php namespace Admin\Controllers\User;

class User extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->users = new \Admin\Models\User\Users();

        $this->document->setTitle(lang('user/user.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('user/user.list.text_add'));

        $this->users = new \Admin\Models\User\Users();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->users->insert($this->request->getPost());
            return redirect()->to(base_url('index.php/user/user?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('user/user.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('user/user.list.text_edit'));

        $this->users = new \Admin\Models\User\Users();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->users->update($this->request->getVar('user_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/user/user?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('user/user.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = array();

        $this->users = new \Admin\Models\User\Users();
   
        $this->document->setTitle(lang('user/user.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $user_id) {
                $this->users->delete($user_id);
                $json['success'] = lang('user/user.text_success');
                $json['redirect'] = 'index.php/user/user?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('user/user.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('user/user.list.heading_title'),
            'href' => base_url('index.php/user/user?user_token=' . $this->session->get('user_token')),
        );

        // Data
        $data['users'] = array();
        $results = $this->users->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['users'][] = array(
                'user_id'    => $result['user_id'],
                'email'      => $result['email'],
                'date_added' => DateShortFormat($result['date_added']),
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'       => base_url('index.php/user/user/edit?user_token=' . $this->session->get('user_token') . '&user_id=' . $result['user_id']),
                'delete'     => base_url('index.php/user/user/delete?user_token=' . $this->session->get('user_token') . '&user_id=' . $result['user_id']),
            );
        }

        $data['add'] = base_url('index.php/user/user/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/user/user/delete?user_token=' . $this->session->get('user_token'));

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = array();
        }

        $data['user_token'] = $this->request->getGet('user_token');

        $this->document->output('user/user_list', $data);
    }

    protected function getForm()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('user/user.list.heading_title'),
            'href' => base_url('index.php/user/user/edit?user_token=' . $this->session->get('user_token')),
        );

        $data['text_form'] = !$this->request->getGet('user_id') ? lang('user/user.list.text_add') : lang('user/user.list.text_edit');

        $data['cancel'] = base_url('index.php/user/user?user_token=' . $this->session->get('user_token'));

        if (!$this->request->getGet('user_id')) {
            $data['action'] = base_url('index.php/user/user/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/user/user/edit?user_token=' . $this->session->get('user_token') . '&user_id=' . $this->request->getGet('user_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getGet('user_id') && ($this->request->getMethod() != 'post')) {
            $user_info = $this->users->find($this->request->getGet('user_id'));
        }

        if (!empty($user_info['user_id'])) {
            $data['user_id'] = $user_info['user_id'];
        } else {
            $data['user_id'] = 0;
        }

        if ($this->request->getPost('firstname')) {
            $data['firstname'] = $this->request->getPost('firstname');
        } elseif (!empty($user_info)) {
            $data['firstname'] = $user_info['firstname'];
        } else {
            $data['firstname'] = '';
        }

        if ($this->request->getPost('lastname')) {
            $data['lastname'] = $this->request->getPost('lastname');
        } elseif (!empty($user_info)) {
            $data['lastname'] = $user_info['lastname'];
        } else {
            $data['lastname'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } elseif (!empty($user_info)) {
            $data['email'] = $user_info['email'];
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

        if ($this->request->getPost('image')) {
            $data['image'] = $this->request->getPost('image');
        } elseif (!empty($user_info)) {
            $data['image'] = $user_info['image'];
        } else {
            $data['image'] = '';
        }

        if ($this->request->getPost('image') && is_file(DIR_IMAGE . $this->request->getPost('image'))) {
            $data['thumb'] = resizeImage($this->request->getPost('image'), 100, 100);
        } elseif (!empty($user_info) && is_file(DIR_IMAGE . $user_info['image'])) {
            $data['thumb'] = resizeImage($user_info['image'], 100, 100);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 100, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        // UserGroup
        $users_group = new \Admin\Models\User\Users_group();

        $data['user_groups'] = $users_group->findAll();
        
        if ($this->request->getPost('user_group_id')) {
            $data['user_group_id'] = $this->request->getPost('user_group_id');
        } elseif (!empty($user_info)) {
            $data['user_group_id'] = $user_info['user_group_id'];
        } else {
            $data['user_group_id'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($user_info)) {
            $data['status'] = $user_info['status'];
        } else {
            $data['status'] = 1;
        }

        $this->document->output('user/user_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->request->getGet('user_id')) {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'email'     => 'required|valid_email|is_unique[user.email,user_id,{user_id}]',
                    'password'  => 'required|min_length[4]',
                    'confirm'   => 'required_with[password]|matches[password]',
                    ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        } else {
            if (! $this->validate([
                    'firstname' => 'required|alpha_numeric_space|min_length[3]',
                    'lastname'  => 'required|alpha_numeric_space|min_length[3]',
                    'email'     => 'required|valid_email|is_unique[user.email,user_id,{user_id}]',
                    ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('user/user.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('user/user.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
