<?php

namespace Admin\Controllers\Catalog;

use Admin\Controllers\BaseController;
use Admin\Models\Catalog\SkillModel;

class Skill extends BaseController
{
    protected $errors = [];

    public function index()
    {
        $skillModel = new SkillModel();

        $this->document->setTitle(lang('catalog/skill.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('catalog/skill.list.text_add'));

        $skillModel = new SkillModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $skillModel->insert($this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/skill?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('catalog/skill.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('catalog/skill.list.text_edit'));

        $skillModel = new SkillModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $skillModel->update($this->request->getVar('skill_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/skill?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('catalog/skill.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $skillModel = new SkillModel();
   
        $this->document->setTitle(lang('catalog/skill.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $skill_id) {
               $skillModel->delete($skill_id);  
            }       
            $json['success'] = lang('catalog/skill.text_success');
            $json['redirect'] = 'index.php/catalog/skill?user_token=' . $this->request->getVar('user_token');
        } else {
            $json['error_warning'] = lang('catalog/skill.error_permission');
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
            'text' => lang('catalog/skill.list.heading_title'),
            'href' => base_url('index.php/catalog/skill?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['skills'] = [];

        $skillModel = new SkillModel();

        $results = $skillModel->where('status', 1)->findAll();

        foreach ($results as $result) {
            $data['skills'][] = [
                'skill_id'  => $result['skill_id'],
                'name'      => $result['name'],
                'status'    => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'      => base_url('index.php/catalog/skill/edit?user_token=' . $this->request->getVar('user_token') . '&skill_id=' . $result['skill_id']),
                'delete'    => base_url('index.php/catalog/skill/delete?user_token=' . $this->request->getVar('user_token') . '&skill_id=' . $result['skill_id']),
            ];
        }

        $data['add'] = base_url('index.php/catalog/skill/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/catalog/skill/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('catalog/skill_list', $data);
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
            'text' => lang('catalog/skill.list.heading_title'),
            'href' => base_url('index.php/catalog/skill/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getGet('skill_id') ? lang('catalog/skill.list.text_add') : lang('catalog/skill.list.text_edit');

        $data['cancel'] = base_url('index.php/catalog/skill?user_token=' . $this->request->getVar('user_token'));

        $data['user_token'] = $this->request->getVar('user_token');

        if (!$this->request->getVar('skill_id')) {
            $data['action'] = base_url('index.php/catalog/skill/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/catalog/skill/edit?user_token=' . $this->request->getVar('user_token') . '&skill_id=' . $this->request->getVar('skill_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->errors['validator']['name'])) {
            $data['error_name'] = $this->errors['validator']['name'];
        } else {
            $data['error_name'] = '';
        }
        
        $skillModel = new SkillModel();

        if ($this->request->getVar('skill_id') && ($this->request->getMethod() != 'post')) {
            $skill_info = $skillModel->find($this->request->getVar('skill_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($skill_info)) {
            $data['name'] = $skill_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($skill_info)) {
            $data['status'] = $skill_info['status'];
        } else {
            $data['status'] = 1;
        }

        $this->document->output('catalog/skill_form', $data);
    }

    public function autocomplete()
    {
        $json = [];

        if ($this->request->getVar('skill')) {
            $skillModel = new SkillModel();

            if ($this->request->getVar('skill')) {
                $filter_name = html_entity_decode($this->request->getVar('skill'), ENT_QUOTES, 'UTF-8');
            } else {
                $filter_name = null;
            }

            $filter_data = [
                'filter_name' => $filter_name,
                'start'       => 0,
                'limit'       => 5,
            ];

            $results = $skillModel->findAll($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'skill_id' => $result['skill_id'],
                    'name'     => $result['name']
                ];
            }
        }

        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        if (! $this->validate([
            'name' => "required|is_unique[skills.name]",
        ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            $this->errors['validator'] = $this->validator->getErrors();
            return false;
        }

        if (! $this->user->hasPermission('modify', 'catalog/skill')) {
            $this->session->setFlashdata('error_warning', lang('catalog/skill.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'catalog/skill')) {
            $this->session->setFlashdata('error_warning', lang('catalog/skill.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
