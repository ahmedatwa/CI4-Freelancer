<?php namespace Catalog\Events;

use \Catalog\Models\Account\ActivityModel;
use Catalog\Models\Account\CustomerModel;

class Notification
{
    // Catalog\Models\Account\MessageModel::addMessage
    public static function newMessage(int $sender_id, int $receiver_id, string $sender, string $message)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id' => $receiver_id,
            'receiver_id' => $sender_id,
            'name'        => $sender,
            'data'        => $message,
        ];

        $activityModel->addActivity('customer_new_message', $activity_data);
    }



    // --------------------------------------------------
}
