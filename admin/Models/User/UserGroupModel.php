<?php namespace Admin\Models\User;

use CodeIgniter\Model;

class UserGroupModel extends Model
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
        if (isset($data['data']['name'])) {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        }
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['name'])) {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        }
    }

    // can't use find method as permission must be decoded
    public function getUserGroup(int $user_group_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('user_group_id', $user_group_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        $user_group = array(
             'name'       => $row['name'],
             'permission' => json_decode($row['permission'], true),
        );
        return $user_group;
    }

    public function addUserGroup(array $data = [])
    {
        $builder = $this->db->table($this->table);
        $user_group_data = array(
            'name'       => $data['name'],
            'permission' => isset($data['permission']) ? json_encode($data['permission']) : '',
        );

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($user_group_data);
    }

    public function editUserGroup(int $user_group_id, array $data = [])
    {
        $builder = $this->db->table($this->table);
        $user_group_data = array(
            'name'       => $data['name'],
            'permission' => isset($data['permission']) ? json_encode($data['permission']) : '',
        );

        $builder->where('user_group_id', $user_group_id);
        $builder->set('date_modified', 'NOW()', false);
        $builder->update($user_group_data);
    }

    public function addPermission($user_group_id, $type, $route)
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
