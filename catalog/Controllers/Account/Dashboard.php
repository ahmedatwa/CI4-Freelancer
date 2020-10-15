<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;

class Dashboard extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if (! $this->customer->getCustomerId() && ! $this->customer->isLogged() ) {
             return redirect()->to(base_url('account/login'));
        }

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

        $data['profile_views'] = $customerModel->getCustomerProfileView($customer_id);

        $data['text_dashboard']  = lang('account/dashboard.text_dashboard');
        $data['text_greeting']   = sprintf(lang('account/dashboard.text_greeting'), $customer_info['firstname'] ." " . $customer_info['lastname']);
        $data['heading_title']   = lang('account/dashboard.heading_title');


        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/dashboard', $data);
    }

    //--------------------------------------------------------------------
}
