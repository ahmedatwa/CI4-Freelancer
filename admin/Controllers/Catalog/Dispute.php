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

        $customerModel = new \Admin\Models\Customer\Customers();

        $disputeModel = new Disputes();

        $results = $disputeModel->getDisputes();

        foreach ($results as $result) {
            $data['disputes'][] = [
                'dispute_id'    => $result['dispute_id'],
                'freelancer_id' => $result['freelancer_id'],
                'freelancer'    => $customerModel->where('customer_id', $result['freelancer_id'])->findColumn('username')[0],
                'project_id'    => $result['project_id'],
                'employer'      => $customerModel->where('customer_id', $result['employer_id'])->findColumn('username')[0],
                'status'        => $result['status'],
                'date_added'    => $result['date_added'],
                'edit'          => base_url('index.php/catalog/dispute/edit?user_token=' . $this->session->get('user_token') . '&dispute_id=' . $result['dispute_id']),
                'delete'        => base_url('index.php/catalog/dispute/delete?user_token=' . $this->session->get('user_token') . '&dispute_id=' . $result['dispute_id']),
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

        $disputeModel = new Disputes();

        if ($this->request->getGet('dispute_id') && ($this->request->getMethod() != 'post')) {
            $dispute_info = $disputeModel->find($this->request->getGet('dispute_id'));
        }
        
        $data['dispute_actions'] = $disputeModel->getDisputeActions();

        if ($this->request->getPost('dispute_action_id')) {
            $data['dispute_action_id'] = $this->request->getPost('dispute_action_id');
        } elseif (!empty($dispute_info)) {
            $data['dispute_action_id'] = $dispute_info['dispute_action_id'];
        } else {
            $data['dispute_action_id'] = 0;
        }

        if ($dispute_info) {
            $customerModel = new \Admin\Models\Customer\Customers();

            $projectModel = new \Admin\Models\Catalog\Projects();

            $data['freelancer'] = $customerModel->where('customer_id', $dispute_info['freelancer_id'])->findColumn('username')[0];
            $data['employer']   = $customerModel->where('customer_id', $dispute_info['employer_id'])->findColumn('username')[0];
            $data['comment']    = $dispute_info['comment'];
            $data['project']    = $projectModel->getProject($dispute_info['project_id'])['name'];
        }


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
