<?php namespace Admin\Models\Catalog;

class ProjectModel extends \CodeIgniter\Model
{
    protected $table          = 'project';
    protected $primaryKey     = 'project_id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    protected $allowedFields = ['status_id'];
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data'])) {
            $data['id'] = [
                'key'   => 'project_id',
                'value' => $data['id']
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'project_add', $data['id'], $data['data']);
        }
        return $data;
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $data['id'] = [
                'key' => 'project_id',
                'value' => $data['id'][0]
            ];
            
        \CodeIgniter\Events\Events::trigger('user_activity_update', 'project_edit', $data['id'], $data['data']);
        }
        return $data;
    }


    public function getProjects(array $data = [])
    {
        $builder = $this->db->table('project');
        $builder->select('project.project_id, project_description.name AS name, project.status_id, project.date_added, project.budget_min, project.budget_max, project.type, project_status.name as status');
        $builder->join('project_description', 'project.project_id = project_description.project_id', 'left');
        $builder->join('project_status', 'project.status_id = project_status.status_id', 'left');
        $builder->where('project_description.language_id', (int) service('registry')->get('config_language_id'));

        if (!empty($data['filter_date_added'])) {
            $builder->where('project.date_added', 'DATE("' . $data['filter_date_added'] .'")');
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('project_description.name', 'DESC');
        } else {
            $builder->orderBy('project_description.name', 'ASC');
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

    public function getProject($project_id)
    {
        $builder = $this->db->table('project i');

        $builder->select();
        $builder->join('project_description id', 'i.project_id = id.project_id', 'LEFT');
        $builder->where('i.project_id', $project_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getProjectDescription($project_id)
    {
        $builder = $this->db->table('project_description');

        $project_description_data = [];
        
        $builder->select();
        $builder->where('project_id', $project_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $project_description_data[$result['language_id']] = [
                'name'             => $result['name'],
                'description'      => $result['description'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
            ];
        }
        return $project_description_data;
    }
    
    public function addProject($data)
    {
        $builder = $this->db->table($this->table);
        $project_data = array(
            'sort_order' => $data['sort_order'],
            'status'     => $data['status'],
            'type'       => $data['type'],
            'image'      => $data['image'],
            'employer_id'=> $data['employer_id'],
        );

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($project_data);
        // Get Last Inserted ID
        $project_id = $this->db->insertID();

        // project_description Query
        if (isset($data['project_description'])) {
            $project_description_table = $this->db->table('project_description');
            $seo_url = $this->db->table('seo_url');
            $seo_url->delete(['query' => 'project_id=' . $project_id]);
            foreach ($data['project_description'] as $language_id => $value) {
                $project_description = [
                    'project_id'       => $project_id,
                    'language_id'      => $language_id,
                    'name'             => $value['name'],
                    'description'      => $value['description'],
                    'meta_title'       => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keyword'     => $value['meta_keyword'],
                    'tags'             => $value['tags'],
                ];
                $project_description_table->insert($project_description);
                //  Seo Urls
                $seo_url_data = [
                        'site_id'     => 0,
                        'language_id' => $language_id,
                        'query'       => 'project_id=' . $project_id,
                        'keyword'     => generateSeoUrl($value['name']),
                    ];
                $seo_url->insert($seo_url_data);
            }
        }
    }
    
    public function editProject($project_id, $data)
    {
        $builder = $this->db->table($this->table);
        $project_data = array(
            'sort_order' => $data['sort_order'],
            'status'     => $data['status'],
            'type'       => $data['type'],
            'image'      => $data['image'],
            'employer_id'=> $data['employer_id'],
        );
        
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('project_id', $project_id);
        $builder->update($project_data);

        // project_description Query
        if (isset($data['project_description'])) {
            $project_description_table = $this->db->table('project_description');
            $project_description_table->delete(['project_id' => $project_id]);
            $seo_url = $this->db->table('seo_url');
            foreach ($data['project_description'] as $language_id => $value) {
                $project_description_data = [
                    'project_id'       => $project_id,
                    'language_id'      => $language_id,
                    'name'             => $value['name'],
                    'description'      => $value['description'],
                    'meta_title'       => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keyword'     => $value['meta_keyword'],
                    'tags'             => $value['tags'],
                ];
                $project_description_table->insert($project_description_data);
                //  Seo Urls
                $seo_url->delete(['language_id' => $language_id, 'query' => 'project_id=' . $project_id]);
                $seo_url_data = [
                        'site_id'     => 0,
                        'language_id' => $language_id,
                        'query'       => 'project_id=' . $project_id,
                        'keyword'     => generateSeoUrl($value['name']),
                    ];
                $seo_url->insert($seo_url_data);
            }
        }
    }

    public function deleteProject($project_id)
    {
        $builder = $this->db->table($this->table);
        $builder->delete(['project_id' => $project_id]);

        $builderDescription = $this->db->table('project_description');
        $builderDescription->delete(['project_id' => $project_id]);
        //  seo_url
        $seo_url = $this->db->table('seo_url');
        $seo_url->delete(['language_id' => $language_id, 'query' => 'project_id=' . $project_id]);
    }

    public function getTotalProjects($data = array())
    {
        $builder = $this->db->table('project');
        $builder->select('project.project_id, project_description.name AS name, project.status_id, project.date_added, project.budget_min, project.budget_max, project.type');
        $builder->join('project_description', 'project.project_id = project_description.project_id', 'left');
        $builder->where('project_description.language_id', (int) service('registry')->get('config_language_id'));

        if (!empty($data['filter_date_added'])) {
            $builder->where('project.date_added', 'DATE("' . $data['filter_date_added'] .'")');
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('project_description.name', 'DESC');
        } else {
            $builder->orderBy('project_description.name', 'ASC');
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

    public function getFreelancerByProjectId($project_id)
    {
        $builder = $this->db->table('customer c');
        $builder->select();
        //$builder->join('project p', 'c.customer_id = p.freelancer_id', 'left');
        //$builder->where('project_id', $project_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        if ($row) {
            return $row['firstname'] . " " . $row['lastname'];
        } else {
            return '';
        }
    }

    public function getEmployerByProjectId($project_id)
    {
        $builder = $this->db->table('customer c');
        $builder->select();
        $builder->join('project p', 'c.customer_id = p.employer_id', 'left');
        $builder->where('project_id', $project_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        if ($row) {
            return $row['firstname'] . " " . $row['lastname'];
        } else {
            return '';
        }
    }

    public function getBidsByProjectId($project_id)
    {
        $builder = $this->db->table('project_to_bid p2d');
        $builder->select('CONCAT(c.firstname, " ", c.lastname) AS freelancer, p2d.quote, p2d.text, p2d.date_start, p2d.date_end');
        $builder->join('customer c', 'p2d.freelancer_id = c.customer_id', 'left');
        $builder->where('p2d.project_id', $project_id);
       
        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('p2d.date_end', 'DESC');
        } else {
            $builder->orderBy('p2d.date_end', 'ASC');
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


    // -----------------------------------------------------------------
}
