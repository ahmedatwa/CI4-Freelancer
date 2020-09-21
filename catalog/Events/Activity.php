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

    // Catalog\Controllers\Account\Forgotten::index
    public static function mailForgotten(string $customer_email)
    {
        $email = \Config\Services::email();

        $email->setFrom(service('registry')->get('config_email'), service('registry')->get('config_name'));
        $email->setTo($customer_email);
    
        $email->setSubject('Reset Your Password');
        $email->setMessage(view('Mail/forgotten'));
    
        $email->send();
    }

    // Catalog\Controllers\Account\Register::index
    public static function mailRegister(string $customer_email)
    {
        $email = \Config\Services::email();

        $email->setFrom(service('registry')->get('config_email'), service('registry')->get('config_name'));
        $email->setTo($customer_email);
    
        $email->setSubject('Reset Your Password');
        $email->setMessage(view('Mail/forgotten'));
    
        $email->send();
    }

    // Catalog\Models\Account\Register::addCustomer
    public static function customerRegister(int $customer_id, string $username)
    {
        $activityModel = new ActivityModel;
        $data = [
            'customer_id' => (int) $customer_id,
            'username'    => (string) $username,
        ];

        $activityModel->addActivity('customer_register', $data);
    }
   







    // -----------------------------
}
