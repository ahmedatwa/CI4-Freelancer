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
