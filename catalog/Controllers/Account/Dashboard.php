<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Dashboard extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('account/dashboard.heading_title'));
        
        if($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => route_to('account/dashboard?customer_id=' . $customer_id),
        ];

        $customerModel = new CustomerModel();

        if ($customer_id) {
            $customer_info = $customerModel->getCustomer($customer_id);
        }

        $data['text_dashboard']  = lang('account/dashboard.text_dashboard');
        $data['text_greeting']   = sprintf(lang('account/dashboard.text_greeting'), $customer_info['firstname'] ." " . $customer_info['lastname']);
        // $data['entry_password']  = lang('account/dashboard.entry_password');
        // $data['entry_confirm']   = lang('account/dashboard.entry_confirm');
        $data['heading_title']   = lang('account/dashboard.heading_title');
        // $data['text_login']      = sprintf(lang('account/dashboard.text_login'), route_to('account/login'));
        // $data['text_dashboard']   = lang('account/dashboard.text_dashboard');
        // $data['button_dashboard'] = lang('account/dashboard.button_dashboard');


        $data['action'] = base_url('account/dashboard');

        // if ($this->request->getPost('email')) {
        //     $data['email'] = $this->request->getPost('email');
        // } else {
        //     $data['email'] = '';
        // }

        // if ($this->request->getPost('password')) {
        //     $data['password'] = $this->request->getPost('password');
        // } else {
        //     $data['password'] = '';
        // }

        // if ($this->request->getPost('confirm')) {
        //     $data['confirm'] = $this->request->getPost('confirm');
        // } else {
        //     $data['confirm'] = '';
        // }

        // if ($this->session->getFlashdata('error_warning')) {
        //     $data['error_warning'] = $this->session->getFlashdata('error_warning');
        // } else {
        //     $data['error_warning'] = '';
        // }

        // if ($this->session->getFlashdata('success')) {
        //     $data['success'] = $this->session->getFlashdata('success');
        // } else {
        //     $data['success'] = '';
        // }

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/dashboard', $data);
    }

    // protected function validateForm()
    // {
    //     // Fields Validation Rules
    //     if (! $this->validate([
    //         'email' => [
    //             'rules' => 'required|valid_email|is_unique[customer.email]',
    //             'errors' => [
    //                 'is_unique' => 'Warning: E-Mail Address is already dashboarded!'
    //             ],
    //         ],
    //         'password' => 'required|min_length[4]',
    //         'confirm'  => 'required_with[password]|matches[password]',
    //         ])) {
    //         $this->session->setFlashData('error_warning', lang('account/dashboard.text_warning'));
    //         return false;
    //     }
    //     return true;
    // }

    //--------------------------------------------------------------------
}
