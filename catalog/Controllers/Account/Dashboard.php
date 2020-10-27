<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Account\ActivityModel;

class Dashboard extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged() ) {
             return redirect('account_login');
        }

        $this->template->setTitle(lang('account/dashboard.heading_title'));
        
        if($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
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

        // news Feed

        $data['news_feed'] = [];

        $activityModel = new ActivityModel();

        $results = $activityModel->where('customer_id', $customer_id)->findAll();

        foreach ($results as $result) {

            $comment = vsprintf(lang('account/activity.' . $result['key']), json_decode($result['data'], true));

            $find = [
                'customer_id=',
            ];

            $replace = [
                base_url('customer/customer/edit'),
            ];

            $data['news_feed'][] = [
                'comment'    => str_replace($find, $replace, $comment),
                'date_added' => $this->dateDifference($result['date_added'])
            ];
        }

        $data['text_dashboard'] = lang('account/dashboard.text_dashboard');
        $data['text_greeting']  = sprintf(lang('account/dashboard.text_greeting'), $customer_info['firstname'] ." " . $customer_info['lastname']);
        $data['heading_title']  = lang('account/dashboard.heading_title');
        $data['text_news_feed'] = lang('account/dashboard.text_news_feed');


        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/dashboard', $data);
    }

    //--------------------------------------------------------------------
}
