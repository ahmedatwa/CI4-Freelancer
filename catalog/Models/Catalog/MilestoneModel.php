<?php namespace Catalog\Models\Catalog;

class MileStoneModel extends \CodeIgniter\Model
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

      \CodeIgniter\Events\Events::trigger('project_milestone_create', $data['id'] , $data['data']['created_by'], $data['data']['created_for'], $data['data']['project_id']);
    }

    protected function afterUpdate(array $data)
    {   
        \CodeIgniter\Events\Events::trigger('project_milestone_update', $data['id'][0]);
    }


    
    // -----------------------------------------------------------------
}
