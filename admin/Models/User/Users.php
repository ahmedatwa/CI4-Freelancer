<?php namespace Admin\Models\User;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table          = 'user';
    protected $primaryKey     = 'user_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['firstname', 'lastname', 'email', 'password', 'status', 'user_group_id', 'image'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // Password Hashing Events
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';
    protected $deletedField = 'date_deleted';

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['data']['password']);
        }
        return $data;
    }

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        }
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        }
    }

    // Login Attempts
    public function addLoginAttempts(string $email)
    {
        $builder = $this->db->table('user_login');
        
        $builder->select();
        $builder->where('email', $email);

        if ($builder->countAllResults() != 0) {
            $builder->set('total', 'total + 1', false);
            $builder->set('date_modified', 'NOW()', false);
            $builder->update();
        } else {
            $request = \Config\Services::request();
            $data = array(
                'email'      => $email,
                'ip'         => $request->getIPAddress(),
                'total'      => '1',
            );
            $builder->set('date_added', 'NOW()', false);
            $builder->set('date_modified', 'NOW()', false);
            $builder->insert($data);
        }
    }

    public function getLoginAttempts($email)
    {
        $builder = $this->db->table('user_login');
        $builder->select();
        $builder->where('email', $email);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function deleteLoginAttempts($email)
    {
        $builder = $this->db->table('user_login');
        $builder->delete(['email' => $email]);
    }

    // Forget Passowrd functions

    public function getTotalUsersByEmail($email)
    {
        $builder = $this->db->Table($this->db->prefixTable('user'));

        $builder->select('user_id');
        $builder->where('email', $email);
        return $builder->countAllResults();
    }

    public function editCode($email, $code)
    {
        $builder = $this->db->Table($this->db->prefixTable('user'));
        $builder->set('code', $code);
        $builder->where('email', $email);
        $builder->replace();
    }




    // -----------------------------------------------------------------
}
