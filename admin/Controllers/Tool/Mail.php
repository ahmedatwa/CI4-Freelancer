<?php namespace Admin\Controllers\Tool;

class Mail extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('tool/mail.list.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('tool/mail.list.heading_title'),
            'href' => base_url('index.php/tool/mail?user_token=' . $this->session->get('user_token')),
        );

        $data['action'] = base_url('index.php/tool/mail/clear?user_token=' . $this->session->get('user_token'));
        $data['cancel'] = base_url('index.php/tool/mail?user_token=' . $this->session->get('user_token'));

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getPost('from')) {
            $data['from'] = $this->request->getPost('from');
        } else {
            $data['from'] = '';
        }
        if ($this->request->getPost('to')) {
            $data['to'] = $this->request->getPost('to');
        } else {
            $data['to'] = '';
        }
        if ($this->request->getPost('customer_group')) {
            $data['customer_group'] = $this->request->getPost('customer_group');
        } else {
            $data['customer_group'] = '';
        }
        if ($this->request->getPost('customer')) {
            $data['customer'] = $this->request->getPost('customer');
        } else {
            $data['customer'] = '';
        }
        if ($this->request->getPost('subject')) {
            $data['subject'] = $this->request->getPost('subject');
        } else {
            $data['subject'] = '';
        }
        if ($this->request->getPost('message')) {
            $data['message'] = $this->request->getPost('message');
        } else {
            $data['message'] = '';
        }


        return $this->document->output('tool/mail', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('tool/mail.error_permission'));
            return false;
        }
        return true;
    }


    //--------------------------------------------------------------------
}
