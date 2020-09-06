<?php namespace Catalog\Models\Catalog;

use CodeIgniter\Model;

class Projects extends Model
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
        $builder->select('p.project_id, pd.name AS name, p.status, p.date_added, p.price, CONCAT(e.firstname, " ",e.lastname) AS employer, CONCAT(f.firstname, " ",f.lastname) AS freelancer, p.type');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'LEFT');
        $builder->join('employer e', 'p.employer_id = e.employer_id', 'LEFT');
        $builder->join('freelancer f', 'p.freelancer_id = f.freelancer_id', 'LEFT');
        $builder->where('e.employer_id !=', 0);
        $builder->where('f.freelancer_id !=', 0);
        $builder->where('pd.language_id', getSettingValue('config_language_id'));
       
        if (!empty($data['filter_date_added'])) {
            $builder->where('DATE("p.date_added")', 'DATE("' . $data['filter_date_added'] .'")');
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('pd.name', 'DESC');
        } else {
            $builder->orderBy('pd.name', 'ASC');
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
