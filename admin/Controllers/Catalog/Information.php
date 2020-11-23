<?php namespace Admin\Controllers\Catalog;

use \Admin\Models\Catalog\Informations;
use \Admin\Models\Localisation\Languages;

class Information extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $informationModel = new Informations();

        $this->document->setTitle(lang('catalog/information.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('catalog/information.list.text_add'));

        $informationModel = new Informations();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $informationModel->addInformation($this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/information?user_token=' . $this->session->get('user_token')))
                             ->with('success', lang('catalog/information.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('catalog/information.list.text_edit'));

        $informationModel = new Informations();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $informationModel->editInformation($this->request->getGet('information_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/information?user_token=' . $this->session->get('user_token')))
                             ->with('success', lang('catalog/information.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $informationModel = new Informations();
   
        $this->document->setTitle(lang('catalog/information.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $information_id) {
                $informationModel->deleteInformation($information_id);
                $json['success'] = lang('catalog/information.text_success');
                $json['redirect'] = 'index.php/catalog/information?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('catalog/information.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/information.list.heading_title'),
            'href' => base_url('index.php/catalog/information?user_token=' . $this->session->get('user_token')),
        ];

        $informationModel = new Informations();

        $data['informations'] = [];
        // Data
        $filter_data = [
            'start' => 0,
            'limit' => $this->registry->get('config_admin_limit'),
        ];

        
        $results = $informationModel->getInformations($filter_data);

        foreach ($results as $result) {
            $data['informations'][] = [
                'information_id' => $result['information_id'],
                'title'          => $result['title'],
                'status'         => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'           => base_url('index.php/catalog/information/edit?user_token=' . $this->session->get('user_token') . '&information_id=' . $result['information_id']),
                'delete'         => base_url('index.php/catalog/information/delete?user_token=' . $this->session->get('user_token') . '&information_id=' . $result['information_id']),
            ];
        }

        $data['add'] = base_url('index.php/catalog/information/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/catalog/information/delete?user_token=' . $this->session->get('user_token'));

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

        $data['user_token'] = $this->request->getGet('user_token');

        $this->document->output('catalog/information_list', $data);
    }

    protected function getForm()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('catalog/information.list.heading_title'),
            'href' => base_url('index.php/catalog/information/edit?user_token=' . $this->session->get('user_token')),
        ];

        $data['text_form'] = !$this->request->getGet('information_id') ? lang('catalog/information.list.text_add') : lang('catalog/information.list.text_edit');

        $data['cancel'] = base_url('index.php/catalog/information?user_token=' . $this->session->get('user_token'));

        if (!$this->request->getGet('information_id')) {
            $data['action'] = base_url('index.php/catalog/information/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/catalog/information/edit?user_token=' . $this->session->get('user_token') . '&information_id=' . $this->request->getGet('information_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $informationModel = new Informations();

        if ($this->request->getGet('information_id') && ($this->request->getMethod() != 'post')) {
            $information_info = $informationModel->getInformation($this->request->getGet('information_id'));
        }

        $languages = new Languages();
        $data['languages'] = $languages->where('status', 1)->findAll();

        if ($this->request->getPost('information_description')) {
            $data['information_description'] = $this->request->getPost('information_description');
        } elseif ($this->request->getGet('information_id')) {
            $data['information_description'] = $informationModel->getInformationDescription($this->request->getVar('information_id'));
        } else {
            $data['information_description'] = [];
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($information_info)) {
            $data['sort_order'] = $information_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if ($this->request->getPost('bottom')) {
            $data['bottom'] = $this->request->getPost('bottom');
        } elseif (!empty($information_info)) {
            $data['bottom'] = $information_info['bottom'];
        } else {
            $data['bottom'] = 0;
        }


        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($information_info)) {
            $data['status'] = $information_info['status'];
        } else {
            $data['status'] = 1;
        }

        $this->document->output('catalog/information_form', $data);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('information_description') as $language_id => $value) {
            if (! $this->validate([
                    "information_description.{$language_id}.title" => [
                    'label' => 'Information Title',
                    'rules' => 'required|min_length[3]|max_length[64]'
                ],
                "information_description.{$language_id}.description" => [
                    'label' => 'Meta Description',
                    'rules' => 'required|min_length[3]'
                ],
                "information_description.{$language_id}.meta_title" => [
                    'label' => 'Meta Title',
                    'rules' => 'required|min_length[3]|max_length[255]'
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', 'catalog/information')) {
            $this->session->setFlashdata('error_warning', lang('catalog/information.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'catalog/information')) {
            $this->session->setFlashdata('error_warning', lang('catalog/information.error_permission'));
            return false;
        } 
        return true;
    }
        
    //--------------------------------------------------------------------
}
