<?php namespace Admin\Libraries;

class User
{
    protected $userId;
    protected $userGroupId;
    protected $permission = array();
    protected $userName;
    protected $session;
    protected $db;
    

    public function __construct()
    {
        $this->db = \Config\Database::connect();

        $this->session = \Config\Services::session();

        if ($this->session->get('user_id')) {
            $users = $this->db->table($this->db->prefixTable('user'));

            $users->where('user_id', $this->session->get('user_id'));
            $users->where('status', 1);
            $usersRow = $users->get()->getRow();
            if ($usersRow) {
                $this->userId = $usersRow->user_id;
                $this->userGroupId = $usersRow->user_group_id;
                $this->userName = $usersRow->firstname . ' ' . $usersRow->lastname;

                // Permission Query
                $usersGroup = $this->db->table($this->db->prefixTable('user_group'));
                $usersGroup->select('permission');
                $usersGroup->where('user_group_id', $usersRow->user_group_id);
                $query = $usersGroup->get();
                $usersGroupRow = $query->getRowArray();
                $permissionRow = json_decode($usersGroupRow['permission'], true);

                if (is_array($permissionRow)) {
                    foreach ($permissionRow as $key => $value) {
                        $this->permission[$key] = $value;
                    }
                }
            } else {
                $this->logout();
            }
        }
    }



    public function login($email, $password)
    {
        // From Table Users
        $builder = $this->db->table($this->db->prefixTable('user'));
        $builder->select();
        $builder->where('email', $email);
        $builder->where('status', 1);
        if ($builder->countAllResults()) {
            $query = $builder->get();
            $row = $query->getRow();
           // Verify stored hash against DB password
            if (password_verify($password, $row->password)) {
                // The cost parameter can change over time as hardware improves
                 $options = array('cost' => 11);
                // Check if a newer hashing algorithm is available
                // or the cost has changed
                if (password_needs_rehash($row->password, PASSWORD_BCRYPT, $options)) {
                    // If so, create a new hash, and replace the old one
                    $newHash = password_hash($password, PASSWORD_BCRYPT, $options);
                }
            } else {
                return false;
            }
            $this->userId = $row->user_id;
            $this->userGroupId = $row->user_group_id;
            $this->userName = $row->firstname . ' ' . $row->lastname;
            // Build User Data Session Array
            $user_data = array(
                'user_id'       => $row->user_id,
                'username'      => $row->firstname . ' ' . $row->lastname,
                'user_group_id' => $row->user_group_id,
                'isLogged'      => (bool) true,
            );

            $this->session->set($user_data);

            return true;
        } else {
            return false;
        }
    }

    public function hasPermission($key, $value)
    {
        if (isset($this->permission[$key])) {
            return in_array($value, $this->permission[$key]);
        } else {
            return false;
        }
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function logout()
    {
        $this->userId = '';
        $this->userName = '';
        $this->userGroupId = '';
        $this->session->destroy();
    }

    public function isLogged()
    {
        return $this->userId;
    }

    public function getGroupId()
    {
        return $this->userGroupId;
    }


    // _________________________________________________
}
