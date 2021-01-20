<?php namespace Admin\Models\Report;

class OnlineModel extends \CodeIgniter\Model
{
    protected $table      = 'customer_online';
    protected $primaryKey = 'customer_id';

    protected $returnType     = 'array';
    
    //protected $allowedFields = ['name', 'email'];

    protected $useTimestamps = false;
    protected $createdField  = 'date_added';
}
