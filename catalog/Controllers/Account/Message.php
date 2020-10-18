<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Account\MessageModel;
use Catalog\Models\Account\CustomerModel;

class Message extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('account/message.heading_title'));

        $customerModel = new CustomerModel();

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
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

        $data['active_members'] = $customerModel->where('customer_id !=', $customer_id)->where('online', 1)->findAll();

        $data['username'] = $this->customer->getCustomerUserName();

        $data['customer_id'] = $customer_id;

        $data['heading_title'] = lang('account/message.heading_title');

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/message', $data);
    }

    public function getChatHistory()
    {
        $json = [];

        if ($this->request->getVar('to_id') && $this->request->getVar('from_id')) {
            
            $messageModel = new MessageModel();

            $filter_data = [
            'from_id'     => $this->request->getVar('from_id'),
            'to_id'       => $this->request->getVar('to_id'),
            'project_id'  => 1,
            ];

            $results = $messageModel->getMessages($filter_data);
              
            foreach ($results as $result) {
                $json[] = [
                    'project_id'   => $result['project_id'],
                    'from_id'      => $result['from_id'],
                    'to_id'        => $result['to_id'],
                    'sender'       => $result['from_username'],
                    'receiver'     => $result['to_username'],
                    'message'      => $result['message'],
                    'date_added'   => $result['date_added'],
                ];
            }
        }

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
                'project_id'    => 1,
                'from_id'       => $this->customer->getCustomerId(),
                'to_id'         => $this->request->getPost('to_id'),
                'from_username' => $this->customer->getCustomerUserName(),
                'to_username'   => $this->request->getPost('to_name'),
                'message'       => $this->request->getPost('message'),
                'date_added'    => date('H:i A'),
            ];


            $messageModel->addMessage($data);
        
            $event = $pusher->trigger('chat-channel', 'my-event', $data);

        }
        return $this->response->setJSON($json);
    }
    //--------------------------------------------------------------------
}
