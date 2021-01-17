<?php namespace Catalog\Models\Account;

class MessageModel extends \CodeIgniter\Model
{
    protected $table          = 'project_to_message';
    protected $primaryKey     = 'message_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['project_id', 'sender_id', 'receiver_id', 'message'];
    protected $useTimestamps  = true;
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function getMessages($thread_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('thread_id', $thread_id);
        $builder->orderBy('date_added', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // public function getMessagesBySenderId($project_id, $customer_id)
    // {
    //     $messages_data = [];
    //     $builder = $this->db->table($this->table);
    //     $builder->select();
    //     $builder->where(['project_id' => $project_id, 'from_id' => $customer_id]);
    //     $query = $builder->get();
    //     foreach ($query->getResultArray() as $result) {
    //         $messages_data[] = [
    //             'message' => $result['message'],
    //             'from_id' => $result['from_id']
    //         ];
    //     }
    //     return $messages_data;
    // }

    // get Chat Members by Customer ID
    public function getMembers($customer_id)
    {
        $members_data = [];

        $builder = $this->db->table($this->table);
        $builder->distinct('sender_id, receiver_id, thread_id');
        $builder->where([
            'sender_id' => $customer_id,
        ]);
        $builder->orWhere([
            'receiver_id' => $customer_id,
        ]);

        $builder->groupBy('thread_id');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // Used
    public function getMessageThread($customer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('sender_id', $customer_id);
        $builder->orWhere('receiver_id', $customer_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        if ($row) {
            return $row;
        } else {
            return;
        }
    }

    public function getMessageBythread($thread_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('thread_id', $thread_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getMessageByCustomerId($seen, $customer_id, $start= 0, $limit = 5)
    {
        $messages = [];

        $builder = $this->db->table($this->table);

        $builder->select();
        $builder->where([
            'receiver_id' => $customer_id,
            'seen'        => $seen
        ]);
        $builder->orderBy('date_added', 'DESC');
        $builder->limit($limit, $start);
        $query = $builder->get();

        foreach ($query->getResultArray() as $result) {
            $messages[] = [
            'thread_id'  => $result['thread_id'],
            'message_id'  => $result['message_id'],
            'receiver_id' => $result['receiver_id'],
            'sender_id'   => $result['sender_id'],
            'project_id'  => $result['project_id'],
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

    // Start From Here
    public function addProjectMessage(array $data)
    {
        $builder = $this->db->table($this->table);

        if (isset($data['thread_id'])) {
            $builder->select();
            $builder->where([
                'thread_id' => $data['thread_id'],
            ]);
            // $builder->orWhere([
            //     'sender_id' => $data['receiver_id'],
            //     'receiver_id' => $data['sender_id'],
            // ]);
            $query = $builder->get();
            $row = $query->getRowArray();

            if ($row) {
                $thread_id = $row['thread_id'];
                $project_id = $row['project_id'];
            } else {
                helper('text');
                $thread_id = random_string('crypto', 10);
                $project_id = 0;
            }
        } else {
            helper('text');
            $thread_id = random_string('crypto', 10);
            $project_id = 0;
        }

        $message_data = [
            'project_id'  => $data['project_id'] ?? $project_id,
            'thread_id'   => $thread_id,
            'sender_id'   => $data['sender_id'],
            'receiver_id' => $data['receiver_id'],
            'message'     => $data['message']
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($message_data);
    }

    // public function addMessage(array $data)
    // {
    //     $builder = $this->db->table($this->table);

    //     if (isset($data['thread_id']) && !empty($data['thread_id'])) {
    //         $builder->select('thread_id');
    //         $builder->where('thread_id', $data['thread_id']);
    //         $query = $builder->get();
    //         $row = $query->getRowArray();
    //         $thread_id = $row['thread_id'];
    //     } else {
    //         helper('text');
    //         $thread_id = random_string('crypto', 10);
    //     }

    //     $message_data = [
    //         'project_id'  => $data['project_id'] ?? 0,
    //         'thread_id'   => $thread_id,
    //         'sender_id'   => $data['sender_id'],
    //         'receiver_id' => $data['receiver_id'],
    //         'message'     => $data['message'],
    //     ];

    //     $builder->set('date_added', 'NOW()', false);
    //     $builder->set('date_modified', 'NOW()', false);
    //     $builder->insert($message_data);
    // }

    // public function editMessage(string $thread_id, array $data)
    // {
    //     $builder = $this->db->table($this->table);
    //     $builder->where('thread_id', $thread_id);

    //     $message_data = [
    //         'message' => json_encode([
    //             'sender_id'   => $data['sender_id'],
    //             'receiver_id' => $data['receiver_id'],
    //             'message'     => $data['message']
    //         ]),
    //     ];

    //     $builder->set('date_added', 'NOW()', false);
    //     $builder->set('date_modified', 'NOW()', false);
    //     $builder->insert($message_data);
    // }
    
    // -----------------------------------------------------------------
}
