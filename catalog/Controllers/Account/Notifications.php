<?php namespace Catalog\Controllers\Account;

use \Catalog\Models\Account\ActivityModel;
use \Catalog\Models\Account\CustomerModel;

class Notifications extends \Catalog\Controllers\BaseController
{
    public function getNotifications()
    {
        $json = [];

        if ($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        $activityModel = new ActivityModel();

        $results = $activityModel->getActivitiesByCustomerID($customer_id);

        $customerModel = new CustomerModel();

        foreach ($results as $result) {
            $info = json_decode($result['data'], true);

            $comment = vsprintf(lang('account/activity.text_activity_' . $result['key']), $info);
            
            $username  = '';

            if (isset($info['freelancer_id'])) {
                $username = $customerModel->where('customer_id', $info['freelancer_id'])->findColumn('username')[0];
            } elseif (isset($info['employer_id'])) {
                $username = $customerModel->where('customer_id', $info['employer_id'])->findColumn('username')[0];
            }

            $milestone_status = '';

            switch (isset($info['milestone_status'])) {
                case 0: $milestone_status = 'Pending'; break;
                case 1: $milestone_status = 'Approved'; break;
                case 2: $milestone_status = 'Paid'; break;
                case 3: $milestone_status = 'Canceled'; break;
                default: $milestone_status = 'Pending'; break;
            }

            $find = [
                'url=',
                'freelancer_id=',
                'milestone_status=',
            ];

            $replace = [
                isset($info['url']) ? $info['url'] : '',
                '@' . $username,
                $milestone_status,
                
            ];


            $json[] = [
                'comment' => str_replace($find, $replace, $comment),
            ];
        }

        return $this->response->setJSON($json);
    }

    public function getTotalNotifications()
    {
        $json = [];

        $activityModel = new ActivityModel();

        if ($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        $total = $activityModel->getTotalActivitiesByCustomerID($customer_id);
       
        $json = [
            'total' => $total
        ];
        
        return $this->response->setJSON($json);
    }

    public function markRead()
    {
        $json = [];
        if ($this->request->isAJAX() && ($this->request->getMethod() == 'post')) {
            $activityModel = new ActivityModel();

            if ($this->customer->getCustomerId()) {
                $customer_id = $this->customer->getCustomerId();
            } else {
                $customer_id = 0;
            }

            $activityModel->where('customer_id', $customer_id)
                               ->set('seen', 1)
                               ->update();
            $json['success'] = 'Cleared';                   
        }
       
        return $this->response->setJSON($json);
    }

    
    //--------------------------------------------------------------------
}
