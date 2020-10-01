<?php namespace Catalog\Models\Account;

class CustomerModel extends \CodeIgniter\Model
{
    protected $table          = 'customer';
    protected $primaryKey     = 'customer_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['customer_group_id', 'email', 'password'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // Password Hashing Events
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
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
            'username'          => explode('@', $data['email'])[0],
            'email'             => $data['email'],
            'password'          => password_hash($data['password'], PASSWORD_BCRYPT),
            'customer_group_id' => 1,
            'status'            => 0,
        ];
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($customer_data);
        \CodeIgniter\Events\Events::trigger('customer_register', $this->db->insertID(), explode('@', $data['email'])[0]);
        //\CodeIgniter\Events\Events::trigger('mail_customer_add', $data['email']);
    }

    public function getCustomer($customer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function editCode($email, $code)
    {
        $builder = $this->db->table($this->table);
        $builder->where('email', $email);
        $builder->set('code', $code);
        $builder->update();
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

        $builder->select('m.text AS major, u.text AS university, s2e.freelancer_id, s2e.country, s2e.title, s2e.year, s2e.education_id');
        $builder->join('university u', 'u.university_id = s2e.university_id', 'LEFT');
        $builder->join('majors m', 'm.major_id = s2e.major_id', 'LEFT');
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
        $builder = $this->db->table('majors');
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

    // ------ Skills ------ //
    public function getSkills($data = [])
    {
        $builder = $this->db->table('skills');
        $builder->select();

         if (isset($data['filter_skill'])) {
            $builder->like('text', $data['filter_skill'], 'after');
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

    public function addCustomrSkill($data)
    {
        $builder = $this->db->table('customer_to_skill');
        $data = [
          'skill_id'      => $data['skill_id'],
          'freelancer_id' => $data['freelancer_id'],
          'level'         => $data['skill_level']
        ];

        $builder->set('date_added', 'NOW()', FALSE);
        $builder->insert($data);
    }

    public function getCustomerSkills($freelancer_id, $start = 0, $limit = 20)
    {
        $builder = $this->db->table('customer_to_skill s2s');
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }

        $builder->select('s.text as name, s2s.level, s2s.freelancer_id, s2s.skill_id');
        $builder->join('skills s', 's.skill_id = s2s.skill_id', 'left');
        $builder->where('s2s.freelancer_id', $freelancer_id);
        $builder->orderBy('s.text', 'DESC');
        $builder->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalSkillsByCustomerID($freelancer_id)
    {
        $builder = $this->db->table('customer_to_skill');
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }
    
    public function deleteCustomerSkill($skill_id)
    {
         $builder = $this->db->table('customer_to_skill');
         $builder->delete(['skill_id' => $skill_id]);
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
        $builder->set('date_added', 'NOW()', FALSE);
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

    // -----------------------------------------------------------------
}
