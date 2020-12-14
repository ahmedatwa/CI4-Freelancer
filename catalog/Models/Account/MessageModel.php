<?php namespace Catalog\Models\Account;

class MessageModel extends \CodeIgniter\Model
{
    protected $table          = 'message';
    protected $primaryKey     = 'message_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['project_id', 'sender_id', 'receiver_id', 'message'];
    protected $useTimestamps  = true;
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function getMessages(string $thread_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('thread_id', $thread_id);
        $builder->orderBy('date_added', 'ASC');
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
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('sender_id', $customer_id);
        $builder->orWhere('receiver_id', $customer_id);
        $builder->groupBy('thread_id');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getMessageByCustomerId($viewed, $customer_id)
    {

        $messages = [];

        $builder = $this->db->table($this->table);

        $builder->select();
        $builder->where(['receiver_id' => $customer_id, 'seen' => 0]);
        $builder->orderBy('date_added', 'DESC');
        $query = $builder->get();

        foreach ($query->getResultArray() as $result) {
           $messages[] = [
            'message_id'  => $result['message_id'],
            'receiver_id' => $result['receiver_id'],
            'sender_id'   => $result['sender_id'],
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
        $builder->where(['receiver_id' => $customer_id, 'seen' => 0]);
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
        $builder->set('date_modified', 'NOW()', false);
        $builder->update();
    
    }

    // Send Project Message
    // public function addProjectMessage(array $data)
    // {
    //     $builder = $this->db->table($this->table);
    //     helper('text');

    //     if (!empty($data)) {
    //         $rand = random_string('alnum', 10). '-' . $data['sender_id'] . '_' . $data['receiver_id'];
    //     }
    //     var_dump($rand);die;
    //     $message_data = [
    //         'sender_id'       => $data['sender_id'],
    //         'thread'          => $rand,
    //         'receiver_id'     => $data['receiver_id'],
    //         'project_id'      => $data['project_id'],
    //         'message'         => $data['message'],
    //     ];

    //     $builder->set('date_added', 'NOW()', false);
    //     $builder->set('date_modified', 'NOW()', false);
    //     $builder->insert($message_data);

    //     // trigget new direct message event
    //     \CodeIgniter\Events\Events::trigger('project_new_message', $message_data);
    // }



   // New Start From Here
    public function addMessage(array $data)
    {
        $builder = $this->db->table($this->table);
        $builder->select('thread_id');
        $builder->where([
            'sender_id'   => $data['sender_id'],
            'receiver_id' => $data['receiver_id']
        ]);
        $builder->orWhere([
            'sender_id'   => $data['receiver_id'],
            'receiver_id' => $data['sender_id']
        ]);

        if ($builder->countAllResults() > 0) {
            $row = $builder->get()->getRowArray();
            $rand = $row['thread_id'];
        } else {
            helper('text');
            $rand = random_string('crypto', 10);
        }
        
        
        $message_data = [
            'project_id'  => $data['project_id'] ?? 0,
            'thread_id'   => $rand,
            'sender_id'   => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'message'     => json_encode([
                'sender_id'   => $data['sender_id'], 
                'receiver_id' => $data['receiver_id'],
                'text'        => $data['message']
            ]),
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($message_data);
    }

    public function editMessage(string $thread_id, array $data)
    {
        $builder = $this->db->table($this->table);
        $builder->where('thread_id', $thread_id);

        $message_data = [
            'message' => json_encode([
                'sender_id'   => $data['sender_id'], 
                'receiver_id' => $data['receiver_id'],
                'message'     => $data['message']
            ]),
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($message_data);
    }

    // project Private Messages
    // public function getMessagesByThreadID(string $thread_id)
    // {
    //     $builder = $this->db->table($this->table);
    //     $builder->select();
    //     $builder->where('thread_id', $thread_id);

    //     $builder->orderBy('date_added', 'ASC');
    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    
    // -----------------------------------------------------------------
}
