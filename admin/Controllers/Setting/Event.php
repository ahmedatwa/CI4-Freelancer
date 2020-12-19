<?php namespace Admin\Controllers\Setting;

use \Admin\Models\Setting\EventModel;

class Event extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $eventModel = new EventModel();

        $this->document->setTitle(lang('setting/event.list.heading_title'));

        $this->getList();
    }

    public function delete()
    {
        $json = array();

        $eventModel = new EventModel();
   
        $this->document->setTitle(lang('setting/event.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateForm()) {
            foreach ($this->request->getPost('selected') as $event_id) {
                $eventModel->delete($event_id);
                $json['success'] = lang('setting/event.text_success');
                $json['redirect'] = 'index.php/setting/event?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('setting/event.error_permission');
        }
        return $this->response->setJSON($json);
    }

    public function disable()
    {
        $this->document->setTitle(lang('setting/event.list.text_edit'));

        $eventModel = new EventModel();

        if ($this->request->getVar('event_id') && $this->validateForm()) {
            $eventModel->disableEvent($this->request->getVar('event_id'));
            return redirect()->to(base_url('index.php/setting/event?user_token='. $this->request->getVar('user_token')))
                             ->with('success', lang('setting/event.text_success'));
        }
        $this->getList();
    }

    public function enable()
    {
        $this->document->setTitle(lang('setting/event.list.text_edit'));

        $eventModel = new EventModel();

        if ($this->request->getVar('event_id') && $this->validateForm()) {
            $eventModel->enableEvent($this->request->getVar('event_id'));
            return redirect()->to(base_url('index.php/setting/event?user_token='. $this->request->getVar('user_token')))
                             ->with('success', lang('setting/event.text_success'));
        }
        $this->getList();
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
            'text' => lang('setting/event.list.heading_title'),
            'href' => base_url('index.php/setting/event?user_token=' . $this->request->getVar('user_token')),
        ];

        if ($this->request->getVar('type')) {
            $data['type'] = $this->request->getVar('type');
        } else {
            $data['type'] = '';
        }

        // Data
        $data['events'] = [];
        $eventModel = new EventModel();
        
        $results = $eventModel->findAll($this->registry->get('config_admin_limit'));
        foreach ($results as $result) {
            $data['events'][] = [
                'event_id'   => $result['event_id'],
                'code'       => $result['code'],
                'action'     => $result['action'],
                'priority'   => $result['priority'],
                'description' => $result['description'],
                'enabled'    => $result['status'],
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'disable'    => base_url('index.php/setting/event/disable?user_token=' . $this->request->getVar('user_token') . '&event_id=' . $result['event_id']),
                'enable'     => base_url('index.php/setting/event/enable?user_token=' . $this->request->getVar('user_token') . '&event_id=' . $result['event_id']),
              ];
        }

        $data['delete'] = base_url('index.php/setting/event/delete?user_token=' . $this->request->getVar('user_token'));

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

        $this->document->output('setting/event', $data);
    }

    
    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'setting/event')) {
            $this->session->setFlashdata('error_warning', lang('setting/event.error_permission'));
            return false;
        }
        return true;
    }

    
    //--------------------------------------------------------------------
}
