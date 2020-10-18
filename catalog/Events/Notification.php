<?php namespace Catalog\Events;

use \Catalog\Models\Account\ActivityModel;
use Catalog\Models\Account\CustomerModel;

class Notification
{
    // Catalog\Controllers\user\user::index
    public static function newMessage(int $customer_id, string $message)
    {
    	$data = [];

        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id'=> $customer_id,
            'data'       => $message,
        ];

        $activityModel->addActivity('customer_new_message', $activity_data);
    }



    // --------------------------------------------------
}
