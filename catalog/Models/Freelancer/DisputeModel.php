<?php namespace Catalog\Models\Freelancer;

class DisputeModel extends \CodeIgniter\Model
{
    protected $table          = 'dispute';
    protected $primaryKey     = 'dispute_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['project_id', 'freelancer_id', 'employer_id', 'comment', 'dispute_status_id', 'dispute_reason_id'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function getDisputeReasons()
    {
        $builder = $this->db->table('dispute_reason');
        $builder->select();
        $query = $builder->get();
        return $query->getResultArray();
    }
    // -----------------------------------------------------------------
}
