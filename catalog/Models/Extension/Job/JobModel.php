<?php namespace Catalog\Models\Extension\Job;

class JobModel extends \CodeIgniter\Model
{
    protected $table          = 'job';
    protected $primaryKey     = 'job_id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    // should use for keep data record create timestamp
    protected $allowedFields = ['status'];

    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function getJobs(array $data = [])
    {
        $builder = $this->db->table('job j');
        $builder->select('j.job_id, jd.name AS name, j.status, j.date_added, j.salary, j.status, jd.description, jd.meta_keyword, CONCAT(c.firstname, " ",c.lastname) AS employer, j.type');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'LEFT');
        $builder->join('customer c', 'j.employer_id = c.customer_id', 'LEFT');
        $builder->where('c.customer_id !=', 0)->where('j.status !=', 0);
       
        // filter Job Types
        if (!empty($data['filter_type'])) {
            $builder->whereIn('j.type', $data['filter_type']);
        }

        // filter Job Tags
        if (!empty($data['tags'])) {
            $builder->where('jd.meta_keyword', $data['tags']);
        }

        // search
        if (!empty($data['filter_keyword'])) {
            $builder->where('jd.meta_keyword', $data['filter_keyword']);
        }

        $sorting_data = [
            'jd.name',
            'j.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function getJob($job_id)
    {
        $builder = $this->db->table('job j');
        $builder->select('*, CONCAT(c.firstname, " ",c.lastname) AS employer');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'LEFT');
        $builder->join('customer c', 'j.employer_id = c.customer_id', 'LEFT');
        $builder->where('j.job_id', $job_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addJob(array $data)
    {
        $builder = $this->db->table($this->table);
        $job_data = [
            'sort_order' => $data['sort_order'] ?? 0,
            'status'     => $data['status'] ?? 1,
            'type'       => $data['type'],
            'salary'     => $data['salary'] ?? 0,
            'employer_id'=> $data['customer_id'],
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($job_data);
        // Get Last Inserted ID
        $jobID = $this->db->insertID();

        // job_description Query
        if (isset($data['job_description'])) {
            $job_description_table = $this->db->table('job_description');
            $job_description_table->delete(['job_id' => $jobID]);
            $job_description_data = [
                    'job_id'           => $jobID,
                    'name'             => $data['job_description']['name'],
                    'description'      => $data['job_description']['description'],
                    'meta_title'       => $data['job_description']['meta_title'] ?? '',
                    'meta_description' => $data['job_description']['meta_description'] ?? '',
                    'meta_keyword'     => $data['job_description']['meta_keyword'] ?? '',
                ];
            $job_description_table->insert($job_description_data);
        }
        // Seo Url
    }
    
    public function editJob($job_id, $data)
    {
        $builder = $this->db->table($this->table);
        $job_data = [
            'sort_order' => $data['sort_order'],
            'status'     => $data['status'],
            'type'       => $data['type'],
            'salary'     => $data['salary'],
            'employer_id'=> $data['employer_id'],

        ];
        
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('job_id', $job_id);
        $builder->update($job_data);

        // job_description Query
        if (isset($data['job_description'])) {
            $job_description_table = $this->db->table('job_description');
            $job_description_table->delete(['job_id' => $job_id]);
            $job_description_data = [
                    'job_id'           => $job_id,
                    'name'             => $data['job_description']['name'],
                    'description'      => $data['job_description']['description'],
                    'meta_title'       => $data['job_description']['meta_title'],
                    'meta_description' => $data['job_description']['meta_description'],
                    'meta_keyword'     => $data['job_description']['meta_keyword'],
                ];
            $job_description_table->insert($job_description_data);
        }
        // Seo Url
    }

    public function deleteJob($job_id)
    {
        $builder = $this->db->table($this->table);
        $builder->delete(['job_id' => $job_id]);

        $builder_description = $this->db->table('job_description');
        $builder_description->delete(['job_id' => $job_id]);
    }

    public function getTotalJobs(array $data = [])
    {
        $builder = $this->db->table('job j');
        $builder->select('j.job_id, jd.name AS name, j.status, j.date_added, j.salary, j.status, jd.description, jd.meta_keyword, CONCAT(c.firstname, " ",c.lastname) AS employer, j.type');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'LEFT');
        $builder->join('customer c', 'j.employer_id = c.customer_id', 'LEFT');
        $builder->where('c.customer_id !=', 0)->where('j.status !=', 0);
       
        // filter Job Types
        if (!empty($data['filter_type'])) {
            $builder->whereIn('j.type', $data['filter_type']);
        }

        // filter Job Tags
        if (!empty($data['tags'])) {
            $builder->where('jd.meta_keyword', $data['tags']);
        }

        // search
        if (!empty($data['filter_keyword'])) {
            $builder->where('jd.meta_keyword', $data['filter_keyword']);
        }

        $sorting_data = [
            'jd.name',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function insertApplicant(array $data)
    {
        $builder = $this->db->table('job_applicants');
        $applicant_data = [
        'customer_id' => $data['customer_id'],
        'job_id'      => $data['job_id'],
        'download_id' => $data['download_id'],
        'status'      => 1
    ];
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($applicant_data);
    }

    public function getApplicantJobs(array $data)
    {
        $builder = $this->db->table('job j');
        $builder->select('j.job_id, j.employer_id, jd.name, j.status, ja.date_added, j.salary, j.status, CONCAT(c.firstname, " ",c.lastname) AS customer, j.type');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'left');
        $builder->join('job_applicants ja', 'j.job_id = ja.job_id', 'left');
        $builder->join('customer c', 'ja.customer_id = c.customer_id', 'left');

        if (!empty($data['customer_id'])) {
            $builder->where('ja.customer_id', $data['customer_id']);
        }

        $sorting_data = [
            'j.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function getTotalApplicantJobs(array $data)
    {
        $builder = $this->db->table('job j');
        $builder->select('j.job_id, jd.name, j.status, ja.date_added, j.salary, j.status, CONCAT(c.firstname, " ",c.lastname) AS customer, j.type');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'left');
        $builder->join('job_applicants ja', 'j.job_id = ja.job_id', 'left');
        $builder->join('customer c', 'ja.customer_id = c.customer_id', 'left');

        if (!empty($data['customer_id'])) {
            $builder->where('ja.customer_id', $data['customer_id']);
        }

        $sorting_data = [
            'j.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function getRecruiterJobs(array $data)
    {
        $builder = $this->db->table('job j');
        $builder->select('j.job_id, jd.name, j.employer_id, j.status, j.date_added, j.salary, j.status, CONCAT(c.firstname, " ",c.lastname) AS customer, j.type');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'left');
        $builder->join('customer c', 'j.employer_id = c.customer_id', 'left');

        if (!empty($data['customer_id'])) {
            $builder->where('j.employer_id', $data['customer_id']);
        }

        $sorting_data = [
            'j.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function getTotalRecruiterJobs(array $data)
    {
        $builder = $this->db->table('job j');
        $builder->select('j.job_id, jd.name, j.status, ja.date_added, j.salary, j.status, CONCAT(c.firstname, " ",c.lastname) AS customer, j.type');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'left');
        //$builder->join('customer c', 'ja.customer_id = c.customer_id', 'left');

        if (!empty($data['customer_id'])) {
            $builder->where('j.employer_id', $data['customer_id']);
        }

        $sorting_data = [
            'j.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function getJobCandidates(array $data)
    {
        $builder = $this->db->table('job j');
        $builder->select('ja.job_id, ja.job_applicant_id, ja.date_added, ja.status, CONCAT(c.firstname, " ",c.lastname) AS name, j.type, c.email, ja.download_id');
        $builder->join('job_applicants ja', 'j.job_id = ja.job_id', 'left');
        $builder->join('customer c', 'ja.customer_id = c.customer_id', 'left');

        if (!empty($data['job_id'])) {
            $builder->where('j.job_id', $data['job_id']);
        }
        if (!empty($data['employer_id'])) {
            $builder->where('j.employer_id', $data['employer_id']);
        }

        $sorting_data = [
            'ja.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function getTotalJobCandidates()
    {
        $builder = $this->db->table('job j');
        $builder->select('j.job_id, jd.name, j.status, ja.date_added, j.salary, j.status, CONCAT(c.firstname, " ",c.lastname) AS customer, j.type');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'left');
        $builder->join('job_applicants ja', 'j.job_id = ja.job_id', 'left');
        $builder->join('customer c', 'ja.customer_id = c.customer_id', 'left');

        if (!empty($data['customer_id'])) {
            $builder->where('j.employer_id', $data['customer_id']);
        }

        $sorting_data = [
            'j.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function getTotalApplicantsByJobID(int $job_id)
    {
        $builder = $this->db->table('job_applicants');
        $builder->where('job_id', $job_id);
        return $builder->countAllResults();
    }

    public function getJobNameByID(int $job_id)
    {
        $builder = $this->db->table('job_description');
        $builder->where('job_id', $job_id);
        $row = $builder->get()->getRowArray();
        return $row['name'];
    }

    public function alreadyApplied(int $customer_id)
    {
        $builder = $this->db->table('job_applicants');
        $builder->where('customer_id', $customer_id);
        if ($builder->countAllResults() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function setApplicantStatus(int $job_applicant_id, int $status)
    {
        $builder = $this->db->table('job_applicants');
        $builder->where('job_applicant_id', $job_applicant_id);
        $builder->set('status', $status);
        $builder->update();
    }

    // -----------------------------------------------------------------
}
