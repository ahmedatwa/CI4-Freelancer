<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\MessageModel;
use Catalog\Models\Account\CustomerModel;

class Message extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged() ) {
             return redirect('account_login');
        }

        $this->template->setTitle(lang('account/message.heading_title'));

        $customerModel = new CustomerModel();
        $messageModel = new MessageModel();

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => base_url('account/dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/message.heading_title'),
            'href' => base_url('account/message?cid=' . $customer_id),
        ];

       // Chat Memebers
        $data['members'] = [];

        $members = $messageModel->getMembersByCustomerId($customer_id);

        foreach ($members as $result) {

            $customer_info = $customerModel->getCustomer($result['receiver_id']);
            $sender_info = $customerModel->getCustomer($result['sender_id']);

            $data['members'][] = [
                'sender_id'   => $result['sender_id'],
                'online'      => $customer_info['online'],
                'receiver_id' => $result['receiver_id'],
                'receiver'    => $customer_info['username'],
                'sender'      => $sender_info['username'],
                'image'       => $this->resize($customer_info['image'], 40, 40) ? $this->resize($customer_info['image'], 40, 40) : $this->resize('catalog/avatar.jpg', 40, 40)
            ];
        }

        $data['username'] = $this->customer->getCustomerUserName();

        $data['customer_id'] = $customer_id;

        $data['heading_title'] = lang('account/message.heading_title');

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/message', $data);
    }

    public function getChatHistory()
    {
        $json = [];

        if ($this->request->getVar('receiver_id') && $this->request->getVar('sender_id')) {
            
            $messageModel = new MessageModel();

            $filter_data = [
                'sender_id'   => $this->request->getVar('sender_id'),
                'receiver_id' => $this->request->getVar('receiver_id'),
                'project_id'  => 1,
            ];

            $results = $messageModel->getMessages($filter_data);
              
            foreach ($results as $result) {
                $json[] = [
                    'message_id'  => $result['message_id'],
                    'project_id'  => $result['project_id'],
                    'sender_id'   => $result['sender_id'],
                    'receiver_id' => $result['receiver_id'],
                    'message'     => $result['message'],
                    'date_added'  => $result['date_added'],
                ];
            }
        }

        return $this->response->setJSON($json);
    }


    public function markRead() 
    {
        $json = [];
        
        if ($this->request->getVar('message_id')) {

            $messageModel = new MessageModel();

            $messageModel->markSeen($this->request->getVar('message_id'));
        }
        
         return $this->response->setJSON($json);
    }


    public function getTotalUnseenMessages()
    {
        $json = [];

        $messageModel = new \Catalog\Models\Account\MessageModel();

        $total = $messageModel->getTotalUnseen($this->session->get('customer_id'));
       
        $json = ['total' => $total];
        
        return $this->response->setJSON($json);
    }

    public function sendMessage()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {

            $messageModel = new MessageModel();

            $options = [
            'cluster' => 'eu',
            'useTLS' => true
            ];

            $pusher = new \Pusher\Pusher(
                'b4093000fa8e8cab989a',
                'fb4bfd2d78aac168d918',
                '1047280',
                $options
            );

            $data = [
                'project_id'  => 1,
                'sender_id'   => $this->customer->getCustomerId(),
                'receiver_id' => $this->request->getPost('receiver_id'),
                'message'     => $this->request->getPost('message'),
                'date_added'  => date('H:i A'),
            ];


            $messageModel->addMessage($data);
        
            $event = $pusher->trigger('chat-channel', 'my-event', $data);

        }
        return $this->response->setJSON($json);
    }
    //--------------------------------------------------------------------
}
