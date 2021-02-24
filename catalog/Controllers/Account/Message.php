<?php namespace Catalog\Controllers\Account;

use \Catalog\Models\Account\MessageModel;
use \Catalog\Models\Account\CustomerModel;
use \Catalog\Models\Catalog\ProjectModel;

class Message extends \Catalog\Controllers\BaseController
{
    // public function index()
    // {
    //     if (! $this->session->get('customer_id') && ! $this->customer->isLogged()) {
    //         return redirect('account_login');
    //     }

    //     $this->template->setTitle(lang('account/message.heading_title'));

    //     $customerModel = new CustomerModel();
    //     $messageModel = new MessageModel();

    //     if ($this->request->getVar('cid')) {
    //         $customer_id = $this->request->getVar('cid');
    //     } elseif ($this->customer->getCustomerId()) {
    //         $customer_id = $this->customer->getCustomerId();
    //     } else {
    //         $customer_id = 0;
    //     }

    //     if ($this->request->getVar('pid')) {
    //         $project_id = $this->request->getVar('pid');
    //     } else {
    //         $project_id = 0;
    //     }

    //     $data['breadcrumbs'] = [];
    //     $data['breadcrumbs'][] = [
    //         'text' => lang($this->locale . '.text_home'),
    //         'href' => base_url(),
    //     ];

    //     $data['breadcrumbs'][] = [
    //         'text' => lang('account/dashboard.heading_title'),
    //         'href' => base_url('account/dashboard'),
    //     ];

    //     $data['breadcrumbs'][] = [
    //         'text' => lang('account/message.heading_title'),
    //         'href' => base_url('account/message?cid=' . $customer_id),
    //     ];

    //     // Chat Memebers
    //     $data['members'] = [];

    //     $members = $messageModel->getMembersByCustomerId($customer_id);

    //     foreach ($members as $result) {
    //         $customer_info = $customerModel->getCustomer($result['receiver_id']);
    //         $sender_info = $customerModel->getCustomer($result['sender_id']);

    //         $data['members'][] = [
    //             'sender_id'   => $result['sender_id'],
    //             'thread_id'   => $result['thread_id'],
    //             'online'      => $customer_info['online'],
    //             'receiver_id' => $result['receiver_id'],
    //             'receiver'    => $customer_info['username'],
    //             'sender'      => $sender_info['username'],
    //             'image'       => $this->resize($customer_info['image'], 40, 40) ? $this->resize($customer_info['image'], 40, 40) : $this->resize('catalog/avatar.jpg', 40, 40)
    //         ];
    //     }

    //     $data['username'] = $this->customer->getCustomerUserName();

    //     $data['customer_id'] = $customer_id;

    //     $data['heading_title'] = lang('account/message.heading_title');

    //     $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

    //     $this->template->output('account/message', $data);
    // }

    // public function getChatHistory()
    // {
    //     $json = [];

    //     if ($this->request->getVar('thread_id')) {
    //         $messageModel = new MessageModel();
    //         $customerModel = new CustomerModel();
            
    //         $results = $messageModel->getMessages($this->request->getVar('thread_id'));
              
    //         foreach ($results as $result) {
    //             $json[] = [
    //                 'message_id'  => $result['message_id'],
    //                 'project_id'  => $result['project_id'],
    //                 'sender_id'   => $result['sender_id'],
    //                 'sender'      => $customerModel->where('customer_id', $result['sender_id'])->findColumn('username'),
    //                 'receiver'    => $customerModel->where('customer_id', $result['receiver_id'])->findColumn('username'),
    //                 'receiver_id' => $result['receiver_id'],
    //                 'message'     => json_decode($result['message'], true),
    //                 'date_added'  => $result['date_added'],
    //             ];
    //         }
    //     }


    //     return $this->response->setJSON($json);
    // }


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
            $messageModel = new MessageModel();

            $messageModel->addProjectMessage($this->request->getPost());

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
