<?php namespace Catalog\Controllers\Information;

use Catalog\Controllers\BaseController;

class Contact extends BaseController
{
    public function index()
    {
        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            
            $email = \Config\Services::email();

            $email->setFrom(getSettingValue('config_email'), getSettingValue('config_name'));
            $email->setTo(html_entity_decode($this->request->getPost('name'), ENT_QUOTES, 'UTF-8'));

            $email->setSubject(html_entity_decode(sprintf(lang('information/contact.email_subject'), $this->request->getPost('name')), ENT_QUOTES, 'UTF-8'));
            $email->setMessage($this->request->getPost('enquiry'));
            
            if ($email->send()) {
				$this->session->setFlashdata('success', lang('information/contact.text_success'));
            } else {
				$this->session->setFlashdata('error_warning', lang('en.error.error_form'));
			}
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => lang('text_home'),
            'href' => base_url('common/home')
        );


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

        if ($this->request->getPost('inquiry')) {
            $data['inquiry'] = $this->request->getPost('inquiry');
        } else {
            $data['inquiry'] = '';
        }


		$data['site']       = getSettingValue('config_name');
		$data['address']    = nl2br(getSettingValue('config_address'));
        $data['open']       = getSettingValue('config_open');
        $data['telephone']  = getSettingValue('config_telephone');


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
