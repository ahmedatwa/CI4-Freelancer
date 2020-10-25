<?php namespace Catalog\Controllers\Account;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Catalog\Libraries\Chat;
use Catalog\Models\Account\MessageModel;
use Catalog\Models\Account\CustomerModel;

class Inbox extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $messageModel = new MessageModel();
        $customerModel = new CustomerModel();

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
        }
        
        $data['customer_id'] = $customer_id;

        // Chat Memebers
        $members = $messageModel->getMembersByCustomerId($customer_id);

        foreach ($members as $result) {
           $customer_info = $customerModel->getCustomer($result['sender_id']);

            $data['members'][] = [
                'receiver_id' => $result['receiver_id'],
                'receiver'    => $customer_info['username'],
                'image'       => $this->resize($customer_info['image'], 40, 40) ? $this->resize($customer_info['image'], 40, 40) : $this->resize('catalog/avatar.jpg', 40, 40)
        ];
        }


        $this->template->output('account/inbox', $data);
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

    //--------------------------------------------------------------------
}
