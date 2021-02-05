<?php namespace Admin\Models\User;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table          = 'user';
    protected $primaryKey     = 'user_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['firstname', 'lastname', 'username', 'email', 'password', 'salt', 'status', 'user_group_id', 'image'];
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
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }
        if (! isset($data['data']['salt'])) {
            $data['data']['salt'] = token('sha1', 9);
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
        $builder = $this->db->table($this->table);
        $builder->select('user_id');
        $builder->where('email', $email);
        return $builder->countAllResults();
    }

    public function editCode($email, $code)
    {
        $builder = $this->db->table($this->table);
        $builder->set('code', $code);
        $builder->where('email', $email);
        $builder->update();
    }

    // -----------------------------------------------------------------
}
