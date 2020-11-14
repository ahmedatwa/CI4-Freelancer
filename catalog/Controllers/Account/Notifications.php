<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\ActivityModel;
use Catalog\Models\Account\CustomerModel;

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

        if ($this->request->getVar('seen')) {
            $activityModel->set(['seen' => 1])->update();
        }

        $results = $activityModel->getActivitiesByCustomerID($customer_id);

        foreach ($results as $result) {

            $info = json_decode($result['data'], true);

            $comment = vsprintf(lang('account/activity.text_activity_' . $result['key']), $info);

            $find = [
                'project_id=',
                'employer_id=',
                'freelancer_id=',
            ];

            $seo_url = service('seo_url');
            $keyword = $seo_url->getKeywordByQuery('project_id=' . $info['project_id']);

            if (isset($info['employer_id'])) {
               $employer = $activityModel->getEmployerUserName($info['employer_id']);
            }

            if (isset($info['freelancer_id'])) {
                $freelancer = $activityModel->getFreelancerUserName($info['freelancer_id']);
            }

            $replace = [
                'service/' . $keyword,
                $employer['username'] ?? '',
                $freelancer['username'] ?? '',
            ];


            $json[] = [
                'comment'    => str_replace($find, $replace, $comment),
                'date_added' => $this->dateDifference($result['date_added'])
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
       
        $json = ['total' => $total];
        
        return $this->response->setJSON($json);
    }

    
    //--------------------------------------------------------------------
}
