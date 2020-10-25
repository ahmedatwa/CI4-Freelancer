<?php namespace Catalog\Models\Account;

class MessageModel extends \CodeIgniter\Model
{
    protected $table          = 'project_message';
    protected $primaryKey     = 'message_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['project_id', 'sender_id', 'receiver_id', 'message'];
    protected $useTimestamps  = true;
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function getMessages(array $data = [])
    {
        $builder = $this->db->table($this->table);
        $builder->select();

        if (isset($data['sender_id']) && isset($data['receiver_id'])) {
            $builder->where('sender_id', $data['sender_id']);
            $builder->where('receiver_id', $data['receiver_id']);
            $builder->orWhere('sender_id', $data['receiver_id']);
            $builder->orWhere('receiver_id', $data['sender_id']);
        }

        if (isset($data['project_id'])) {
            $builder->where('project_id', $data['project_id']);
        }

        $builder->orderBy('date_added', 'ASC');
        //$builder->groupBy('sender_id');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getMessagesBySenderId($project_id, $customer_id)
    {
        $messages_data = [];
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where(['project_id' => $project_id, 'from_id' => $customer_id]);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $messages_data[] = [
                'message' => $result['message'],
                'from_id' => $result['from_id']
            ];
        }
        return $messages_data;
    }
    // get Chat Members by Customer ID
    public function getMembersByCustomerId($customer_id)
    {
        $users = [];

        $builder = $this->db->table($this->table);
        $builder->select('receiver_id, sender_id');
        $builder->where('sender_id', $customer_id);
        $builder->orWhere('receiver_id', $customer_id);
        $builder->groupBy('receiver_id');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function addMessage($data)
    {
        $builder = $this->db->table($this->table);
        $data = [
            'project_id'  => $data['project_id'] ?? 0,
            'sender_id'   => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'message'     => $data['message'],
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($data);

        // Trigger Notification Event
        \CodeIgniter\Events\Events::trigger('freelancer_message', $data['receiver_id'], $data['message']);


    }

    public function getMessageByCustomerId($viewed, $customer_id)
    {

        $messages = [];

        $builder = $this->db->table($this->table);

        $builder->select();
        $builder->where(['receiver_id' => $customer_id, 'seen' => 0]);
        $builder->orderBy('message_id', 'DESC');
        $query = $builder->get();

        foreach ($query->getResultArray() as $result) {
           $messages[] = [
            'message_id'  => $result['message_id'],
            'customer_id' => $result['receiver_id'],
            'image'       => $this->getCustomer($result['receiver_id'])['image'],
            'name'        => $this->getCustomer($result['receiver_id'])['name'],
            'message'     => $result['message'],
            'date_added'  => $result['date_added'],
            'total'       => $this->getTotalUnseen($result['receiver_id']),
        ];
        } 

        return $messages;
    }

    public function getTotalUnseen($customer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('message, date_added, sender_id');
        $builder->where(['sender_id' => $customer_id, 'seen' => 0]);
        return $builder->countAllResults();
    }

    public function getCustomer($customer_id)
    {
       $builder = $this->db->table('customer'); 
       $builder->select('CONCAT(firstname, " ", lastname) as name, image, username');
       $builder->where('customer_id', $customer_id);
       $query = $builder->get();
       return $query->getRowArray(); 
    }

    public function markSeen($message_id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('message_id', $message_id);
        $builder->set('seen', 1);
        $builder->update();
    
    }

    // public function updateMessage($project_id, $data)
    // {
    //     $builder = $this->db->table($this->table);

    //     $data = [
    //         'from_id'       => $data['from_id'],
    //         'from_username' => $data['from_username'],
    //         'to_id'         => $data['to_id'],
    //         'to_username'   => $data['to_username'],
    //         'message'       => $data['message'],
    //         'date_modified' => $data['date_added'],
    //     ];
    //     $builder->where('project_id', $project_id);
    //     //$builder->set('date_modified', 'NOW()', false);
    //     $builder->update($data);

    // }
    
    // -----------------------------------------------------------------
}
