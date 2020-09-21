<?php namespace Catalog\Models\Setting;

class EventsModel extends \CodeIgniter\Model
{
    protected $table          = 'event';
    protected $primaryKey     = 'event_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['code', 'action', 'status', 'priority'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;


    // ----------------------------------------------------
}
