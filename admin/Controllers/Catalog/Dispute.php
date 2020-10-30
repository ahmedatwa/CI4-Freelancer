<?php namespace Admin\Controllers\Catalog;

use \Admin\Models\Localisation\Disputes;

class Dispute extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $disputeModel = new Disputes();

        $this->document->setTitle(lang('catalog/dispute.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('catalog/dispute.list.text_add'));

        $disputeModel = new Disputes();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->disputes->addProject($this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/dispute?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('catalog/dispute.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('catalog/dispute.list.text_edit'));

        $disputeModel = new Disputes(); 

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->disputes->editProject($this->request->getGet('dispute_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/catalog/dispute?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('catalog/dispute.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $this->disputes = new \Admin\Models\Catalog\Projects();
   
        $this->document->setTitle(lang('catalog/dispute.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $dispute_id) {
                $this->disputes->deleteProject($dispute_id);
                $json['success'] = lang('catalog/dispute.text_success');
                $json['redirect'] = 'index.php/catalog/dispute?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('catalog/dispute.error_permission');
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
            'text' => lang('catalog/dispute.list.heading_title'),
            'href' => base_url('index.php/catalog/dispute?user_token=' . $this->session->get('user_token')),
        ];

        // Data
        $filter_data = [
            'start'    => 0,
            'limit'    => $this->registry->get('config_admin_limit'),
        ];

        $data['disputes'] = [];
        $disputeModel = new Disputes();
        $results = $disputeModel->findAll();

        foreach ($results as $result) {
            $data['disputes'][] = [
                'dispute_id' => $result['dispute_id'],
                'freelancer_id' => $result['freelancer_id'],
                'employer_id' => $result['employer_id'],
                'comment'    => $result['comment'],
                'edit'       => base_url('index.php/catalog/dispute/edit?user_token=' . $this->session->get('user_token') . '&dispute_id=' . $result['dispute_id']),
                'delete'     => base_url('index.php/catalog/dispute/delete?user_token=' . $this->session->get('user_token') . '&dispute_id=' . $result['dispute_id']),
            ];
        }

        $data['add'] = base_url('index.php/catalog/dispute/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/catalog/dispute/delete?user_token=' . $this->session->get('user_token'));

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

        $this->document->output('catalog/dispute_list', $data);
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
            'text' => lang('catalog/dispute.list.heading_title'),
            'href' => base_url('index.php/catalog/dispute/edit?user_token=' . $this->session->get('user_token')),
        ];

        $data['text_form'] = !$this->request->getGet('dispute_id') ? lang('catalog/dispute.list.text_add') : lang('catalog/dispute.list.text_edit');

        $data['cancel'] = base_url('index.php/catalog/dispute?user_token=' . $this->session->get('user_token'));

        $data['user_token'] = $this->request->getGet('user_token');

        if (!$this->request->getGet('dispute_id')) {
            $data['action'] = base_url('index.php/catalog/dispute/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/catalog/dispute/edit?user_token=' . $this->session->get('user_token') . '&dispute_id=' . $this->request->getGet('dispute_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getGet('dispute_id') && ($this->request->getMethod() != 'post')) {
            $dispute_info = $this->disputes->getProject($this->request->getGet('dispute_id'));
        }

        if ($this->request->getPost('dispute_description')) {
            $data['dispute_description'] = $this->request->getPost('dispute_description');
        } elseif ($this->request->getGet('dispute_id')) {
            $data['dispute_description'] = $this->disputes->getProjectDescription($this->request->getVar('dispute_id'));
        } else {
            $data['dispute_description'] = [];
        }

        if ($this->request->getPost('sort_order')) {
            $data['sort_order'] = $this->request->getPost('sort_order');
        } elseif (!empty($dispute_info)) {
            $data['sort_order'] = $dispute_info['sort_order'];
        } else {
            $data['sort_order'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($dispute_info)) {
            $data['status'] = $dispute_info['status'];
        } else {
            $data['status'] = 1;
        }

        if ($this->request->getPost('type')) {
            $data['type'] = $this->request->getPost('type');
        } elseif (!empty($dispute_info)) {
            $data['type'] = $dispute_info['type'];
        } else {
            $data['type'] = 1;
        }

        if ($this->request->getPost('image')) {
            $data['image'] = $this->request->getPost('image');
        } elseif (!empty($dispute_info)) {
            $data['image'] = $dispute_info['image'];
        } else {
            $data['image'] = '';
        }

        if ($this->request->getPost('image') && is_file(DIR_IMAGE . $this->request->getPost('image'))) {
            $data['thumb'] = resizeImage($this->request->getPost('image'), 100, 100);
        } elseif (!empty($dispute_info) && is_file(DIR_IMAGE . $dispute_info['image'])) {
            $data['thumb'] = resizeImage($dispute_info['image'], 100, 100);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 100, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        // Employer
        $customers_model = new \Admin\Models\Customer\Customers();
        $data['customers'] = $customers_model->getCustomers();

        if ($this->request->getPost('employer_id')) {
            $data['employer_id'] = $this->request->getPost('employer_id');
        } elseif (!empty($dispute_info['employer_id'])) {
            $data['employer_id'] = $dispute_info['employer_id'];
        } else {
            $data['employer_id'] = 0;
        }

        $languages = new \Admin\Models\Localisation\Languages();
        $data['languages'] = $languages->where('status', 1)->findAll();
        
        $this->document->output('catalog/dispute_form', $data);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('dispute_description') as $language_id => $value) {
            if (! $this->validate([
                    "dispute_description.{$language_id}.name" => [
                    'label' => 'Project Name',
                    'rules' => 'required|min_length[3]|max_length[64]'
                ],
                "dispute_description.{$language_id}.description" => [
                    'label' => 'Project Description',
                    'rules' => 'required|min_length[3]'
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
            }
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('catalog/dispute.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('catalog/dispute.error_permission'));
            return false;
        } 
        return true;
    }
        
    //--------------------------------------------------------------------
}
