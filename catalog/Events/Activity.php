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

        $activityModel->addActivity('customer_register_activity', $data);
    }
    
    // Catalog\Model\Account\CustomerModel\editCode
    public static function forgottenMail(string $email, string $code)
    {
        $config = \Config\Services::email();

        $data['text_subject']     = sprintf(lang('mail/forgotten.text_greeting'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_welcome']     = lang('mail/forgotten.text_welcome');
        $data['text_body']        = lang('mail/forgotten.text_body');
        $data['text_body_append'] = lang('mail/forgotten.text_body_append');
        $data['text_body_last']   = lang('mail/forgotten.text_body_last');
        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');
        $data['button_reset']     = lang('mail/forgotten.button_reset');
        
        $data['link'] = str_replace('&amp;', '&', base_url('account/reset?code=' . $code));

        $request = \Config\Services::request();

        $data['ip'] = $request->getIPAddress();

        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($email);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/forgotten.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        
        $config->setMessage(view('mail/forgotten', $data));

        $config->send();
    }

    // Catalog\Model\Account\CustomerModel\editCode
    public static function RegisterMail(string $email, string $code)
    {
        $config = \Config\Services::email();

        $data['text_greeting'] = sprintf(lang('account/forgotten.text_greeting'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_change']   = lang('account/forgotten.text_change');
        $data['text_ip']       = lang('account/forgotten.text_ip');
        
        $data['reset'] = str_replace('&amp;', '&', base_url('account/reset?code=' . $code));

        $request = \Config\Services::request();

        $data['ip'] = $request->getIPAddress();

        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($email);

        $config->setSubject(html_entity_decode(sprintf(lang('account/forgotten.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        $config->setMessage(view('mail/forgotten', $data));

        $config->send();
    }

    // --------------------------------------------------
}
