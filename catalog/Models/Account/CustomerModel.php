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
    protected $afterUpdate    = ['afterUpdateEvent'];
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

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['id'])) {
            \CodeIgniter\Events\Events::trigger('customer_update', $data['id'][0]);
        }
        return $data;
    }

    public function addCustomer($data)
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
    public function addLoginAttempt($email, $ipAddress)
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
          'name'          => $data['certificate_name'],
          'year'          => $data['certificate_year'],
        ];

        $builder->set('date_added', Time::now()->getTimestamp());
        $builder->insert($data);
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

        $builder->set('date_added', Time::now()->getTimestamp());
        $builder->insert($data);
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
        $builder->set('date_added', Time::now()->getTimestamp());
        $builder->insert($data);
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

    public function addCustomerLanguage($data)
    {
        $builder = $this->db->table('customer_to_language');
        $data = [
          'language_id' => $data['language_id'],
          'freelancer_id'   => $data['freelancer_id'],
          'level'       => $data['language_level'],
          
        ];
        $builder->set('date_added', Time::now()->getTimestamp());
        $builder->insert($data);
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

    public function editPassword($email, $password)
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


    public function getTotalCustomersByEmail($email)
    {
        $builder = $this->db->table($this->table);
        $builder->selectCount('*', 'total');
        $builder->where('email', $email);
        $row = $builder->get()->getRowArray();
        return $row['total'];
    }

    // for Dahsboard Widget
    public function getTotalProjectsByCustomerId($customer_id)
    {
        $builder = $this->db->table('project');
        $builder->where('employer_id', $customer_id);
        return $builder->countAllResults();
    }

    public function getBalanceByMonth($customer_id)
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
