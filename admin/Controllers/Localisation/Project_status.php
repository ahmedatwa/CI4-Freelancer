<?php namespace Admin\Controllers\Localisation;

use \Admin\Models\Localisation\ProjectStatusModel;
use \Admin\Models\Localisation\LanguageModel;

class Project_status extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $projectStatusModel = new ProjectStatusModel();

        $this->document->setTitle(lang('localisation/project_status.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('localisation/project_status.list.text_add'));

        $projectStatusModel = new ProjectStatusModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $projectStatusModel->addProjectStatus($this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/project_status?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/project_status.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('localisation/project_status.list.text_edit'));

        $projectStatusModel = new ProjectStatusModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $projectStatusModel->editProjectStatus($this->request->getVar('project_status_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/project_status?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/project_status.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $projectStatusModel = new ProjectStatusModel();
   
        $this->document->setTitle(lang('localisation/project_status.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $project_status_id) {
                $projectStatusModel->delete($project_status_id);
                $json['success'] = lang('localisation/project_status.text_success');
                $json['redirect'] = 'index.php/localisation/project_status?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('localisation/project_status.error_permission');
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
            'text' => lang('localisation/project_status.list.heading_title'),
            'href' => base_url('index.php/localisation/project_status?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['project_statuses'] = [];
        $projectStatusModel = new ProjectStatusModel();

        $results = $projectStatusModel->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['project_statuses'][] = [
                'project_status_id' => $result['status_id'],
                'name'              => $result['name'],
                'edit'              => base_url('index.php/localisation/project_status/edit?user_token=' . $this->request->getVar('user_token') . '&project_status_id=' . $result['status_id']),
                'delete'            => base_url('index.php/localisation/project_status/delete?user_token=' . $this->request->getVar('user_token') . '&project_status_id=' . $result['status_id']),
            ];
        }

        $data['add'] = base_url('index.php/localisation/project_status/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/localisation/project_status/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('localisation/project_status_list', $data);
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
            'text' => lang('localisation/project_status.list.heading_title'),
            'href' => base_url('index.php/localisation/project_status/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('project_status_id') ? lang('localisation/project_status.list.text_add') : lang('localisation/project_status.list.text_edit');

        $data['cancel'] = base_url('index.php/localisation/project_status?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('project_status_id')) {
            $data['action'] = base_url('index.php/localisation/project_status/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/localisation/project_status/edit?user_token=' . $this->request->getVar('user_token') . '&project_status_id=' . $this->request->getVar('project_status_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $languageModel = new LanguageModel();
        $data['languages'] = $languageModel->findAll($this->registry->get('config_admin_limit'));
        
        if ($this->request->getPost('project_status')) {
            $data['project_status'] = $this->request->getPost('project_status');
        } elseif ($this->request->getVar('project_status_id')) {
            $data['project_status'] = $projectStatusModel->getProjectStatusDescriptions($this->request->getVar('project_status_id'));
        } else {
            $data['project_status'] = [];
        }

        $this->document->output('localisation/project_status_form', $data);
    }

    protected function validateForm()
    {
        foreach ($this->request->post('project_status') as $language_id => $value) {
            if (! $this->validate([
                "project_status.{$project_id}.name" => [
                    'label' => 'Language Name',
                    'rules' => 'required|min_length[3]|max_length[32]',
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', 'localisation/project_status')) {
            $this->session->setFlashdata('error_warning', lang('localisation/project_status.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'localisation/project_status')) {
            $this->session->setFlashdata('error_warning', lang('localisation/project_status.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
