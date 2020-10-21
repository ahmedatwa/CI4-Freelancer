<?php namespace Catalog\Events;

use \Catalog\Models\Account\ActivityModel;
use Catalog\Libraries\Customer;

class Activity
{
    // Catalog\Controllers\user\user::index
    public static function login()
    {
        $activityModel = new ActivityModel;

        $customer = new Customer();

        $data = [
            'user_id'     => $customer->getCustomerId(),
            'username'    => $customer->getCustomerUserName(),
            ];

        $activityModel->addActivity('activity_customer_login', $data);
    }

    // Admin\Controllers\user\user::Rules
    public static function loginAttempts(string $email)
    {
        $User = new \Admin\Models\User\Users();

        $User->addLoginAttempts($email);
    }

    // Catalog\Controllers\Account\Setting::Edit
    public static function CustomerActivityUpdate($customer_id, $name)
    {
        $activityModel = new ActivityModel;

        $data = [
            'customer_id' => $customer_id,
            'name'        => $name,
        ];

        $activityModel->addActivity('activity_customer_update', $data);
    }

    // Catalog\Models\Account\Register::addCustomer
    public static function customerRegister(int $customer_id, string $username)
    {
        $activityModel = new ActivityModel;
        $data = [
            'customer_id' => (int) $customer_id,
            'username'    => (string) $username,
        ];

        $activityModel->addActivity('customer_register_activity', $data);
    }
    
    
    

    // --------------------------------------------------
}
