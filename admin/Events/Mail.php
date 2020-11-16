<?php namespace Admin\Events;

class Activity
{
    // Admin\Models\Finance\Disputes::addDisputeHistory
    public static function customer_dispute_notify(int $dispute_status_id, int $dispute_id, int $notify)
    {
        if ($notify) {
            $disputeModel = new \Admin\Models\Localisation\Disputes();
            $customerModel = new \Admin\Models\Customer\Customers();

            $dispute_info = $disputeModel->find($dispute_id);

            $config = \Config\Services::email();

            $data['dispute_id']     = $dispute_id;
            $data['date_added']     = lang('en.medium_date', [strtotime($dispute_info['date_modified'])]);
            $data['dispute_status'] = $disputeModel->getDisputeStatusName($dispute_status_id);
            $data['comment']        = strip_tags(html_entity_decode($comment, ENT_QUOTES, 'UTF-8'));

            $data['text_dispute_id']     = lang('mail/dispute.text_dispute_id');
            $data['text_date_added']     = lang('mail/dispute.text_date_added');
            $data['text_dispute_status'] = lang('mail/dispute.text_dispute_status');
            $data['text_comment']        = lang('mail/dispute.text_comment');
            $data['text_footer']         = lang('mail/dispute.text_footer');
        
            $config->setFrom(service('registry')->get('config_email'));
            $config->setTo([
                $customerModel->where('freelancer_id', $dispute_info['freelancer_id'])->findColumn['email'][0], 
                $customerModel->where('employer_id', $dispute_info['employer_id'])->findColumn['email'][0], 
            ]);

            $config->setSubject(html_entity_decode(sprintf(lang('mail/dispute.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'), $dispute_id), ENT_QUOTES, 'UTF-8'));
        
            $config->setMessage(view('mail/dispute', $data));
            $config->send();
        }


    // Admin\Models\Finance\WithdrawalModel::addWithdrawHistory
    public static function addWithdrawHistory(int $withdraw_status_id, int $withdraw_id, int $notify)
    {
        if ($notify) {
            $withdrawalModel = new \Admin\Models\Finance\WithdrawalModel();
            $customerModel = new \Admin\Models\Customer\Customers();

            $withdraw_info = $withdrawalModel->find($withdraw_id);

            $config = \Config\Services::email();

            $data['withdraw_id']     = $withdraw_id;
            $data['date_added']     = lang('en.medium_date', [strtotime($withdraw_info['date_modified'])]);
            $data['dispute_status'] = $withdrawalModel->getDisputeStatusName($withdraw_status_id);
            $data['comment']        = strip_tags(html_entity_decode($comment, ENT_QUOTES, 'UTF-8'));

            $data['text_dispute_id']     = lang('mail/dispute.text_dispute_id');
            $data['text_date_added']     = lang('mail/dispute.text_date_added');
            $data['text_dispute_status'] = lang('mail/dispute.text_dispute_status');
            $data['text_comment']        = lang('mail/dispute.text_comment');
            $data['text_footer']         = lang('mail/dispute.text_footer');
        
            $config->setFrom(service('registry')->get('config_email'));
            $config->setTo($customerModel->where('customer_id', $withdraw_info['customer_id'])->findColumn['email'][0]);

            $config->setSubject(html_entity_decode(sprintf(lang('mail/dispute.text_subject'), html_entity_decode(service('registry')->get('config_name'), ENT_QUOTES, 'UTF-8'), $withdraw_id), ENT_QUOTES, 'UTF-8'));
        
            $config->setMessage(view('mail/dispute', $data));
            $config->send();
        }

    // ------------------------------------------------------- 
    }








    // -----------------------------
}
