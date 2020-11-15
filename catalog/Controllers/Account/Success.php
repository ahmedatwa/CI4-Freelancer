<?php namespace Catalog\Controllers\Account;

class Success extends \Catalog\Controllers\BaseController
{
    public function index() {

        $this->template->setTitle(lang('account/success.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] =  [
            'text' => lang('account/success.heading_title'),
            'href' => base_url('account/success')
        ];

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->customer->isLogged()) {
            $data['text_message'] = sprintf(lang('account/success.text_message'), route_to('contact'));
        } 

        $data['heading_title'] = lang('account/success.heading_title');

        $this->template->output('common/success', $data);
    }

    //---------------------------------------------------------------
}
