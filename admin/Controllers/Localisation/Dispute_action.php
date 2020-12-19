<?php namespace Admin\Controllers\Localisation;

use \Admin\Models\Finance\DisputeModel;

class Dispute_action extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $disputeModel = new DisputeModel();

        $this->document->setTitle(lang('localisation/dispute_action.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('localisation/dispute_action.list.text_add'));

        $disputeModel = new DisputeModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $disputeModel->addDisputeAction($this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/dispute_action?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/dispute_action.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('localisation/dispute_action.list.text_edit'));

        $disputeModel = new DisputeModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $disputeModel->editDisputeAction($this->request->getVar('dispute_action_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/dispute_action?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/dispute_action.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $disputeModel = new DisputeModel();
   
        $this->document->setTitle(lang('localisation/dispute_action.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $dispute_action_id) {
                $disputeModel->deleteDisputeAction($dispute_action_id);
                $json['success'] = lang('localisation/dispute_action.text_success');
                $json['redirect'] = 'index.php/localisation/dispute_action?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('localisation/dispute_action.error_permission');
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
            'text' => lang('localisation/dispute_action.list.heading_title'),
            'href' => base_url('index.php/localisation/dispute_action?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['dispute_actions'] = [];
        $disputeModel = new DisputeModel();

        $results = $disputeModel->getDisputeActions();

        foreach ($results as $result) {
            $data['dispute_actions'][] = [
                'dispute_action_id' => $result['dispute_action_id'],
                'name'              => $result['name'],
                'edit'              => base_url('index.php/localisation/dispute_action/edit?user_token=' . $this->request->getVar('user_token') . '&dispute_action_id=' . $result['dispute_action_id']),
                'delete'            => base_url('index.php/localisation/dispute_action/delete?user_token=' . $this->request->getVar('user_token') . '&dispute_action_id=' . $result['dispute_action_id']),
            ];
        }

        $data['add'] = base_url('index.php/localisation/dispute_action/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/localisation/dispute_action/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('localisation/dispute_action_list', $data);
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
            'text' => lang('localisation/dispute_action.list.heading_title'),
            'href' => base_url('index.php/localisation/dispute_action/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('dispute_action_id') ? lang('localisation/dispute_action.list.text_add') : lang('localisation/dispute_action.list.text_edit');

        $data['cancel'] = base_url('index.php/localisation/dispute_action?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('dispute_action_id')) {
            $data['action'] = base_url('index.php/localisation/dispute_action/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/localisation/dispute_action/edit?user_token=' . $this->request->getVar('user_token') . '&dispute_action_id=' . $this->request->getVar('dispute_action_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if (($this->request->getMethod() != 'post') && $this->request->getVar('dispute_action_id')) {
            $disputeModel = new DisputeModel();
            $dispute_info = $disputeModel->getDisputeAction($this->request->getVar('dispute_action_id'));
        }
        
        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($this->request->getVar('dispute_action_id')) {
            $data['name'] = $dispute_info['name'];
        } else {
            $data['name'] = '';
        }

        $this->document->output('localisation/dispute_action_form', $data);
    }

    protected function validateForm()
    {
            if (! $this->validate([
                "name" => [
                    'label' => 'Name',
                    'rules' => 'required|min_length[3]|max_length[32]',
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                return false;
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('localisation/dispute_action.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'localisation/dispute_action')) {
            $this->session->setFlashdata('error_warning', lang('localisation/dispute_action.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
