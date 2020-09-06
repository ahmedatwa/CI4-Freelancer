<?php namespace Admin\Controllers\Localisation;

class Language extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->languages = new \Admin\Models\Localisation\Languages();

        $this->document->setTitle(lang('localisation/language.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('localisation/language.list.text_add'));

        $this->languages = new \Admin\Models\Localisation\Languages();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->languages->addLanguage($this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/language?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('localisation/language.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('localisation/language.list.text_edit'));

        $this->languages = new \Admin\Models\Localisation\Languages();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->languages->editLanguage($this->request->getVar('language_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/language?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('localisation/language.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = array();

        $this->languages = new \Admin\Models\Localisation\Languages();
   
        $this->document->setTitle(lang('localisation/language.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $language_id) {
                $this->languages->delete($language_id);
                $json['success'] = lang('localisation/language.text_success');
                $json['redirect'] = 'index.php/localisation/language?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('localisation/language.error_permission');
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
            'text' => lang('localisation/language.list.heading_title'),
            'href' => base_url('index.php/localisation/language?user_token=' . $this->session->get('user_token')),
        );

        // Data
        $data['languages'] = array();
        $results = $this->languages->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['languages'][] = array(
                'language_id' => $result['language_id'],
                'name'        => $result['name'],
                'code'        => $result['name'],
                'edit'        => base_url('index.php/localisation/language/edit?user_token=' . $this->session->get('user_token') . '&language_id=' . $result['language_id']),
                'delete'      => base_url('index.php/localisation/language/delete?user_token=' . $this->session->get('user_token') . '&language_id=' . $result['language_id']),
            );
        }

        $data['add'] = base_url('index.php/localisation/language/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/localisation/language/delete?user_token=' . $this->session->get('user_token'));

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

        $this->document->output('localisation/language_list', $data);
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
            'text' => lang('localisation/language.list.heading_title'),
            'href' => base_url('index.php/localisation/language/edit?user_token=' . $this->session->get('user_token')),
        );

        $data['text_form'] = !$this->request->getGet('language_id') ? lang('localisation/language.list.text_add') : lang('localisation/language.list.text_edit');

        $data['cancel'] = base_url('index.php/localisation/language?user_token=' . $this->session->get('user_token'));

        if (!$this->request->getGet('language_id')) {
            $data['action'] = base_url('index.php/localisation/language/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/localisation/language/edit?user_token=' . $this->session->get('user_token') . '&language_id=' . $this->request->getGet('language_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getGet('language_id') && ($this->request->getMethod() != 'post')) {
            $user_info = $this->languages->find($this->request->getGet('language_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($user_info['name'])) {
            $data['name'] = $user_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('code')) {
            $data['code'] = $this->request->getPost('code');
        } elseif (!empty($user_info['code'])) {
            $data['code'] = $user_info['code'];
        } else {
            $data['code'] = '';
        }

        helper('filesystem');
        $languages = directory_map(APPPATH . 'Language', 1);
        $data['languages'] = array();
        foreach ($languages as $language) {
            $data['languages'][] = rtrim($language, '/');
        }

        if ($this->request->getPost('locale')) {
            $data['locale'] = $this->request->getPost('locale');
        } elseif (!empty($user_info['locale'])) {
            $data['locale'] = $user_info['locale'];
        } else {
            $data['locale'] = '';
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($user_info['sort_order'])) {
            $data['sort_order'] = $user_info['sort_order'];
        } else {
            $data['sort_order'] = 1;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($user_info)) {
            $data['status'] = $user_info['status'];
        } else {
            $data['status'] = 1;
        }

        $this->document->output('localisation/language_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name' => [
                    'label' => 'Language Name',
                    'rules' => 'required|min_length[3]|max_length[32]',
                ],
                'code'  => [
                    'label' => 'Language Code',
                    'rules' => 'required|min_length[2]',
                ],
                'locale' => 'required',
                ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('localisation/language.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('localisation/language.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
