<?php namespace Catalog\Models\Account;

class CustomerModel extends \CodeIgniter\Model
{
    protected $table          = 'customer';
    protected $primaryKey     = 'customer_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['customer_group_id', 'email', 'password', 'firstname', 'lastname', 'image', 'about', 'tag_line', 'rate'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // Password Hashing Events
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    // User Activity Events
    protected $afterUpdate = ['afterUpdateEvent'];
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

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['username'])) {
            \CodeIgniter\Events\Events::trigger('customer_activity_update', $data['customer_id'], $data['data']['username']);
        } 
    }


    public function addCustomer($data)
    {
        $builder = $this->db->table($this->table);
        $customer_data = [
            'username'          => explode('@', $data['email'])[0],
            'email'             => $data['email'],
            'password'          => password_hash($data['password'], PASSWORD_BCRYPT),
            'customer_group_id' => 1,
            'status'            => 1,
        ];
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($customer_data);
        \CodeIgniter\Events\Events::trigger('customer_register_activity', $this->db->insertID(), explode('@', $data['email'])[0]);
        \CodeIgniter\Events\Events::trigger('new_customer_greeting', $data['email']);
    }

    public function getCustomers(array $data = [])
    {
        $builder = $this->db->table('customer c');
        $builder->select('CONCAT(c.firstname, " ", c.lastname) AS name, c.about, c.tag_line, c.image, c.customer_id, c.rate, c.online, c.username');
        $builder->join('customer_to_category c2c', 'c.customer_id = c2c.freelancer_id', 'left');

        if (isset($data['filter_freelancer'])) {
            //$builder->where('about IS NOT', $data['filter_freelancer']);
            $builder->where('c.rate >', $data['filter_freelancer']);
        }

        if (isset($data['filter_skills']) && !empty($data['filter_skills'])) {
            $builder->whereIn('c2c.category_id', $data['filter_skills']);
        }

       
        if (isset($data['filter_rate'])) {
            switch ($data['filter_rate']) {
                case '10': 
                   $builder->where('c.rate <=', 10);
                   break;
                case '10_20': 
                   $builder->where('c.rate >=', 10)->where('c.rate <=', 20);
                   break;
                case '20_30': 
                   $builder->where('c.rate >=', 20)->where('c.rate <=', 30);
                   break;
                case '30_40': 
                   $builder->where('c.rate >=', 30)->where('c.rate <=', 40);
                   break;
                case '40': 
                   $builder->where('c.rate >=', 40);
                   break;
            }
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('c.date_added', 'DESC');
        } else {
            $builder->orderBy('c.date_added', 'ASC');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        //echo $builder->getCompiledSelect();
        $builder->groupBy('c.customer_id');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getCustomer($customer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getTotalCustomers($data = [])
    {
        $builder = $this->db->table('customer');
        $builder->select();
        

        if (!empty($data['filter_freelancer'])) {
            $builder->OrWhere('about IS NOT', $data['filter_freelancer']);
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('date_added', 'DESC');
        } else {
            $builder->orderBy('date_added', 'ASC');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        return $builder->countAllResults();
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

    // ------ Certificates ------ //
    public function addCertificate($data)
    {
        $builder = $this->db->table('customer_to_certificate');
        $data = [
          'freelancer_id' => $data['freelancer_id'],
          'name'          => $data['name'],
          'year'          => $data['certificate_year'],
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($data);
    }

    public function getCustomerCertificates($freelancer_id, $start = 0, $limit = 20)
    {
        $builder = $this->db->table('customer_to_certificate');
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }
        $builder->select();
        $builder->where('freelancer_id', $freelancer_id);
        $builder->orderBy('date_added', 'DESC');
        $builder->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalCertificatesByCustomerId($freelancer_id)
    {
        $builder = $this->db->table('customer_to_certificate');
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }
    
    public function deleteCustomerCertificate($certificate_id)
    {
        $builder = $this->db->table('customer_to_certificate');
        $builder->delete(['certificate_id' => $certificate_id]);
    }

    // ------ Education ------ //
    public function addEducation($data)
    {
        $builder = $this->db->table('customer_to_education');
        $data = [
          'freelancer_id' => $data['freelancer_id'],
          'university_id' => $data['university_id'],
          'major_id'      => $data['major_id'],
          'title'         => $data['major_title'],
          'year'          => $data['major_year'],
          'country'       => $data['education_country'],
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($data);
    }

    public function getEducations($freelancer_id, $start = 0, $limit = 20)
    {
        $builder = $this->db->table('customer_to_education s2e');
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }

        $builder->select('um.text AS major, u.text AS university, s2e.freelancer_id, s2e.country, s2e.title, s2e.year, s2e.education_id');
        $builder->join('university u', 'u.university_id = s2e.university_id', 'LEFT');
        $builder->join('university_majors um', 'um.major_id = s2e.major_id', 'LEFT');
        $builder->where('s2e.freelancer_id', $freelancer_id);
        $builder->orderBy('s2e.date_added', 'DESC');
        $builder->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalEducationsByCustomerID($freelancer_id)
    {
        $builder = $this->db->table('customer_to_education');
        $builder->select();
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }

    public function deleteCustomerEducation($education_id)
    {
        $builder = $this->db->table('customer_to_education');
        $builder->delete(['education_id' => $education_id]);
    }

    public function getUniversities($data = [])
    {
        $builder = $this->db->table('university');
        $builder->select();

        if (isset($data['filter_university'])) {
            $builder->like('text', $data['filter_university'], 'after');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getMajors($data = [])
    {
        $builder = $this->db->table('university_majors');
        $builder->select();

        if (isset($data['filter_major'])) {
            $builder->like('text', $data['filter_major'], 'after');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    // ------ Skills ------ Categories//

    public function addCustomrSkill($data)
    {
        $builder = $this->db->table('customer_to_category');
        $data = [
          'category_id'      => $data['category_id'],
          'freelancer_id' => $data['freelancer_id'],
        ];
        $builder->delete(['category_id' => $data['category_id']]);
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($data);
    }

    public function getCustomerSkills($customer_id, $start = 0, $limit = 20)
    {
        $builder = $this->db->table('customer_to_category c2c');

        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }

        $builder->select('cd.name, c2c.freelancer_id, c2c.category_id as skill_id');
        $builder->join('category_description cd', 'c2c.category_id = cd.category_id', 'left');
        $builder->where('c2c.freelancer_id', $customer_id);
        $builder->where('cd.language_id', service('registry')->get('config_language_id'));
        $builder->orderBy('cd.name', 'DESC');
        $builder->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalSkillsByCustomerID($freelancer_id)
    {
        $builder = $this->db->table('customer_to_category');
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }
    
    public function deleteCustomerSkill($category_id)
    {
        $builder = $this->db->table('customer_to_category');
        $builder->delete(['category_id' => $category_id]);
    }
    
    // ------ Languages ------ //
    public function getLanguages($data = [])
    {
        $builder = $this->db->table('languages');
        $builder->select();

        if (isset($data['filter_language'])) {
            $builder->like('text', $data['filter_language'], 'after');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function addCustomerLanguage($data)
    {
        $builder = $this->db->table('customer_to_language');
        $data = [
          'language_id' => $data['language_id'],
          'freelancer_id'   => $data['freelancer_id'],
          'level'       => $data['language_level'],
          
        ];
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($data);
    }

    public function getCustomerLanguages($freelancer_id, $start = 0, $limit = 20)
    {
        $builder = $this->db->table('customer_to_language s2l');
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }

        $builder->select('l.text as name, s2l.level, s2l.freelancer_id, s2l.language_id');
        $builder->join('languages l', 'l.language_id = s2l.language_id', 'LEFT');
        $builder->where('s2l.freelancer_id', $freelancer_id);
        $builder->orderBy('l.text', 'DESC');
        $builder->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalLanguagesByCustomerId($freelancer_id)
    {
        $builder = $this->db->table('customer_to_language');
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }

    public function deleteCustomerLanguage($language_id)
    {
        $builder = $this->db->table('customer_to_language');
        $builder->delete(['language_id' => $language_id]);
    }

    public function updateViewed(int $customer_id)
    {
        $builder = $this->db->table('customer');
        $builder->where('customer_id', $customer_id);
        $builder->set('viewed', 'viewed+1', false);
        $builder->update();
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

    public function editPassword($email, $password) {
        $builder = $this->db->table($this->table);
        $builder->where('email', $email);
        $builder->set('password', password_hash($password, PASSWORD_BCRYPT));
        $builder->update();
    }

    public function getCustomerByCode($code) {
        $builder = $this->db->table($this->table);
        $builder->select('customer_id, firstname, lastname, email');
        $builder->where('code', $code);
        $builder->where('code !=', '');
        $query = $builder->get();
        return $query->getRowArray();
    }


    public function getTotalCustomersByEmail($email)
    {
        $builder = $this->db->table($this->table);
        $builder->selectCount('*', 'total');
        $builder->where('email', $email);
        $query = $builder->get();
        $row = $query->getRowArray();
        return $row['total'];
    }
    

    // -----------------------------------------------------------------
}
