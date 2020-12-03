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
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('tool/mail.list.heading_title'),
            'href' => base_url('index.php/tool/mail?user_token=' . $this->request->getVar('user_token')),
        );

        $data['action'] = base_url('index.php/tool/mail/send?user_token=' . $this->request->getVar('user_token'));
        $data['cancel'] = base_url('index.php/tool/mail?user_token=' . $this->request->getVar('user_token'));

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
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

    public function send()
    {
        $email = \Config\Services::email();

        $email->setFrom($this->registry->get('config_email'));
        $email->setTo($this->request->getPost('to', FILTER_SANITIZE_EMAIL));

            $message  = '<html dir="ltr" lang="en">' . "\n";
            $message .= '  <head>' . "\n";
            $message .= '    <title>' . $this->request->getPost('subject') . '</title>' . "\n";
            $message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
            $message .= '  </head>' . "\n";
            $message .= '  <body>' . html_entity_decode($this->request->getPost('message'), ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
            $message .= '</html>' . "\n";

        $email->setSubject($this->request->getPost('subject'));

        $email->setMessage($message);

        if (! $email->send(false)) {
            $email->printDebugger();
        } else {
            return redirect()->to(base_url('index.php/tool/mail?user_token=' . $this->request->getVar('user_token')))
                             ->with('success', lang('tool/mail.text_success'));
        }                
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'tool/mail')) {
            $this->session->setFlashdata('error_warning', lang('tool/mail.error_permission'));
            return false;
        }
        return true;
    }


    //--------------------------------------------------------------------
}
