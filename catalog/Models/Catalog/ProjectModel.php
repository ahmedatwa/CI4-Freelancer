<?php namespace Catalog\Models\Catalog;

class ProjectModel extends \CodeIgniter\Model
{
    protected $table          = 'project';
    protected $primaryKey     = 'project_id';
    protected $returnType     = 'array';
    

    public function addProject($data)
    {
        $language_id = service('registry')->get('config_language_id');

        $builder = $this->db->table($this->table);
        $project_data = [
            'status'      => $data['status'],
            'type'        => $data['type'],
            //'image'     => $data['image'],
            'employer_id' => $data['employer_id'],
            'budget_min'  => $data['budget_min'],
            'budget_max'  => $data['budget_max'],
            'runtime'     => $data['runtime'],
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($project_data);
        // Get Last Inserted ID
        $project_id = $this->db->insertID();

        // project_description Query
        if (isset($data['project_description'])) {
            $project_description_table = $this->db->table('project_description');
            $seo_url = $this->db->table('seo_url');
            foreach ($data['project_description'] as $language_id => $value) {
                $project_description = [
                    'project_id'       => $project_id,
                    'language_id'      => $language_id,
                    'name'             => $value['name'],
                    'description'      => $value['description'],
                    'meta_title'       => $value['meta_title'] ?? '',
                    'meta_description' => $value['meta_description'] ?? '',
                    'meta_keyword'     => $value['meta_keyword'] ?? '',
                ];
                $project_description_table->insert($project_description);
                //  Seo Urls
                helper('text');
                $seo_url_data = [
                        'site_id'     => 0,
                        'language_id' => $language_id,
                        'query'       => 'project_id=' . $project_id,
                        'keyword'     => url_title(convert_accented_characters($value['name']), '-', true),
                    ];
                $seo_url->insert($seo_url_data);
            }
        }
        // project_categories
        if (isset($data['category_id'])) {
            $project_category_table = $this->db->table('project_to_category');
            foreach ($data['category_id'] as $category_id) {
                $project_category_data = [
                    'project_id'       => $project_id,
                    'category_id'      => $category_id,
                ];
                $project_category_table->insert($project_category_data);
            }
        }
    }
    
    public function editProject($project_id, $data)
    {
        $language_id = service('registry')->get('config_language_id');
        $builder = $this->db->table($this->table);
        $project_data = [
            'status'      => $data['status'],
            'type'        => $data['type'],
            //'image'     => $data['image'],
            'employer_id' => $data['employer_id'],
            'budget_min'  => $data['budget_min'],
            'budget_max'  => $data['budget_max'],
        ];
        
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
                    'meta_title'       => $value['meta_title'] ?? '',
                    'meta_description' => $value['meta_description'] ?? '',
                    'meta_keyword'     => $value['meta_keyword'] ?? '',
                   // 'tags'             => $value['tags'],
                ];
                $project_description_table->insert($project_description_data);
                //  Seo Urls
                $seo_url->delete(['language_id' => $language_id, 'query' => 'project_id=' . $project_id]);
                $seo_url_data = [
                        'site_id'     => 0,
                        'language_id' => $language_id,
                        'query'       => 'project_id=' . $project_id,
                        'keyword'     => url_title(convert_accented_characters($value['name']), '-', true),
                    ];
                $seo_url->insert($seo_url_data);
            }
        }
                // project_categories
        if (isset($data['category_id'])) {
            $project_category_table = $this->db->table('project_to_category');
            foreach ($data['category_id'] as $category_id) {
                $project_category_data = [
                    'project_id'       => $project_id,
                    'category_id'      => $category_id,
                ];
                $project_category_table->insert($project_category_data);
            }
        }
    }

    public function getProjects(array $data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, pd.description, p.status, p.date_added, p.budget_min, p.budget_max, p.type, p.date_added, pd.meta_keyword');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('project_to_category p2c', 'p.project_id = p2c.project_id', 'left');
        $builder->where(['pd.language_id' => service('registry')->get('config_language_id'), 'status' => 1]);
       
        if (isset($data['category_id'])) {
            $builder->where('p2c.category_id', $data['category_id']);
        }

        if (isset($data['filter_date_added'])) {
            $builder->where('DATE("p.date_added")', 'DATE("' . $data['filter_date_added'] .'")');
        }

        if (isset($data['filter_keyword'])) {
            $builder->where('pd.name', $data['filter_keyword']);
        }

        $sortData = [
            //'s.price',
            'p.date_added',
        ];

        if (isset($data['orderBy']) && $data['orderBy'] == 'DESC') {
            $data['orderBy'] = 'DESC';
        } else {
            $data['orderBy'] = 'ASC';
        }

        if (isset($data['sortBy']) && in_array($data['sortBy'], $sortData)) {
            $builder->orderBy($data['sortBy'], 'DESC');
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

    // public function getProjectKeywords($project_id)
    // {
    //     $builder = $this->db->table('project_description');
    //     $builder->select('meta_keyword');
    //     $builder->where('project_id', $project_id);
    //     $builder->where('language_id', service('registry')->get('config_language_id'));
    //     $query = $builder->get();
    //     return $query->getRowArray();
    // }
    
    // public function getProjectSkills($project_id)
    // {
    //     $builder = $this->db->table('project_to_skill p2s');

    //     $project_skills_data = [];
        
    //     $builder->select();
    //     $builder->join('skills s', 'p2s.skill_id = s.skill_id', 'left');
    //     $builder->where('p2s.project_id', $project_id);
    //     $query = $builder->get();
    //     foreach ($query->getResultArray() as $result) {
    //         $project_skills_data[] = [
    //             'skill_id'  => $result['skill_id'],
    //             'text'      => $result['text'],
    //         ];
    //     }
    //     return $project_skills_data;
    // }
    public function getProject($project_id)
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.runtime, CONCAT(c.firstname, " ", c.lastname) AS employer, p.employer_id, p.type, p.status');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('customer c', 'p.employer_id = c.customer_id', 'left');
        $builder->where(['pd.language_id', service('registry')->get('config_language_id'), 'p.project_id' => $project_id, 'p.status' => 1]);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getEmployerProjects($data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.type, p.status, p.runtime');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('customer c', 'p.employer_id = c.customer_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));

        if (isset($data['employer_id'])) {
            $builder->where('p.employer_id', $data['employer_id']);
        }

        if (isset($data['orderBy']) && $data['orderBy'] == 'DESC') {
            $data['orderBy'] = 'DESC';
        } else {
            $data['orderBy'] = 'ASC';
        }

        $sortData = ['p.date_added'];

        if (isset($data['sortBy']) && in_array($data['sortBy'], $sortData)) {
            $builder->orderBy($data['sortBy'], 'DESC');
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

    public function getAverageBidsByPorjectId($project_id)
    {
        $builder = $this->db->table('project_bids');
        $builder->select('AVG(quote) AS total');
        $builder->where('project_id', $project_id);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
    }

    public function enableProject($project_id)
    {
        $builder = $this->db->table('project');
        $builder->where('project_id', $project_id);
        $builder->set('status', 1);
        $builder->update();
    }

    public function disableProject($project_id)
    {
        $builder = $this->db->table('project');
        $builder->where('project_id', $project_id);
        $builder->set('status', 0);
        $builder->update();
    }


    // public function getSkillsByProjectId($project_id)
    // {
    //     $builder = $this->db->table('project_to_skill p2s');
    //     $builder->select();
    //     $builder->join('skills s', 'p2s.skill_id = s.skill_id', 'left');
    //     $builder->where('p2s.project_id', $project_id);
    //     $query = $builder->get();
    //      return $query->getResultArray();
    //}

    // public function getCategoriesByProjectId($project_id)
    // {
    //     $category_id = [];
    //     $builder = $this->db->table('project_to_category p2c');
    //     $builder->select();
    //     $builder->join('category c', 'p2c.category_id = c.category_id', 'left');
    //     $builder->where('p2c.project_id', $project_id);
    //     $query = $builder->get();
    //     foreach ($query->getResultArray() as $result) {
    //         $category_id[] = $result['category_id'];
    //      }
    //      return $category_id;
    // }


    public function getTotalProjects()
    {
        $builder = $this->db->table('project p');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));
       
        if (!empty($data['filter_date_added'])) {
            $builder->where('DATE("p.date_added")', 'DATE("' . $data['filter_date_added'] .'")');
        }

        $sortData = [
            ''
        ];

        if (isset($data['orderBy']) && $data['orderBy'] == 'DESC') {
            $data['orderBy'] = 'DESC';
        } else {
            $data['orderBy'] = 'ASC';
        }

        if (isset($data['sortBy']) && in_array($data['sortBy'], $sortData)) {
            $builder->orderBy($data['sortBy'], $data['orderBy']);
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

        return $builder->countAllResults();
    }

    public function getProjectAward($data = [])
    {
        $builder = $this->db->table('project_to_award p2a');
        $builder->select('p2a.project_id, pd.name, p2a.delivery_time, p2a.status, p2a.employer_id, p2a.freelancer_id');
        $builder->join('project_description pd', 'p2a.project_id = pd.project_id', 'left');

        if (isset($data['status'])) {
            $builder->where('p2a.status', $data['status']);
        }

        if (isset($data['orderBy']) && $data['orderBy'] == 'DESC') {
            $data['orderBy'] = 'DESC';
        } else {
            $data['orderBy'] = 'ASC';
        }

        $sortData = ['p2a.date_added'];

        if (isset($data['sortBy']) && in_array($data['sortBy'], $sortData)) {
            $builder->orderBy($data['sortBy'], 'DESC');
        } else {
            $builder->orderBy('p2a.date_added', 'ASC');
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

    public function updateViewed(int $project_id)
    {
        $builder = $this->db->table('project');
        $builder->where('project_id', $project_id);
        $builder->set('viewed', 'viewed+1', false);
        $builder->update();
    }

    public function getTotalBidsByProjectId($project_id)
    {
        $builder = $this->db->table('project_bids');
        $builder->where('project_id', $project_id);
        return $builder->countAllResults();
    }

    // -----------------------------------------------------------------
}
