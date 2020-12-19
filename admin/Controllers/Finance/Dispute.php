<?php namespace Admin\Controllers\Finance;

use \Admin\Models\Finance\DisputeModel;
use \Admin\Models\Customer\CustomerModel;
use \Admin\Models\Catalog\ProjectModel;

class Dispute extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $disputeModel = new DisputeModel();

        $this->document->setTitle(lang('finance/dispute.list.heading_title'));

        $this->getList();
    }

    public function edit()
    {
        $this->document->setTitle(lang('finance/dispute.list.text_edit'));

        $disputeModel = new DisputeModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $disputeModel->update($this->request->getGet('dispute_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/finance/dispute?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('finance/dispute.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $disputeModel = new DisputeModel();
   
        $this->document->setTitle(lang('finance/dispute.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $dispute_id) {
                $disputeModel->delete($dispute_id);
                $json['success'] = lang('finance/dispute.text_success');
                $json['redirect'] = 'index.php/finance/dispute?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('finance/dispute.error_permission');
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
            'text' => lang('finance/dispute.list.heading_title'),
            'href' => base_url('index.php/finance/dispute?user_token=' . $this->session->get('user_token')),
        ];

        // Data
        $filter_data = [
            'start'    => 0,
            'limit'    => $this->registry->get('config_admin_limit'),
        ];

        $data['disputes'] = [];

        $customerModel = new CustomerModel();

        $disputeModel = new DisputeModel();

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
                'edit'          => base_url('index.php/finance/dispute/edit?user_token=' . $this->session->get('user_token') . '&dispute_id=' . $result['dispute_id']),
                'delete'        => base_url('index.php/finance/dispute/delete?user_token=' . $this->session->get('user_token') . '&dispute_id=' . $result['dispute_id']),
            ];
        }

        $data['add'] = base_url('index.php/finance/dispute/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/finance/dispute/delete?user_token=' . $this->session->get('user_token'));

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

        $this->document->output('finance/dispute_list', $data);
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
            'text' => lang('finance/dispute.list.heading_title'),
            'href' => base_url('index.php/finance/dispute/edit?user_token=' . $this->session->get('user_token')),
        ];

        $data['text_form'] = !$this->request->getGet('dispute_id') ? lang('finance/dispute.list.text_add') : lang('finance/dispute.list.text_edit');

        $data['cancel'] = base_url('index.php/finance/dispute?user_token=' . $this->session->get('user_token'));

        $data['user_token'] = $this->request->getVar('user_token');

        if (!$this->request->getGet('dispute_id')) {
            $data['action'] = base_url('index.php/finance/dispute/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/finance/dispute/edit?user_token=' . $this->session->get('user_token') . '&dispute_id=' . $this->request->getGet('dispute_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $disputeModel = new DisputeModel();

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

        $data['dispute_statuses'] = $disputeModel->getDisputeStatuses();

        if ($this->request->getPost('dispute_status_id')) {
            $data['dispute_status_id'] = $this->request->getPost('dispute_status_id');
        } elseif (!empty($dispute_info)) {
            $data['dispute_status_id'] = $dispute_info['dispute_status_id'];
        } else {
            $data['dispute_status_id'] = 0;
        }

        if ($this->request->getVar('dispute_id')) {
            $data['dispute_id'] = $this->request->getVar('dispute_id');
        } else {
            $data['dispute_id'] = 0;
        }

        if ($dispute_info) {
            $customerModel = new CustomerModel();

            $projectModel = new ProjectModel();

            $data['freelancer'] = $customerModel->where('customer_id', $dispute_info['freelancer_id'])->findColumn('username')[0];
            $data['employer']   = $customerModel->where('customer_id', $dispute_info['employer_id'])->findColumn('username')[0];
            $data['comment']    = $dispute_info['comment'];
            $data['project']    = $projectModel->getProject($dispute_info['project_id'])['name'];
        }


        $this->document->output('finance/dispute_form', $data);
    }

    public function history()
    {
        $data['histories'] = [];

        $disputeModel = new DisputeModel();

        $results = $disputeModel->getDisputeHistories($this->request->getVar('dispute_id'));

        foreach ($results as $result) {
            $data['histories'][] = [
                'notify'     => $result['notify'] ? lang('en.list.text_yes') : lang('en.list.text_no'),
                'status'     => $result['status'],
                'comment'    => nl2br($result['comment']),
                'date_added' => lang('en.medium_date', [strtotime($result['date_added'])])
            ];
        }

        $data['column_date_added'] = lang('finance/dispute.list.column_date_added');
        $data['column_comment']    = lang('finance/dispute.list.column_comment');
        $data['column_status']     = lang('finance/dispute.list.column_status');
        $data['column_notify']     = lang('finance/dispute.list.column_notify');

        return view('finance/dispute_history', $data);
    }
    
    public function addHistory()
    {
        $json = [];

        if (! $this->user->hasPermission('modify', 'finance/dispute')) {
            $json['error'] = lang('finance/dispute.error_permission');
        }

        if (! $json) {
            $disputeModel = new DisputeModel();

            $disputeModel->addDisputeHistory($this->request->getVar('dispute_id'), $this->request->getPost('dispute_status_id'), $this->request->getPost('comment'), $this->request->getPost('notify'));

            $json['success'] = lang('finance/dispute.text_success');
        }

        return $this->response->setJSON($json);
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

        if (! $this->user->hasPermission('modify', 'finance/dispute')) {
            $this->session->setFlashdata('error_warning', lang('finance/dispute.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'finance/dispute')) {
            $this->session->setFlashdata('error_warning', lang('finance/dispute.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
