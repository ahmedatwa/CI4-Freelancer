<?php namespace Catalog\Models\Account;

class MessageModel extends \CodeIgniter\Model
{
    protected $table          = 'project_message';
    protected $primaryKey     = 'message_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['project_id', 'from_id', 'to_id', 'from_username', 'to_username', 'message'];
    protected $useTimestamps  = true;
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function getMessages($data = [])
    {
        $builder = $this->db->table($this->table);
        $builder->select();

        if (isset($data['from_id']) && isset($data['to_id'])) {
            $builder->where('from_id', $data['from_id']);
            $builder->where('to_id', $data['to_id']);
            $builder->orWhere('from_id', $data['to_id']);
            $builder->where('to_id', $data['from_id']);
        }

        if (isset($data['project_id'])) {
            $builder->where('project_id', $data['project_id']);
        }

        $builder->orderBy('date_added', 'ASC');

        // if (isset($data['start']) || isset($data['limit'])) {
        //     if ($data['start'] < 0) {
        //         $data['start'] = 0;
        //     }
        //     if ($data['limit'] < 1) {
        //         $data['limit'] = 20;
        //     }
        //     $builder->limit($data['limit'], $data['start']);
        // }   

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

    public function addMessage($data)
    {
        $builder = $this->db->table($this->table);
        $data = [
            'project_id'    => $data['project_id'],
            'from_id'       => $data['from_id'],
            'from_username' => $data['from_username'],
            'to_id'         => $data['to_id'],
            'to_username'   => $data['to_username'],
            'message'       => $data['message'],
        ];
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($data);

    }

    public function updateMessage($project_id, $data)
    {
        $builder = $this->db->table($this->table);

        $data = [
            'from_id'       => $data['from_id'],
            'from_username' => $data['from_username'],
            'to_id'         => $data['to_id'],
            'to_username'   => $data['to_username'],
            'message'       => $data['message'],
            'date_modified' => $data['date_added'],
        ];
        $builder->where('project_id', $project_id);
        //$builder->set('date_modified', 'NOW()', false);
        $builder->update($data);

    }
    
    // -----------------------------------------------------------------
}
