<?php

namespace Catalog\Libraries;

use CodeIgniter\I18n\Time;

class Customer
{
    protected $customerID = 0;
    protected $customerGroupID = 0;
    protected $customerName = '';
    protected $customerImage = '';
    protected $customerUsername = '';
    protected $customerEmail = '';
    protected $permission = [];
    protected $session;
    protected $db;
    protected $table = 'customer';

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // Sync PHP and DB time zones
        $this->db->query("SET time_zone = " . $this->db->escape(date('P')));

        $this->session = \Config\Services::session();

        if ($this->session->get('customer_id')) {
            $builder = $this->db->table($this->db->prefixTable($this->table));

            $builder->where([
                'customer_id' => $this->session->get('customer_id'),
                'status'      => 1
            ]);

            $row = $builder->get()
                           ->getRowArray();
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

    public function login(string $email, string $password): bool
    {
        $builder = $this->db->table($this->db->prefixTable($this->table));
        $builder->where([
            'email'  => $email,
            'status' => 1
        ]);
        
        $query = $builder->get();
        if ($builder->countAllResults() > 0) {
            $row = $query->getRow();
            // Verify stored hash against DB password
            if (password_verify($password, $row->password)) {
                $rehash = password_needs_rehash($row->password, PASSWORD_DEFAULT);
            } elseif (isset($row->salt) && $row->password == sha1($row->salt . sha1($row->salt . sha1($password)))) {
                $rehash = true;
            } elseif ($row->password == md5($password)) {
                $rehash = true;
            } else {
                return false;
            }

            if ($rehash) {
                $builder->where(['email'  => $email, 'status' => 1,])
                        ->set('password', password_hash($password, PASSWORD_DEFAULT))
                        ->update();
            }
              
            $this->customerID       = $row->customer_id;
            $this->customerGroupID  = $row->customer_group_id;
            $this->customerName     = $row->firstname . ' ' . $row->lastname;
            $this->customerUsername = $row->username;
            $this->customerImage    = $row->image;
            $this->customerEmail    = $row->email;
            // Build User Data Session []
            $session_data = [
                'customer_id'       => $row->customer_id,
                'customer_name'     => $row->firstname . ' ' . $row->lastname,
                'username'          => $row->username,
                'customer_group_id' => $row->customer_group_id,
                'customer_email'    => $row->email,
                'isLogged'          => (bool) true,
            ];
            $this->session->set($session_data);
            // Set the Online Status
            $builder->set('online', 1)
                        ->where('customer_id', $row->customer_id)
                        ->update();
            return true;
        } else {
            return false;
        }
    }

    public function LoginAccessVerify(string $email, string $code)
    {
        $builder = $this->db->table($this->db->prefixTable($this->table));
        $builder->where([
            'email'  => $email,
            'code'   => $code,
            'status' => 1,
        ]);

        $query = $builder->get();
        if ($builder->countAllResults() > 0) {
            $row = $query->getRow();
            $this->customerID       = $row->customer_id;
            $this->customerGroupID  = $row->customer_group_id;
            $this->customerName     = $row->firstname . ' ' . $row->lastname;
            $this->customerUsername = $row->username;
            $this->customerImage    = $row->image;
            $this->customerEmail    = $row->email;
            // Build User Data Session []
            $session_data = [
                'customer_id'       => $row->customer_id,
                'customer_name'     => $row->firstname . ' ' . $row->lastname,
                'username'          => $row->username,
                'customer_group_id' => $row->customer_group_id,
                'customer_email'    => $row->email,
                'isLogged'          => (bool) true,
            ];
            // close any open sessions
            $this->session->set($session_data);
            // Set the Online Status
            $builder->set('online', 1)
                    ->where('customer_id', $row->customer_id)
                    ->update();
            return true;
        } else {
            return false;
        }
    }

    // 2-step verification
    public function checkTwoStepVerification(string $email): bool
    {
        $builder = $this->db->table($this->db->prefixTable($this->table));
        $builder->where('email', $email);
        $query = $builder->get();
        $row = $query->getRow();
        if ($row->two_step == 1) {
            return true;
        } else {
            return false;
        }
    } 

    public function editAccessCode(string $email, string $code)
    {
        $builder = $this->db->table($this->db->prefixTable($this->table));
        $builder->where('email', $email);
        $builder->set([
            'code'          => $code,
            'date_modified' => Time::now()->getTimestamp(),
        ]);
        $builder->update();
        // trigger forgotton email event
        \CodeIgniter\Events\Events::trigger('mail_twostep_verification', $email, $code);
    }

    public function getID(): int
    {
        return $this->customerID;
    }

    public function getName(): string
    {
        return $this->customerName;
    }

    public function getUserName(): string
    {
        return $this->customerUsername;
    }

    public function logout()
    {
        $builder = $this->db->table($this->db->prefixTable($this->table));
        $builder->set('online', 0)
                ->where('customer_id', $this->session->get('customer_id'))
                ->update();
        $this->customerID = '';
        $this->customerName = '';
        $this->customerGroupIDroupID = '';
        $this->session->destroy();
    }

    public function isLogged(): bool
    {
        return $this->customerID;
    }

    public function getGroupID(): bool
    {
        return $this->customerGroupID;
    }

    public function getImage(): string
    {
        return $this->customerImage;
    }

    public function getEmail(): string
    {
        return $this->customerEmail;
    }

    // _________________________________________________
}
