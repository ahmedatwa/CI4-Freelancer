<?php namespace Catalog\Libraries;

class Customer
{
    protected $customer_id;
    protected $customer_group_id;
    protected $customer_name;
    protected $customer_image;
    protected $customer_username;
    protected $permission = [];
    protected $session;
    protected $db;
    

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // Set the default time zone
        $this->db->query("SET time_zone = " . $this->db->escape(date('P')));

        $this->session = \Config\Services::session();

        if ($this->session->get('customer_id')) {

            $builder = $this->db->table($this->db->prefixTable('customer'));

            $builder->where([
                'customer_id' => $this->session->get('customer_id'),
                'status'      => 1
            ]);

            $row = $builder->get()
                           ->getRowArray();
            if ($row) {
                $this->customer_id       = $row['customer_id'];
                $this->customer_group_id = $row['customer_group_id'];
                $this->customer_name     = $row['firstname'] . ' ' . $row['lastname'];
                $this->customer_username = $row['username'];
                $this->customer_image    = $row['image'];
            } else {
                $this->logout();
            }
        }
    }

    public function login($email, $password)
    {
        // From Table Users
        $builder = $this->db->table($this->db->prefixTable('customer'));
        $builder->where(['email' => $email, 'status' => 1]);
        $query = $builder->get();
        if ($builder->countAllResults() > 0) {
            $row = $query->getRowArray();
            // Verify stored hash against DB password
            if (password_verify($password, $row['password'])) {
                // The cost parameter can change over time as hardware improves
                $options = array('cost' => 11);
                // Check if a newer hashing algorithm is available
                // or the cost has changed
                if (password_needs_rehash($row['password'], PASSWORD_BCRYPT, $options)) {
                    // If so, create a new hash, and replace the old one
                    $newHash = password_hash($password, PASSWORD_BCRYPT, $options);
                }
              
                $this->customer_id       = $row['customer_id'];
                $this->customer_group_id = $row['customer_group_id'];
                $this->customer_name     = $row['firstname'] . ' ' . $row['lastname'];
                $this->customer_username = $row['username'];
                $this->customer_image    = $row['image'];
                // Build User Data Session Array
                $session_data = [
                    'customer_id'       => $row['customer_id'],
                    'customer_name'     => $row['firstname'] . ' ' . $row['lastname'],
                    'username'          => $row['username'],
                    'customer_group_id' => $row['customer_group_id'],
                    'isLogged'          => (bool) true,
                ];
                // close any open sessions
                $this->session->set($session_data);
                // Set the Online Status
                $builder->set('online', 1)
                    ->where('customer_id', $row['customer_id'])
                    ->update();

                return true;
            } else {
                return false;
            }
        }
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function getCustomerName()
    {
        return $this->customer_name;
    }

    public function getCustomerUserName()
    {
        return $this->customer_username;
    }

    public function logout()
    {
        $builder = $this->db->table($this->db->prefixTable('customer'));
        $builder->set('online', 0)
                ->where('customer_id', $this->session->get('customer_id'))
                ->update();

        $this->customer_id = '';
        $this->customer_name = '';
        $this->customer_group_id = '';
        $this->session->destroy();
    }

    public function isLogged()
    {
        return $this->customer_id;
    }

    public function getcustomerGroupId()
    {
        return $this->customer_group_id;
    }

    public function getcustomerImage()
    {
        return $this->customer_image;
    }



    // _________________________________________________
}
