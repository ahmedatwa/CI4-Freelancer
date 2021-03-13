<?php

namespace Catalog\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class CustomerModel extends Model
{
    protected $table          = 'customer';
    protected $primaryKey     = 'customer_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['customer_group_id', 'email', 'password', 'firstname', 'lastname', 'image', 'bg_image', 'about', 'tag_line', 'rate', 'username', 'online', 'status', 'origin', 'social', 'profile_strength', 'two_step'];
    protected $useSoftDeletes = false;
    // Password Hashing Events
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];
    // User Activity Events
    protected $afterUpdate    = ['afterUpdate'];
    // should use for keep data record create timestamp
    protected $useTimestamps  = true;
    protected $dateFormat     = 'int';
    protected $createdField   = 'date_added';
    protected $updatedField   = 'date_modified';

    protected function hashPassword(array $data = [])
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }
        // Social Network
        if (isset($data['data']['social'])) {
            $data['data']['social'] = json_encode($data['data']['social']);
        } else {
            $data['data']['social'] = '';
        }

        return $data;
    }

    protected function afterUpdate(array $data)
    {
        if (isset($data['id'])) {
            \CodeIgniter\Events\Events::trigger('customer_update', $data['id'][0]);
        }
        return $data;
    }

    public function addCustomer(array $data)
    {
        $builder = $this->db->table($this->table);
        $customer_data = [
            'username'          => substr($data['email'], 0, strpos($data['email'], '@')),
            'email'             => $data['email'],
            'password'          => password_hash($data['password'], PASSWORD_DEFAULT),
            'customer_group_id' => 1,
            'status'            => 1,
            'date_added'        => Time::now()->getTimestamp(),
        ];

        $builder->insert($customer_data);
        // Events
        \CodeIgniter\Events\Events::trigger('customer_register', $this->db->insertID(), explode('@', $data['email'])[0]);
        \CodeIgniter\Events\Events::trigger('mail_register', $data['email']);
    }

    // Login Attempts
    public function addLoginAttempt(string $email, $ipAddress)
    {
        $builder = $this->db->table('customer_login');
        
        $builder->select();
        $builder->where('email', $email);

        if ($builder->countAllResults() != 0) {
            $builder->set('total', 'total + 1', false);
            $builder->set('date_modified', Time::now()->getTimestamp());
            $builder->update();
        } else {
            $data = [
                'email'      => $email,
                'ip'         => $ipAddress,
                'total'      => '1',
            ];
            $builder->set('date_added', Time::now()->getTimestamp());
            $builder->set($data);
            $builder->insert($data);
        }
    }

    public function getLoginAttempts(string $email)
    {
        $builder = $this->db->table('customer_login');
        $builder->where('email', $email);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function deleteLoginAttempts(string $email)
    {
        $builder = $this->db->table('customer_login');
        $builder->delete(['email' => $email]);
    }

    public function getCustomerProfileView(int $customer_id)
    {
        $builder = $this->db->table('customer');
        $builder->select('viewed');
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        return $row['viewed'];
    }

    // Forgotten Password
    public function editCode($email, $code)
    {
        $builder = $this->db->table($this->table);
        $builder->where('email', $email);
        $builder->set('code', $code);
        $builder->update();
        // trigger forgotton email event
        \CodeIgniter\Events\Events::trigger('mail_forgotten', $email, $code);
    }

    public function editPassword(string $email, $password)
    {
        $builder = $this->db->table($this->table);
        $builder->where('email', $email);
        $builder->set('password', password_hash($password, PASSWORD_DEFAULT));
        $builder->update();
    }

    public function getCustomerByCode(string $code)
    {
        if ($code && (! empty($code))) {
            $builder = $this->db->table($this->table);
            $builder->select('customer_id, firstname, lastname, email, date_modified');
            $builder->where('code', $code);
            $query = $builder->get();
            return $query->getRowArray();
        }
       return false; 
    }


    public function getTotalCustomersByEmail(string $email)
    {
        $builder = $this->db->table($this->table);
        $builder->selectCount('*', 'total');
        $builder->where('email', $email);
        $row = $builder->get()->getRowArray();
        return $row['total'];
    }

    // for Dahsboard Widget
    public function getTotalProjectsByCustomerId(int $customer_id)
    {
        $builder = $this->db->table('project');
        $builder->where('employer_id', $customer_id);
        return $builder->countAllResults();
    }

    public function getBalanceByMonth(int $customer_id)
    {
        $balance_data = [];

        $builder = $this->db->table('customer_to_balance');
        $builder->select('SUM(used) AS total_used, SUM(withdrawn) As total_withdrawn, SUM(income) AS total_income, MONTHNAME(date_added) AS month');
        $builder->where('customer_id', $customer_id);
        $builder->groupBy('month');
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $balance_data[] = [
                'month'   => $result['month'],
                'total'   => ($result['total_used'] + $result['total_withdrawn']) - $result['total_income']
            ];
        }
        
        return $balance_data;
    }

    // -----------------------------------------------------------------
}
