<?php namespace Admin\Controllers\Localisation;

use \Admin\Models\Finance\WithdrawalModel;

class Withdraw_status extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $withdrawalModel = new WithdrawalModel();

        $this->document->setTitle(lang('localisation/withdraw_status.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('localisation/withdraw_status.list.text_add'));

        $withdrawalModel = new WithdrawalModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $withdrawalModel->addWithdrawStatus($this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/withdraw_status?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/withdraw_status.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('localisation/withdraw_status.list.text_edit'));

        $withdrawalModel = new WithdrawalModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $withdrawalModel->editWithdrawStatus($this->request->getVar('withdraw_status_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/withdraw_status?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/withdraw_status.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $withdrawalModel = new WithdrawalModel();

        $this->document->setTitle(lang('localisation/withdraw_status.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $withdraw_status_id) {
                $withdrawalModel->deleteWithdrawStatus($withdraw_status_id);
                $json['success'] = lang('localisation/withdraw_status.text_success');
                $json['redirect'] = 'index.php/localisation/withdraw_status?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('localisation/withdraw_status.error_permission');
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
            'text' => lang('localisation/withdraw_status.list.heading_title'),
            'href' => base_url('index.php/localisation/withdraw_status?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $withdrawalModel = new WithdrawalModel();

        $data['withdraw_statuses'] = [];

        $results = $withdrawalModel->getWithdrawStatuses();

        foreach ($results as $result) {
            $data['withdraw_statuses'][] = [
                'withdraw_status_id' => $result['withdraw_status_id'],
                'name'              => $result['name'],
                'edit'              => base_url('index.php/localisation/withdraw_status/edit?user_token=' . $this->request->getVar('user_token') . '&withdraw_status_id=' . $result['withdraw_status_id']),
                'delete'            => base_url('index.php/localisation/withdraw_status/delete?user_token=' . $this->request->getVar('user_token') . '&withdraw_status_id=' . $result['withdraw_status_id']),
            ];
        }

        $data['add'] = base_url('index.php/localisation/withdraw_status/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/localisation/withdraw_status/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('localisation/withdraw_status_list', $data);
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
            'text' => lang('localisation/withdraw_status.list.heading_title'),
            'href' => base_url('index.php/localisation/withdraw_status/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('withdraw_status_id') ? lang('localisation/withdraw_status.list.text_add') : lang('localisation/withdraw_status.list.text_edit');

        $data['cancel'] = base_url('index.php/localisation/withdraw_status?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('withdraw_status_id')) {
            $data['action'] = base_url('index.php/localisation/withdraw_status/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/localisation/withdraw_status/edit?user_token=' . $this->request->getVar('user_token') . '&withdraw_status_id=' . $this->request->getVar('withdraw_status_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $withdrawalModel = new WithdrawalModel();

        if (($this->request->getMethod() != 'post') && $this->request->getVar('withdraw_status_id')) {
            $withdraw_info = $withdrawModel->getDisputeAction($this->request->getVar('withdraw_status_id'));
        }
        
        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($this->request->getVar('withdraw_status_id')) {
            $data['name'] = $withdraw_info['name'];
        } else {
            $data['name'] = '';
        }

        $this->document->output('localisation/withdraw_status_form', $data);
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
            $this->session->setFlashdata('error_warning', lang('localisation/withdraw_status.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'localisation/withdraw_status')) {
            $this->session->setFlashdata('error_warning', lang('localisation/withdraw_status.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
