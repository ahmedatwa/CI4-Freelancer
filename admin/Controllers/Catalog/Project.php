<?php namespace Admin\Controllers\Catalog;

use \Admin\Models\Catalog\ProjectModel;
use \Admin\Models\Customer\CustomerModel;
use \Admin\Models\Localisation\LanguageModel;

class Project extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();

        $this->document->setTitle(lang('catalog/project.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('catalog/project.list.text_add'));

        $projectModel = new ProjectModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $projectModel->addProject($this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/project?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('catalog/project.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('catalog/project.list.text_edit'));

        $projectModel = new ProjectModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $projectModel->update($this->request->getVar('project_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/project?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('catalog/project.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $projectModel = new ProjectModel();
   
        $this->document->setTitle(lang('catalog/project.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $project_id) {
                $projectModel->deleteProject($project_id);
                $json['success'] = lang('catalog/project.text_success');
                $json['redirect'] = 'index.php/catalog/project?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('catalog/project.error_permission');
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
            'text' => lang('catalog/project.list.heading_title'),
            'href' => base_url('index.php/catalog/project?user_token=' . $this->request->getVar('user_token')),
        ];

        $projectModel = new ProjectModel();

        $data['projects'] = [];

        // Data
        $filter_data = [
            'start'    => 0,
            'limit'    => $this->registry->get('config_admin_limit'),
        ];

        
        $results = $projectModel->getProjects($filter_data);

        foreach ($results as $result) {
            if ($result['type'] == 1) {
                $type = lang('catalog/project.list.text_fixed_price');
            } else {
                $type = lang('catalog/project.list.text_per_hour');
            }

            $data['projects'][] = [
                'project_id' => $result['project_id'],
                'name'       => $result['name'],
                'employer'   => $projectModel->getEmployerByProjectId($result['project_id']),
                'price'      => number_format($result['budget_min'], 2) . ' - ' . number_format($result['budget_max'], 2) . $this->registry->get('config_currency'),
                'type'       => $type,
                'status'     => $result['status'],
                'edit'       => base_url('index.php/catalog/project/edit?user_token=' . $this->request->getVar('user_token') . '&project_id=' . $result['project_id']),
                'delete'     => base_url('index.php/catalog/project/delete?user_token=' . $this->request->getVar('user_token') . '&project_id=' . $result['project_id']),
            ];
        }

        $data['add'] = base_url('index.php/catalog/project/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/catalog/project/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('catalog/project_list', $data);
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
            'text' => lang('catalog/project.list.heading_title'),
            'href' => base_url('index.php/catalog/project/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('project_id') ? lang('catalog/project.list.text_add') : lang('catalog/project.list.text_edit');

        $data['cancel'] = base_url('index.php/catalog/project?user_token=' . $this->request->getVar('user_token'));

        $data['user_token'] = $this->request->getGet('user_token');

        if (!$this->request->getVar('project_id')) {
            $data['action'] = base_url('index.php/catalog/project/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/catalog/project/edit?user_token=' . $this->request->getVar('user_token') . '&project_id=' . $this->request->getVar('project_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $projectModel = new ProjectModel();

        if ($this->request->getVar('project_id') && ($this->request->getMethod() != 'post')) {
            $project_info = $projectModel->getProject($this->request->getVar('project_id'));
        }

        if ($this->request->getPost('project_description')) {
            $data['project_description'] = $this->request->getPost('project_description');
        } elseif ($this->request->getVar('project_id')) {
            $data['project_description'] = $projectModel->getProjectDescription($this->request->getVar('project_id'));
        } else {
            $data['project_description'] = [];
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($project_info)) {
            $data['sort_order'] = $project_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if ($this->request->getPost('status_id')) {
            $data['status_id'] = $this->request->getPost('status_id');
        } elseif (!empty($project_info)) {
            $data['status_id'] = $project_info['status_id'];
        } else {
            $data['status_id'] = 1;
        }

        if ($this->request->getPost('type')) {
            $data['type'] = $this->request->getPost('type');
        } elseif (!empty($project_info)) {
            $data['type'] = $project_info['type'];
        } else {
            $data['type'] = 1;
        }

        if ($this->request->getPost('image')) {
            $data['image'] = $this->request->getPost('image');
        } elseif (!empty($project_info)) {
            $data['image'] = $project_info['image'];
        } else {
            $data['image'] = '';
        }

        if ($this->request->getPost('image') && is_file(DIR_IMAGE . $this->request->getPost('image'))) {
            $data['thumb'] = resizeImage($this->request->getPost('image'), 100, 100);
        } elseif (!empty($project_info) && is_file(DIR_IMAGE . $project_info['image'])) {
            $data['thumb'] = resizeImage($project_info['image'], 100, 100);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 100, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        // Employer
        $customerModel = new CustomerModel();
        $data['customers'] = $customerModel->getCustomers();

        if ($this->request->getPost('employer_id')) {
            $data['employer_id'] = $this->request->getPost('employer_id');
        } elseif (!empty($project_info['employer_id'])) {
            $data['employer_id'] = $project_info['employer_id'];
        } else {
            $data['employer_id'] = 0;
        }

        $languageModel = new LanguageModel();
        $data['languages'] = $languageModel->where('status', 1)->findAll();
        
        $this->document->output('catalog/project_form', $data);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('project_description') as $language_id => $value) {
            if (! $this->validate([
                    "project_description.{$language_id}.name" => [
                    'label' => 'Project Name',
                    'rules' => 'required|min_length[3]|max_length[64]'
                ],
                "project_description.{$language_id}.description" => [
                    'label' => 'Project Description',
                    'rules' => 'required|min_length[3]'
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', 'catalog/project')) {
            $this->session->setFlashdata('error_warning', lang('catalog/project.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'catalog/project')) {
            $this->session->setFlashdata('error_warning', lang('catalog/project.error_permission'));
            return false;
        } 
        return true;
    }
        
    //--------------------------------------------------------------------
}
