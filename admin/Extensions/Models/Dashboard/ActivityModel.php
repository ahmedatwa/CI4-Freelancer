<?php namespace Extensions\Models\Dashboard;

use CodeIgniter\Model;

class ActivityModel extends Model
{
    protected $table          = 'customer_activity';
    protected $primaryKey     = 'customer_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['key', 'data'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';


// ----------------------------------------------------------
}