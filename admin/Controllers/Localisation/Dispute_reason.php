<?php namespace Admin\Controllers\Localisation;

use \Admin\Models\Localisation\Disputes;

class Dispute_reason extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $disputeModel = new Disputes();

        $this->document->setTitle(lang('localisation/dispute_reason.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('localisation/dispute_reason.list.text_add'));

        $disputeModel = new Disputes();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $disputeModel->addDisputeReason($this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/dispute_reason?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/dispute_reason.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('localisation/dispute_reason.list.text_edit'));

        $disputeModel = new Disputes();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $disputeModel->editDisputeReason($this->request->getVar('dispute_reason_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/dispute_reason?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/dispute_reason.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $disputeModel = new Disputes();
   
        $this->document->setTitle(lang('localisation/dispute_reason.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $dispute_reason_id) {
                $disputeModel->deleteDisputeReason($dispute_reason_id);
                $json['success'] = lang('localisation/dispute_reason.text_success');
                $json['redirect'] = 'index.php/localisation/dispute_reason?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('localisation/dispute_reason.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        $disputeModel = new Disputes();
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/dispute_reason.list.heading_title'),
            'href' => base_url('index.php/localisation/dispute_reason?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['dispute_reasons'] = [];

        $results = $disputeModel->getDisputeReasons();

        foreach ($results as $result) {
            $data['dispute_reasons'][] = array(
                'dispute_reason_id' => $result['dispute_reason_id'],
                'name'              => $result['name'],
                'edit'              => base_url('index.php/localisation/dispute_reason/edit?user_token=' . $this->request->getVar('user_token') . '&dispute_reason_id=' . $result['dispute_reason_id']),
                'delete'            => base_url('index.php/localisation/dispute_reason/delete?user_token=' . $this->request->getVar('user_token') . '&dispute_reason_id=' . $result['dispute_reason_id']),
            );
        }

        $data['add'] = base_url('index.php/localisation/dispute_reason/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/localisation/dispute_reason/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('localisation/dispute_reason_list', $data);
    }

    protected function getForm()
    {
        $disputeModel = new Disputes();
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/dispute_reason.list.heading_title'),
            'href' => base_url('index.php/localisation/dispute_reason/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('dispute_reason_id') ? lang('localisation/dispute_reason.list.text_add') : lang('localisation/dispute_reason.list.text_edit');

        $data['cancel'] = base_url('index.php/localisation/dispute_reason?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('dispute_reason_id')) {
            $data['action'] = base_url('index.php/localisation/dispute_reason/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/localisation/dispute_reason/edit?user_token=' . $this->request->getVar('user_token') . '&dispute_reason_id=' . $this->request->getVar('dispute_reason_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if (($this->request->getMethod() != 'post') && $this->request->getVar('dispute_reason_id')) {
            $dispute_info = $disputeModel->getDisputeAction($this->request->getVar('dispute_reason_id'));
        }
        
        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif ($this->request->getVar('dispute_reason_id')) {
            $data['name'] = $dispute_info['name'];
        } else {
            $data['name'] = '';
        }

        $this->document->output('localisation/dispute_reason_form', $data);
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
            $this->session->setFlashdata('error_warning', lang('localisation/dispute_reason.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'localisation/dispute_reason')) {
            $this->session->setFlashdata('error_warning', lang('localisation/dispute_reason.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
