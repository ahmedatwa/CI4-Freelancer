<?php namespace Catalog\Controllers\Information;

use \Catalog\Controllers\BaseController;

class Contact extends BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('information/contact.heading_title'));
        
        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            
            $email = \Config\Services::email();

            $email->setFrom($this->registry->get('config_email'), $this->registry->get('config_name'));
            $email->setTo(html_entity_decode($this->request->getPost('name'), ENT_QUOTES, 'UTF-8'));

            $email->setSubject(html_entity_decode(sprintf(lang('information/contact.email_subject'), $this->request->getPost('name')), ENT_QUOTES, 'UTF-8'));
            $email->setMessage($this->request->getPost('enquiry'));
            
            if ($email->send()) {
				$this->session->setFlashdata('success', lang('information/contact.text_success'));
            } else {
				$this->session->setFlashdata('error_warning', lang('en.error.error_form'));
			}
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('text_home'),
            'href' => base_url('common/home')
        ];


        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('subject')) {
            $data['subject'] = $this->request->getPost('subject');
        } else {
            $data['subject'] = '';
        }

        if ($this->request->getPost('inquiry')) {
            $data['inquiry'] = $this->request->getPost('inquiry');
        } else {
            $data['inquiry'] = '';
        }

        $data['action'] = route_to('contact');

		$data['site']       = $this->registry->get('config_name');
		$data['address']    = nl2br($this->registry->get('config_address'));
        $data['open']       = $this->registry->get('config_open');
        $data['telephone']  = $this->registry->get('config_telephone');

        $data['heading_title']    = lang('information/contact.heading_title');
        $data['text_help_center'] = lang('information/contact.text_help_center');
        $data['text_help']        = lang('information/contact.text_help');
        $data['text_address']     = lang('information/contact.text_address');


        $this->template->output('information/contact', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name'    => 'required|min_length[3]|max_length[32]',
                'email'   => 'required|valid_email]',
                'inquiry' => 'required||min_length[10]|max_length[300]',
            ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
        }

        return true;
    }


    //--------------------------------------------------------------------
}
