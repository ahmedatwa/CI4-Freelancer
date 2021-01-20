<?php namespace Admin\Controllers\Report;

use \Admin\Models\Report\OnlineModel;
use \Admin\Models\Customer\CustomerModel;

class Online extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('report/online.list.heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('common/dashboard?user_token=' . $this->session->get('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('report/online.list.heading_title'),
            'href' => base_url('report/online?user_token=' . $this->session->get('user_token'))
        ];

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $data['user_token'] = $this->session->get('user_token');
        // Reports
        $data['reports'] = [];
        
        $onlineModel = new OnlineModel();
        $customerModel = new CustomerModel();

        $results = $onlineModel->findAll();

        foreach ($results as $result) {
            $customer_info = $customerModel->find($result['customer_id']);
            if ($customer_info) {
                $customer = $customer_info['firstname'] . ' ' . $customer_info['lastname'];
            } else {
                $customer = lang('en.list.text_guest');
            }

            $data['customers'][] = [
                    'customer_id' => $result['customer_id'],
                    'ip'          => $result['ip'],
                    'customer'    => $customer,
                    'url'         => $result['url'],
                    'referer'     => $result['referer'],
                    'date_added'  => lang('en.medium_date', [strtotime($result['date_added'])]),
                    'edit'        => base_url('customer/customer/edit?user_token=' . $this->session->get('user_token') . '&customer_id=' . $result['customer_id'])
                ];
        }
        
        $this->document->output('report/online', $data);
    }


    //--------------------------------------------------------------------
}
