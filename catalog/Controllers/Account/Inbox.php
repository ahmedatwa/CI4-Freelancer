<?php 

namespace Catalog\Controllers\Account;

use Catalog\Controllers\BaseController;
use Catalog\Models\Account\InboxModel;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Catalog\ProjectModel;

class Inbox extends BaseController
{

    public function markRead()
    {
        $json = [];
        if (($this->request->getMethod() == 'post') && $this->request->isAJAX()) {
            if ($this->request->getVar('message_id')) {
                $messageModel = new MessageModel();

                $messageModel->markSeen($this->request->getVar('message_id'));
            }
        }
        
        return $this->response->setJSON($json);
    }


    public function getTotalUnseenMessages()
    {
        $json = [];

        $messageModel = new MessageModel();

        $total = $messageModel->getTotalUnseen($this->session->get('customer_id'));
       
        $json = ['total' => $total];
        
        return $this->response->setJSON($json);
    }

    public function sendMessage()
    {
        $json = [];

        if (($this->request->getMethod() == 'post') && $this->request->isAJAX()) {
            $messageModel = new MessageModel();

            if (! $this->validate([
                'message'  => 'required'
            ])) {
                $json['error'] = $this->validator->getError('message');
            }

            if (! $json) {
                $messageModel->addProjectMessage($this->request->getPost());
                $json['success'] = lang('freelancer/project.text_success_pm');
            }
        }

        return $this->response->setJSON($json);
    }

    public function hireMe()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $inboxModel = new InboxModel();

            $inboxModel->insert($this->request->getPost());

            $json['success'] = lang('freelancer/freelancer.text_success');
        }

        return $this->response->setJSON($json);
    }

    // get Project Messages
    public function getProjectMessages()
    {
        if ($this->request->getVar('project_id')) {
            $project_id = $this->request->getVar('project_id');
        } else {
            $project_id = 0;
        }

        if ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        if ($this->request->getVar('receiver_id')) {
            $receiver_id = $this->request->getVar('receiver_id');
        } else {
            $receiver_id = 0;
        }

        $data['members'] = [];

        $messageModel = new MessageModel();
        $customerModel = new CustomerModel();

        $data['customer_id'] = $customer_id;

        $data['help_messages'] = lang('account/message.help_message');
        $data['heading_title'] = lang('project/project.text_manage_bidders');

        $members = $messageModel->getMembers($customer_id);

        foreach ($members as $member) {
            if ($this->session->get('customer_id') == $member['sender_id']) {
                $receiver_id = $member['receiver_id'];
            } else {
                $receiver_id = $member['sender_id'];
            }

            $data['members'][] = [
                'receiver_id' => $member['receiver_id'],
                'sender_id'   => $member['sender_id'],
                'thread_id'   => $member['thread_id'],
                'receiver'    => $customerModel->where('customer_id', $receiver_id)->findColumn('username')[0],
            ];
        }

        return view('freelancer/project_messages', $data);
    }

    public function getThreadMessages()
    {
        if ($this->request->getVar('thread_id')) {
            $thread_id = $this->request->getVar('thread_id');
        } else {
            $thread_id = 0;
        }

        $messageModel = new MessageModel();
        $customerModel = new CustomerModel();

        $results = $messageModel->getMessages($thread_id);

        $data['messages'] = [];

        foreach ($results as $result) {
            $data['messages'][] = [
                'receiver_id' => $result['receiver_id'],
                'sender_id'   => $result['sender_id'],
                'project_id'  => $result['project_id'],
                'thread_id'   => $result['thread_id'],
                'receiver'    => $customerModel->where('customer_id', $result['receiver_id'])->findColumn('username')[0],
                'sender'      => $customerModel->where('customer_id', $result['sender_id'])->findColumn('username')[0],
                'message'     => $result['message'],
                'date_added'  => $this->dateDifference($result['date_added']),
            ];
        }

        $message_info = $messageModel->getMessageBythread($this->request->getVar('thread_id'));

        $data['customer_id'] = $this->session->get('customer_id');
        $data['thread_id'] = $this->request->getVar('thread_id');
        $data['project_id'] = $message_info['project_id'];

        if ($this->session->get('customer_id') == $message_info['sender_id']) {
            $data['receiver_id'] = $message_info['receiver_id'];
        } else {
            $data['receiver_id'] = $message_info['sender_id'];
        }

        return view('freelancer/messages_list', $data);
    }

    //--------------------------------------------------------------------
}
