<?php namespace Admin\Models\User;

class UserGroupModel extends \CodeIgniter\Model
{
    protected $table          = 'user_group';
    protected $primaryKey     = 'user_group_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['name', 'permission'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data'])) {
            $data['id'] = [
                'key'   => 'user_group_id',
                'value' => $data['id']
            ];

            $data['data'] = [
                'name' => $data['data']['name'],
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'user_group_add', $data['id'], $data['data']);
        }
        return $data;
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $data['id'] = [
                'key'   => 'user_group_id',
                'value' => $data['id']
            ];
            
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'user_group_edit', $data['id'], $data['data']);
        }
        return $data;
    }

    // can't use find method as permission must be decoded
    public function getUserGroup(int $user_group_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('user_group_id', $user_group_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        $user_group = [
             'name'       => $row['name'],
             'permission' => json_decode($row['permission'], true),
        ];
        return $user_group;
    }

    public function addUserGroup(array $data = [])
    {
        $builder = $this->db->table($this->table);
        $user_group_data = [
            'name'       => $data['name'],
            'permission' => isset($data['permission']) ? json_encode($data['permission']) : '',
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($user_group_data);
        $user_group_id = $this->db->insertID();
        // Event Call
        $eventData = [
            'id'   => $user_group_id,
            'data' => [
                'user_group' => $user_group_data['name']
            ]
        ];
        $this->afterInsertEvent($eventData);
    }

    public function editUserGroup(int $user_group_id, array $data = [])
    {
        $builder = $this->db->table($this->table);
        $user_group_data = [
            'name'       => $data['name'],
            'permission' => isset($data['permission']) ? json_encode($data['permission']) : '',
        ];

        $builder->where('user_group_id', $user_group_id);
        $builder->set('date_modified', 'NOW()', false);
        $builder->update($user_group_data);
        // Event Call
        $eventData = [
            'id'   => $user_group_id,
            'data' => [
                'user_group' => $user_group_data['name']
            ]
        ];
        $this->afterUpdateEvent($eventData);
    }

    public function addPermission(int $user_group_id, string $type, string $route)
    {
        $builder = $this->db->table($this->table);
        $builder->distinct();
        if ($builder->countAllResults() > 0) {
            $builder->where('user_group_id', $user_group_id);
            $row = $builder->get()->getRowArray();
            $data = json_decode($row['permission'], true);

            $data[$type][] = $route;
            
            $builder->set('permission', json_encode($data));
            $builder->where('user_group_id', $user_group_id);
            $builder->update();
        }
    }


    // -----------------------------------------------------------------
}
