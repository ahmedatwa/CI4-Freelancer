<?php namespace Catalog\Events;

use \Catalog\Models\Account\ActivityModel;
use Catalog\Models\Account\CustomerModel;

class MailAlert
{

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

    // Catalog\Model\Account\CustomerModel\AddCustomer
    public static function registerMail(string $email, string $code)
    {
        $config = \Config\Services::email();

        $data['text_subject'] = sprintf(lang('mail/register.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_welcome'] = lang('mail/register.text_welcome');
        $data['text_login']   = lang('mail/register.text_login');
        $data['text_service'] = lang('mail/register.text_service');
        $data['text_thanks']  = lang('mail/register.text_thanks');

        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');


        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($email);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/register.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        $config->setMessage(view('mail/register', $data));

        $config->send();
    }
    
    // Catalog\Model\Account\CustomerModel\AddCustomer
    public static function projectAlert(string $email, string $code)
    {
        $config = \Config\Services::email();

        $data['text_subject']    = sprintf(lang('mail/project_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_received']   = lang('mail/project_alert.text_received');
        $data['text_pay']        = lang('mail/project_alert.text_pay');
        $data['text_project_id'] = lang('mail/project_alert.text_project_id');

        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');


        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($email);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/project_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        $config->setMessage(view('mail/project_alert', $data));

        $config->send();
    }

    // Catalog\Model\Account\CustomerModel\AddCustomer
    public static function PaymentMail(array $data)
    {

        $config = \Config\Services::email();
        $customerModel = new CustomerModel();

        $data['text_subject']    = sprintf(lang('mail/payment_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $data['text_received']   = sprintf(lang('mail/payment_alert.text_received'), $data['project_id']);
        $data['text_amount']     = sprintf(lang('mail/payment_alert.text_amount'), $data['amount']);

        $data['config_name']      = service('registry')->get('config_name');
        $data['config_address']   = service('registry')->get('config_address');


        $config->setFrom(service('registry')->get('config_email'));

        $config->setTo($customerModel->getCustomer($data['freelancer_id'])['email']);

        $config->setSubject(html_entity_decode(sprintf(lang('mail/payment_alert.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8'));
        
        $config->setMessage(view('mail/payment_alert', $data));

        $config->send();
    }
    // --------------------------------------------------
}
