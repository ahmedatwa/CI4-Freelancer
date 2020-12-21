<?php namespace Catalog\Libraries;

class Customer
{
    protected $customerID;
    protected $customerGroupID;
    protected $customerName;
    protected $customerImage;
    protected $customerUsername;
    protected $customerEmail;
    protected $permission = [];
    protected $session;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // Sync PHP and DB time zones
        $this->db->query("SET time_zone = " . $this->db->escape(date('P')));

        $this->session = \Config\Services::session();

        if ($this->session->get('customer_id')) {
            $builder = $this->db->table($this->db->prefixTable('customer'));

            $builder->where([
                'customer_id' => $this->session->get('customer_id'),
                'status'      => 1
            ]);

            $row = $builder->get()->getRowArray();
            if ($row) {
                $this->customerID       = $row['customer_id'];
                $this->customerGroupID  = $row['customer_group_id'];
                $this->customerName     = $row['firstname'] . ' ' . $row['lastname'];
                $this->customerUsername = $row['username'];
                $this->customerImage    = $row['image'];
                $this->customerEmail    = $row['email'];
            } else {
                $this->logout();
            }
        }
    }

    public function login($email, $password)
    {
        // From Table Users
        $builder = $this->db->table($this->db->prefixTable('customer'));
        $builder->where([
            'email'  => $email,
            'status' => 1
        ]);
        
        $query = $builder->get();
        if ($builder->countAllResults() > 0) {
            $row = $query->getRowArray();
            // Verify stored hash against DB password
            if (password_verify($password, $row['password'])) {
                // The cost parameter can change over time as hardware improves
                $options = ['cost' => 11];
                // Check if a newer hashing algorithm is available
                // or the cost has changed
                if (password_needs_rehash($row['password'], PASSWORD_BCRYPT, $options)) {
                    // If so, create a new hash, and replace the old one
                    $newHash = password_hash($password, PASSWORD_BCRYPT, $options);
                }
              
                $this->customerID       = $row['customer_id'];
                $this->customerGroupID  = $row['customer_group_id'];
                $this->customerName     = $row['firstname'] . ' ' . $row['lastname'];
                $this->customerUsername = $row['username'];
                $this->customerImage    = $row['image'];
                $this->customerEmail    = $row['email'];
                // Build User Data Session []
                $session_data = [
                    'customer_id'       => $row['customer_id'],
                    'customer_name'     => $row['firstname'] . ' ' . $row['lastname'],
                    'username'          => $row['username'],
                    'customer_group_id' => $row['customer_group_id'],
                    'customer_email'    => $row['email'],
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
        return $this->customerID ?? 0;
    }

    public function getCustomerName()
    {
        return $this->customerName ?? '';
    }

    public function getCustomerUserName()
    {
        return $this->customerUsername ?? '';
    }

    public function logout()
    {
        $builder = $this->db->table($this->db->prefixTable('customer'));
        $builder->set('online', 0)
                ->where('customer_id', $this->session->get('customer_id'))
                ->update();
        $this->customerID = '';
        $this->customerName = '';
        $this->customerGroupIDroupID = '';
        $this->session->destroy();
    }

    public function isLogged()
    {
        return $this->customerID ?? false;
    }

    public function getCustomerGroupId()
    {
        return $this->customerGroupID ?? 0;
    }

    public function getCustomerImage()
    {
        return $this->customerImage ?? '';
    }

    public function getCustomerEmail()
    {
        return $this->customerEmail ?? '';
    }

    // _________________________________________________
}
