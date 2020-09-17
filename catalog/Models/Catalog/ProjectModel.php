<?php namespace Catalog\Models\Catalog;

class ProjectModel extends \CodeIgniter\Model
{
    protected $table          = 'project';
    protected $primaryKey     = 'project_id';
    protected $returnType     = 'array';
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data']['name'])) {
            \CodeIgniter\Events\Events::trigger('project_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('project_add', $this->db->insertID(), $data['data']['name']);
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


    public function getProjects(array $data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, pd.description, p.status, p.date_added, p.price, p.type, p.date_added, pd.tags');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));
       
        if (!empty($data['filter_date_added'])) {
            $builder->where('DATE("p.date_added")', 'DATE("' . $data['filter_date_added'] .'")');
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('p.date_added', 'DESC');
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

    public function getProjectByID($project_id)
    {
        $builder = $this->db->table('project p');
        $builder->select();
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->where('p.project_id', $project_id);
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));
        $query = $builder->get();
        return $query->getRowArray();
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

        if (isset($data['sortBy']) && in_array($data['sortBy'], $sorting_data)) {
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
    public function updateViewed($project_id)
    {
        $builder = $this->db->table('project');
        $$builder->where('project_id', $project_id);
        $$builder->set('viewed', 'viewed+1', false);
        $$builder>update('project');
    }

    // -----------------------------------------------------------------
}
