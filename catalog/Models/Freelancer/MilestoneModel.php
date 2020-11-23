<?php namespace Catalog\Models\Freelancer;

class MilestoneModel extends \CodeIgniter\Model
{
    protected $table          = 'project_to_milestone';
    protected $primaryKey     = 'milestone_id';
    protected $returnType     = 'array';
    protected $allowedFields = ['project_id', 'created_by', 'created_for', 'amount', 'description', 'status', 'deadline'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    protected $afterInsert = ['afterInsert'];
    protected $afterUpdate = ['afterUpdate'];

    protected function afterInsert(array $data)
    {
        $events_data = [
            'milestone_id' => (int) $data['id'],
            'created_by'   => (int) $data['data']['created_by'],
            'created_for'  => (int) $data['data']['created_for'],
            'project_id'   => (int) $data['data']['project_id'],
        ];
        
        \CodeIgniter\Events\Events::trigger('project_milestone_create', $events_data);
    }

    protected function afterUpdate(array $data)
    {
        \CodeIgniter\Events\Events::trigger('project_milestone_update', (int) $data['id'][0]);
    }


    
    // -----------------------------------------------------------------
}
