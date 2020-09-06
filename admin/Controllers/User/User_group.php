<?php namespace Admin\Controllers\User;

class User_group extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->users_group = new \Admin\Models\User\Users_group();

        $this->document->setTitle(lang('user/user_group.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('user/user_group.list.text_add'));

        $this->users_group = new \Admin\Models\User\Users_group();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->users_group->addUserGroup($this->request->getPost());
            return redirect()->to(base_url('index.php/user/user_group?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('user/user_group.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('user/user_group.list.text_edit'));

        $this->users_group = new \Admin\Models\User\Users_group();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->users_group->editUserGroup($this->request->getVar('user_group_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/user/user_group?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('user/user_group.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = array();

        $this->users_group = new \Admin\Models\User\Users_group();
   
        $this->document->setTitle(lang('user/user_group.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $user_group_id) {
                $this->users_group->delete($user_group_id);
                $json['success'] = lang('user/user_group.text_success');
                $json['redirect'] = 'index.php/user/user_group?user_token=' . $this->session->get('user_token');
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
            'text' => lang('user/user_group.list.heading_title'),
            'href' => base_url('index.php/user/user_group?user_token=' . $this->session->get('user_token')),
        );

        // Data
        $data['user_groups'] = array();
        $results = $this->users_group->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['user_groups'][] = array(
                'user_group_id'    => $result['user_group_id'],
                'name'      => $result['name'],
                'date_added' => DateShortFormat($result['date_added']),
                'edit'       => base_url('index.php/user/user_group/edit?user_token=' . $this->session->get('user_token') . '&user_group_id=' . $result['user_group_id']),
                'delete'     => base_url('index.php/user/user_group/delete?user_token=' . $this->session->get('user_token') . '&user_group_id=' . $result['user_group_id']),
            );
        }

        $data['add'] = base_url('index.php/user/user_group/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/user/user_group/delete?user_token=' . $this->session->get('user_token'));

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

        $this->document->output('user/user_group_list', $data);
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
            'text' => lang('user/user_group.list.heading_title'),
            'href' => base_url('index.php/user/user_group/save?user_token=' . $this->session->get('user_token')),
        );

        $data['text_form'] = !$this->request->getGet('user_group_id') ? lang('user/user_group.list.text_add') : lang('user/user_group.list.text_edit');

        $data['cancel'] = base_url('index.php/user/user_group?user_token=' . $this->session->get('user_token'));

        if (!$this->request->getGet('user_group_id')) {
            $data['action'] = base_url('index.php/user/user_group/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/user/user_group/edit?user_token=' . $this->session->get('user_token') . '&user_group_id=' . $this->request->getGet('user_group_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getGet('user_group_id') && ($this->request->getMethod() != 'post')) {
            $user_group_info = $this->users_group->getUserGroup($this->request->getGet('user_group_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($user_group_info)) {
            $data['name'] = $user_group_info['name'];
        } else {
            $data['name'] = '';
        }

        $ignore = array(
            'common/column_left',
            'common/dashboard',
            'common/footer',
            'common/forgotten',
            'common/header',
            'common/login',
            'common/logout',
            'error/not_found',
            'error/permission',
            'basecontroller'
        );

        $data['permissions'] = array();

        $files = array();

        helper('filesystem');

        $default = get_filenames(APPPATH . 'Controllers/', true, false);
        $modules = get_filenames(APPPATH . 'Modules/Controllers/', true, false);

        $map = array_merge($default, $modules);

        foreach ($map as $file) {
                $controller = str_replace('controllers/', '', str_replace('modules/', '', substr(strtolower($file), strlen(APPPATH))));


            $permission = substr($controller, 0, strrpos($controller, '.'));

            if (!empty($permission) && !in_array($permission, $ignore)) {
                $data['permissions'][] = $permission;
            }
        }
                
        if ($this->request->getPost('access')) {
            $data['access'] = $this->request->getPost('access');
        } elseif (!empty($user_group_info['permission']['access'])) {
            $data['access'] = $user_group_info['permission']['access'];
        } else {
            $data['access'] = array();
        }

        if ($this->request->getPost('modify')) {
            $data['modify'] = $this->request->getPost('modify');
        } elseif (!empty($user_group_info['permission']['modify'])) {
            $data['modify'] = $user_group_info['permission']['modify'];
        } else {
            $data['modify'] = array();
        }

        $this->document->output('user/user_group_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
            'name' => 'required|min_length[4]',
        ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('user/user_group.error_permission'));
            return false;
        }
        return true;
    }
    
    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('user/user_group.error_permission'));
            return false;
        }
        return true;
    }

    //--------------------------------------------------------------------
}
