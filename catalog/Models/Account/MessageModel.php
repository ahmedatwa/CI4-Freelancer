<?php

namespace Catalog\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class MessageModel extends Model
{
    protected $table          = 'project_to_message';
    protected $primaryKey     = 'message_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['project_id', 'sender_id', 'receiver_id', 'message'];
    // should use for keep data record create timestamp
    protected $useTimestamps  = true;
    protected $dateFormat     = 'int';
    protected $createdField   = 'date_added';
    protected $updatedField   = 'date_modified';

    public function getMessages($thread_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('thread_id', $thread_id);
        $builder->orderBy('date_added', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

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

    public function getMessageByCustomerId(int $seen, int $customer_id, int $start= 0, int $limit = 5)
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
        $builder->set('date_modified', Time::now()->getTimestamp());
        $builder->update();
    }

    public function addProjectMessage(array $data)
    {
        $builder = $this->db->table($this->table);

        if (isset($data['thread_id'])) {
            $builder->select();
            $builder->where([
                'thread_id' => $data['thread_id'],
            ]);
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
            'project_id'    => $data['project_id'] ?? $project_id,
            'thread_id'     => $thread_id,
            'sender_id'     => $data['sender_id'],
            'receiver_id'   => $data['receiver_id'],
            'message'       => $data['message'],
            'date_added'    => Time::now()->getTimestamp(),
            'date_modified' => Time::now()->getTimestamp()
        ];

        $builder->insert($message_data);
    }
    
    // -----------------------------------------------------------------
}
