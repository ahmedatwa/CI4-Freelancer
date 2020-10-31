<?php namespace Extensions\Models\Dashboard;

class Onlines extends \CodeIgniter\Model
{
    protected $table          = 'customer_online';
    protected $primaryKey     = 'customer_id';
    protected $returnType     = 'array';

    public function getTotalOnline($data = array())
    {
		$builder = $this->db->table($this->table);
		return $builder->countAll();
    }

    // ----------------------------------------------------------
}
