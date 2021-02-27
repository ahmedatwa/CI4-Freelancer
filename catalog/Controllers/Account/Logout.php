<?php

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\CustomerModel;

class Logout extends BaseController
{
    public function index()
    {
        if ($this->customer->isLogged()) {
            $customerModel = new CustomerModel();
            // set offline status
            $customerModel->where('customer_id', $this->session->get('customer_id'))
                          ->set('online', 0)
                          ->update();

            $this->customer->logout();
            return redirect('account_logout');
        }

        $this->template->setTitle(lang('account/logout.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('/')
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/logout.list.text_account'),
            'href' => base_url('account/account')
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/logout.list.text_logout'),
            'href' => base_url('account/logout')
        ];

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $data['langData'] = lang('account/logout.list');

        $this->template->output('common/success', $data);
    }

    //--------------------------------------------------------------------
}
