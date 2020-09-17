<?php namespace Catalog\Models\Account;

class CustomerModel extends \CodeIgniter\Model
{
    protected $table          = 'customer';
    protected $primaryKey     = 'customer_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['customer_group_id', 'email', 'password', 'status'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // Password Hashing Events
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    // User Activity Events
    // protected $afterInsert = ['afterInsertEvent'];
    // protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';


    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['data']['password']);
        }
        return $data;
    }

    public function addCustomer($data)
    {
        $builder = $this->db->table($this->table);
        $customer_data = [
            'email'             => $data['email'],
            'password'          => password_hash($data['password'], PASSWORD_BCRYPT),
            'customer_group_id' => 1,
            'status'            => 1,
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($customer_data);
    }

    // Login Attempts
    public function addLoginAttempt($email, $ipAddress)
    {
        $builder = $this->db->table('customer_login');
        
        $builder->select();
        $builder->where('email', $email);

        if ($builder->countAllResults() != 0) {
            $builder->set('total', 'total + 1', false);
            $builder->set('date_modified', 'NOW()', false);
            $builder->update();
        } else {
            $data = [
                'email'      => $email,
                'ip'         => $ipAddress,
                'total'      => '1',
            ];
            $builder->set('date_added', 'NOW()', false);
            $builder->set($data);
            $builder->insert($data);
        }
    }

    public function getLoginAttempts($email)
    {
        $builder = $this->db->table('customer_login');
        $builder->where('email', $email);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function deleteLoginAttempts($email)
    {
        $builder = $this->db->table('customer_login');
        $builder->delete(['email' => $email]);
    }




    // -----------------------------------------------------------------
}
