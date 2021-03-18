<?php

namespace Catalog\Models\Freelancer;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class FreelancerModel extends Model
{
    protected $table         = 'project_bids';
    protected $primaryKey    = 'bid_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['customer_id', 'amount', 'currency', 'status_id'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    public function getFreelancers(array $data = [])
    {
        $builder = $this->db->table('customer c');
        $builder->select('CONCAT(c.firstname, " ", c.lastname) AS name, c.about, c.tag_line, c.image, c.customer_id, c.rate, c.online, c.username');
        $builder->join('customer_to_category c2c', 'c.customer_id = c2c.freelancer_id', 'left');

        if (isset($data['filter_freelancer'])) {
            $builder->where('c.profile_strength', $data['filter_freelancer']);
        }

        if (isset($data['filter_skills']) && !empty($data['filter_skills'])) {
            $builder->whereIn('c2c.category_id', $data['filter_skills']);
        }

        if (isset($data['filter_country'])) {
            $builder->where('c.country_id', $data['filter_country']);
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

        $builder->groupBy('c.customer_id');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalFreelancers(array $data = [])
    {
        $builder = $this->db->table('customer c');
        $builder->select('CONCAT(c.firstname, " ", c.lastname) AS name, c.about, c.tag_line, c.image, c.customer_id, c.rate, c.online, c.username');
        $builder->join('customer_to_category c2c', 'c.customer_id = c2c.freelancer_id', 'left');

        if (isset($data['filter_freelancer'])) {
            $builder->where('c.profile_strength', $data['filter_freelancer']);
        }

        if (isset($data['filter_skills']) && !empty($data['filter_skills'])) {
            $builder->whereIn('c2c.category_id', $data['filter_skills']);
        }

        if (isset($data['filter_country'])) {
            $builder->where('c.country_id', $data['filter_country']);
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

        $builder->groupBy('c.customer_id');

        return $builder->countAllResults();
    }

    public function getFreelancer(string $username = '', int $customer_id = 0)
    {
        $builder = $this->db->table('customer');
        if ($customer_id != 0) {
            $builder->where('customer_id', $customer_id);
        } else {
            $builder->where('username', $username);
        }
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getFreelancerProjects(array $data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.type, p.status_id, p.runtime');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('customer c', 'p.freelancer_id = c.customer_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));

        if (isset($data['freelancer_id'])) {
            $builder->where('p.freelancer_id', $data['freelancer_id']);
        }

        if (isset($data['status_id'])) {
            $builder->whereIn('p.status_id', explode('_', $data['status_id']));
        }

        if (isset($data['order']) && $data['order'] == 'DESC') {
            $orderBy = 'DESC';
        } else {
            $orderBy = 'ASC';
        }

        $sortData = [
            'p.date_added',
            'pd.name',
            'p.type',
        ];

        if (isset($data['sort']) && in_array($data['sort'], $sortData)) {
            $builder->orderBy($data['sort'], $orderBy);
        } else {
            $builder->orderBy('p.date_added', 'ASC');
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

    public function getTotalFreelancerProjects(int $freelancer_id)
    {
        $builder = $this->db->table('project');
        $builder->select();
        $builder->where('freelancer_id', $freelancer_id);
        if ($builder->countAllResults()) {
            return $builder->countAllResults();
        } else {
            return 0;
        }
    }

    public function editFreelancer(int $freelancer_id, array $data)
    {
        $builder = $this->db->table('customer');
        $builder->where('customer_id', $freelancer_id);
        if (isset($data['social']) && is_array($data['social'])) {
            $builder->set('social', json_encode($data['social']));
        } else {
            $builder->set($data['name'], $data['value']);
        }
        $builder->update();
    }

    public function editImage(string $field, int $freelancer_id, string $image)
    {
       $builder = $this->db->table('customer');
       $builder->where('customer_id', $freelancer_id);
       $builder->set($field, $image);
       $builder->update();
    }

    public function updateViewed(int $freelancer_id)
    {
        $builder = $this->db->table('customer');
        $builder->where('customer_id', $freelancer_id);
        $builder->set('viewed', 'viewed+1', false);
        $builder->update();
    }

    // -----------------------
    // Profile Section Info
    // -----------------------
    public function updateStrength(int $customer_id, int $profile_strength)
    {
        $builder = $this->db->table('customer');
        $builder->where('customer_id', $customer_id)
                ->set('profile_strength', $profile_strength)
                ->update();
    }
    /**
    * Skills
    */
    public function getSkills(array $data = [])
    {
        $builder = $this->db->table('skills');
        $builder->select();

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        if (isset($data['filter_name'])) {
            $builder->like('name', $data['filter_name'], 'after');
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getFreelancerSkills(int $freelancer_id)
    {
        $builder = $this->db->table('customer_to_category c2c');
        $builder->select('c2c.category_id, c2c.freelancer_id, cd.name')
                ->join('category_description cd', 'c2c.category_id = cd.category_id', 'left')
                ->where('c2c.freelancer_id', $freelancer_id)
                ->orderBy('c2c.category_id', 'DESC');

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function addSkill(array $data)
    {
        $builder = $this->db->table('customer_to_skill');
        foreach ($data['skills'] as $skill) {
            $builder->delete(['skill_id' => $skill]);
            $skill_data = [
                'skill_id'      => $skill,
                'freelancer_id' => $data['freelancer_id'],
            ];
            $builder->set('date_added', Time::now()->getTimestamp());
            $builder->insert($skill_data);
        }
    }

    public function getJobsDoneBySkill(int $skill_id)
    {
      $builder = $this->db->table('languages l'); 
      return $builder->countAllResults(); 
    }
    /**
    * Languages
    */
    public function getLanguages(array $data = [])
    {
        $builder = $this->db->table('languages l');
        $builder->select();

        if (isset($data['filter_language'])) {
            $builder->like('l.text', $data['filter_language'], 'after');
        }

        if (isset($data['freelancer_id'])) {
            $builder->join('customer_to_language c2l', 'l.language_id = c2l.language_id', 'LEFT')
                    ->where('c2l.freelancer_id', $data['freelancer_id']);
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

    public function addLanguage(int $language_id, int $freelancer_id, string $level)
    {
        $builder = $this->db->table('customer_to_language');
        $data = [
            'language_id'   => $language_id,
            'freelancer_id' => $freelancer_id,
            'level'         => $level,
          
        ];
        $builder->set('date_added', Time::now()->getTimestamp());
        $builder->insert($data);
    }

    public function deleteLanguage(int $language_id)
    {
        $builder = $this->db->table('customer_to_language');
        $builder->delete(['language_id' => $language_id]);
    }

    /**
    * Education
    */
    public function getEducation(int $freelancer_id, int $start = 0, int $limit = 20)
    {
        $builder = $this->db->table('customer_to_education s2e');
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }

        $builder->select('um.text AS major, u.text AS university, s2e.freelancer_id, s2e.country, s2e.title, s2e.year, s2e.education_id')
                ->join('university u', 'u.university_id = s2e.university_id', 'LEFT')
                ->join('university_majors um', 'um.major_id = s2e.major_id', 'LEFT')
                ->where('s2e.freelancer_id', $freelancer_id)
                ->orderBy('s2e.date_added', 'DESC')
                ->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    public function addEducation(int $freelancer_id, array $data)
    {
        $builder = $this->db->table('customer_to_education');
        $data = [
          'freelancer_id' => $freelancer_id,
          'university_id' => $data['university_id'],
          'major_id'      => $data['major_id'],
          'title'         => $data['major_title'],
          'year'          => $data['major_year'],
          'country'       => $data['education_country'],
        ];

        $builder->set('date_added', Time::now()->getTimestamp());
        $builder->insert($data);
    }

    public function deleteEducation(int $education_id)
    {
        $builder = $this->db->table('customer_to_education');
        $builder->delete(['education_id' => $education_id]);
    }

    public function getUniversities(array $data = [])
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

    public function getMajors(array $data = [])
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
    // ------ Education End ------ //

    // ------ Certificates Start ------ //
    public function getCertificates(int $freelancer_id, int $start = 0, int $limit = 20)
    {
        $builder = $this->db->table('customer_to_certificate');
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 20;
        }
        $builder->select()
                ->where('freelancer_id', $freelancer_id)
                ->orderBy('date_added', 'DESC')
                ->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }
    
    public function addCertificate(int $freelancer_id, string $name, string $year)
    {
        $builder = $this->db->table('customer_to_certificate');
        $data = [
          'freelancer_id' => $freelancer_id,
          'name'          => $name,
          'year'          => $year,
          'date_added'    => Time::now()->getTimestamp()
        ];
        $builder->insert($data);
    }

    public function deleteCertificate(int $certificate_id)
    {
        $builder = $this->db->table('customer_to_certificate');
        $builder->delete(['certificate_id' => $certificate_id]);
    }
    // ------ Certificates End ------ //

    // Totals
    public function getTotalCertificatesByID(int $freelancer_id)
    {
        $builder = $this->db->table('customer_to_certificate');
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }
    public function getTotalEducationByID(int $freelancer_id)
    {
        $builder = $this->db->table('customer_to_education');
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }
    public function getTotalSkillsByID(int $freelancer_id)
    {
        $builder = $this->db->table('customer_to_category');
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }
    public function getTotalLanguageByID(int $freelancer_id)
    {
        $builder = $this->db->table('customer_to_language');
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }

    // -----------------------------------------------------------------
}
