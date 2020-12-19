<?php namespace Admin\Controllers\Localisation;

use \Admin\Models\Localisation\LanguageModel;

class Language extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $languageModel = new LanguageModel();

        $this->document->setTitle(lang('localisation/language.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('localisation/language.list.text_add'));

        $languageModel = new LanguageModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $languageModel->addLanguage($this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/language?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/language.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('localisation/language.list.text_edit'));

        $languageModel = new LanguageModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $languageModel->editLanguage($this->request->getVar('language_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/language?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/language.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = array();

        $languageModel = new LanguageModel();
   
        $this->document->setTitle(lang('localisation/language.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $language_id) {
                $languageModel->delete($language_id);
                $json['success'] = lang('localisation/language.text_success');
                $json['redirect'] = 'index.php/localisation/language?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('localisation/language.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/language.list.heading_title'),
            'href' => base_url('index.php/localisation/language?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['languages'] = [];
        $languageModel = new LanguageModel();

        $results = $languageModel->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['languages'][] = [
                'language_id' => $result['language_id'],
                'name'        => $result['name'],
                'code'        => $result['name'],
                'edit'        => base_url('index.php/localisation/language/edit?user_token=' . $this->request->getVar('user_token') . '&language_id=' . $result['language_id']),
                'delete'      => base_url('index.php/localisation/language/delete?user_token=' . $this->request->getVar('user_token') . '&language_id=' . $result['language_id']),
            ];
        }

        $data['add'] = base_url('index.php/localisation/language/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/localisation/language/delete?user_token=' . $this->request->getVar('user_token'));

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
            $data['selected'] = [];
        }

        $data['user_token'] = $this->request->getVar('user_token');

        $this->document->output('localisation/language_list', $data);
    }

    protected function getForm()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/language.list.heading_title'),
            'href' => base_url('index.php/localisation/language/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = ! $this->request->getVar('language_id') ? lang('localisation/language.list.text_add') : lang('localisation/language.list.text_edit');

        $data['cancel'] = base_url('index.php/localisation/language?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('language_id')) {
            $data['action'] = base_url('index.php/localisation/language/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/localisation/language/edit?user_token=' . $this->request->getVar('user_token') . '&language_id=' . $this->request->getVar('language_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getVar('language_id') && ($this->request->getMethod() != 'post')) {
            $languageModel = new LanguageModel();
            $language_info = $languageModel->find($this->request->getVar('language_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($language_info['name'])) {
            $data['name'] = $language_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('code')) {
            $data['code'] = $this->request->getPost('code');
        } elseif (!empty($language_info['code'])) {
            $data['code'] = $language_info['code'];
        } else {
            $data['code'] = '';
        }

        helper('filesystem');

        $languages = directory_map(APPPATH . 'Language', 1);

        $data['languages'] = [];

        foreach ($languages as $language) {
            $data['languages'][] = rtrim($language, '/');
        }

        if ($this->request->getPost('locale')) {
            $data['locale'] = $this->request->getPost('locale');
        } elseif (!empty($language_info['locale'])) {
            $data['locale'] = $language_info['locale'];
        } else {
            $data['locale'] = '';
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($language_info['sort_order'])) {
            $data['sort_order'] = $language_info['sort_order'];
        } else {
            $data['sort_order'] = 1;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($language_info)) {
            $data['status'] = $language_info['status'];
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

        if (! $this->user->hasPermission('modify', 'localisation/language')) {
            $this->session->setFlashdata('error_warning', lang('localisation/language.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'localisation/language')) {
            $this->session->setFlashdata('error_warning', lang('localisation/language.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
