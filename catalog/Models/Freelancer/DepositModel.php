<?php namespace Catalog\Models\Freelancer;

class DepositModel extends \CodeIgniter\Model
{
    protected $table          = 'customer_to_balance';
    protected $primaryKey     = 'balance_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['available', 'status', 'customer_id'];
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
            //\CodeIgniter\Events\Events::trigger('customer_activity_update', $data['id'], $name);
        } 
       return $data;  
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname']) || isset($data['data']['lastname']) || isset($data['data']['tag_line'])) {
            $name  = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('customer_activity_update', $data['id'], $name);
        } 
       return $data;  
    }

    // -----------------------------------------------------------------
}
