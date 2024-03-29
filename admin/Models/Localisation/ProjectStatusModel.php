<?php namespace Admin\Models\Localisation;

use CodeIgniter\Model;

class ProjectStatusModel extends Model
{
    protected $table          = 'project_status';
    protected $primaryKey     = 'status_id';
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

    public function addProjectStatus(array $data)
    {
        $builder = $this->db->table($this->table);
        foreach ($data['project_status'] as $language_id => $value) {
            $project_status_data = [
                'language_id' => $language_id,
                'name' => $value
            ];
        $builder->insert($project_status_data);
        }
    }


    public function editprojectStatus(int $status_id, array $data)
    {
        $builder = $this->db->table($this->table);
        $builder->delete(['status_id' => $status_id]);
        foreach ($data['project_status'] as $language_id => $value) {
            $project_status_data = [
                'language_id' => $language_id,
                'name' => $value
            ];
        $builder->insert($project_status_data);
        }
    }

     public function getProjectStatusDescriptions(int $status_id)
     {
        $project_status_data = [];

        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('status_id', $status_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $project_status_data[$result['language_id']] = ['name' => $result['name']];
        }
        return $project_status_data;
     } 


    // -----------------------------------------------------------------
}
