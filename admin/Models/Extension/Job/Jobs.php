<?php namespace Admin\Models\Extension\Job;

class Jobs extends \CodeIgniter\Model
{
    protected $table          = 'job';
    protected $primaryKey     = 'job_id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        }
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        }
    }


	public function getJobs(array $data = [])
    {
		$builder = $this->db->table('job j');
        $builder->select('j.job_id, jd.name AS name, j.status, j.date_added, j.salary, CONCAT(c.firstname, " ",c.lastname) AS employer, j.type');
        $builder->join('job_description jd', 'j.job_id = jd.job_id', 'LEFT');
        $builder->join('customer c', 'j.employer_id = c.customer_id', 'LEFT');
        $builder->where('c.customer_id !=', 0);
       
        if (!empty($data['filter_date_added'])) {
            $builder->where('p.date_added', $data['filter_date_added']);
        }

        $sorting_data = array(
            'jd.name',
        );

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
        $builder->select();
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getJobDescription($job_id)
    {
        $job_description = array();
        
        $builder = $this->db->table('job_description');
        $builder->select();
        $builder->where('job_id', $job_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
             $job_description = array(
                'name'             => $result['name'],
                'description'      => $result['description'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
             );
         }
         return $job_description;
    }
	
    public function addJob($data)
    {
        $builder = $this->db->table($this->table);
        $job_data = array(
            'sort_order' => $data['sort_order'],
            'status'     => $data['status'],
            'type'       => $data['type'],
            'salary'     => $data['salary'],
            'employer_id'=> $data['employer_id'],
        );

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($job_data);
        // Get Last Inserted ID
        $job_id = $this->db->insertID();

        // job_description Query
        if (isset($data['job_description'])) {
            $job_description_table = $this->db->table('job_description');
                $job_description_data = array(
                    'job_id'           => $job_id,
                    'name'             => $data['job_description']['name'],
                    'description'      => $data['job_description']['description'],
                    'meta_title'       => $data['job_description']['meta_title'],
                    'meta_description' => $data['job_description']['meta_description'],
                    'meta_keyword'     => $data['job_description']['meta_keyword'],
                );
                $job_description_table->insert($job_description_data);
        }
        // Seo Url
        if (isset($data['seo_url'])) {
            $seo_url = $this->db->table('seo_url');
            foreach ($data['seo_url'] as $language_id => $keyword) {
                if (!empty($keyword)) {
                    $seo_url_data = array(
                            'site_id'     => 0,
                            'language_id' => $language_id,
                            'query'       => 'job_id=' . $job_id,
                            'keyword'     => $keyword,
                        );
                    $seo_url->insert($seo_url_data);
                }
            }
        }
    }
    
    public function editJob($job_id, $data)
    {
        $builder = $this->db->table($this->table);
        $job_data = array(
            'sort_order' => $data['sort_order'],
            'status'     => $data['status'],
            'type'       => $data['type'],
            'salary'     => $data['salary'],
            'employer_id'=> $data['employer_id'],

        );
        
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('job_id', $job_id);
        $builder->update($job_data);

        // job_description Query
        if (isset($data['job_description'])) {
            $job_description_table = $this->db->table('job_description');
            $job_description_table->delete(['job_id' => $job_id]);
                $job_description_data = array(
                    'job_id'           => $job_id,
                    'name'             => $data['job_description']['name'],
                    'description'      => $data['job_description']['description'],
                    'meta_title'       => $data['job_description']['meta_title'],
                    'meta_description' => $data['job_description']['meta_description'],
                    'meta_keyword'     => $data['job_description']['meta_keyword'],
                );
            $job_description_table->insert($job_description_data);
        }
        // Seo Url
        if (isset($data['seo_url'])) {
            $seo_url = $this->db->table('seo_url');
            foreach ($data['seo_url'] as $language_id => $keyword) {
                if (!empty($keyword)) {
                    $seo_url_data = array(
                            'site_id'     => 0,
                            'language_id' => $language_id,
                            'query'       => 'job_id=' . $job_id,
                            'keyword'     => $keyword,
                        );
                    $seo_url->insert($seo_url_data);
                }
            }
        }
    }

	public function deleteJob($job_id)
    {
		$builder = $this->db->table($this->table);
		$builder->delete(['job_id' => $job_id]);

		$builder_description = $this->db->table('job_description');
        $builder_description->delete(['job_id' => $job_id]);
    }




    // -----------------------------------------------------------------
}
