<?php namespace Extensions\Models\Dashboard;

class OnlineModel extends \CodeIgniter\Model
{
    protected $table          = 'customer_online';
    protected $primaryKey     = 'customer_id';
    protected $returnType     = 'array';

    public function getTotalOnline($data = [])
    {
		$builder = $this->db->table($this->table);
		return $builder->countAll();
    }

    // ----------------------------------------------------------
}
