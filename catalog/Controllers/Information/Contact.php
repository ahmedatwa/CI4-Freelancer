<?php namespace Catalog\Controllers\Information;

use \Catalog\Controllers\BaseController;

class Contact extends BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('information/contact.heading_title'));
        
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('text_home'),
            'href' => base_url('common/home')
        ];

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

    public function send()
    {
        $json = [];
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            if (! $this->validate([
                'name'    => 'required|min_length[3]|max_length[32]',
                'email'   => 'required|valid_email',
                'subject' => 'required',
                'inquiry' => 'required|min_length[10]|max_length[300]',
            ])) {
                //$json['error_warning'] = lang($this->locale . '.error_form');
                $json['errors'] = $this->validator->getErrors();
            }

            if (! $json) {
                $email = \Config\Services::email();

                $email->setFrom($this->registry->get('config_email'), $this->registry->get('config_name'));
                $email->setTo(html_entity_decode($this->request->getPost('name'), ENT_QUOTES, 'UTF-8'));

                $email->setSubject(html_entity_decode(sprintf(lang('information/contact.email_subject'), $this->request->getPost('name')), ENT_QUOTES, 'UTF-8'));
                $email->setMessage($this->request->getPost('enquiry'));
            
                if ($email->send()) {
                    $json['success'] = lang('information/contact.text_success');
                }
            }
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
