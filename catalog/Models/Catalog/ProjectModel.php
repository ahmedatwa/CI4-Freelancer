<?php namespace Catalog\Models\Catalog;

class ProjectModel extends \CodeIgniter\Model
{
    protected $table          = 'project';
    protected $primaryKey     = 'project_id';
    protected $returnType     = 'array';

    public function getProjects(array $data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, pd.description, p.status, p.date_added, p.budget_min, p.budget_max, p.type, p.date_added, pd.tags');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('project_to_category p2c', 'p.project_id = p2c.project_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));
       
        if (isset($data['category_id'])) {
            $builder->where('p2c.category_id', $data['category_id']);
        }

        //  if (isset($data['filter'])) {
        //     $builder->whereIn('sc.level', (array)$data['filter']);
        //     $builder->orWhereIn('s.delivery_time', (array)$data['filter']);
        //  }

        // if (isset($data['filter_price'])) {
        //     $price = explode(',', $data['filter']);
        //     $builder->where(['p.budget_min >=' => $price[0], 'p.budget_max <=' => $price[1]]);
        // }

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

    public function getProject($project_id)
    {
        $builder = $this->db->table('project p');
        $builder->select('AVG(pr.rating) AS total, p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.date_end, CONCAT(c.firstname, " ", c.lastname) AS employer, p.employer_id');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('project_review pr', 'p.project_id = pr.project_id', 'left');
        $builder->join('customer c', 'p.employer_id = c.customer_id', 'left');
        $builder->where('p.project_id', $project_id);
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getSkillsByProjectId($project_id)
    {
        $builder = $this->db->table('project_to_skill p2s');
        $builder->select('s.text');
        $builder->join('skills s', 'p2s.skill_id = s.skill_id', 'left');
        $builder->where('project_id', $project_id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getSkills(array $data = [])
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

    public function updateViewed(int $project_id)
    {
        $builder = $this->db->table('project');
        $builder->where('project_id', $project_id);
        $builder->set('viewed', 'viewed+1', false);
        $builder->update();
    }

    // -----------------------------------------------------------------
}
