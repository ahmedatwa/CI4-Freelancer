<?php namespace Admin\Models\Finance;

use CodeIgniter\Model;

class WithdrawalModel extends Model
{
    protected $table      = 'withdraw';
    protected $primaryKey = 'withdraw_id';
    protected $returnType = 'array';

    protected $allowedFields = ['customer_id', 'amount', 'date_processed'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    
    public function getWithdawRequests()
    {
        $builder = $this->db->table('withdraw w');
        $builder->select('c.username, w.amount, ws.name as status, w.date_added, w.date_processed, w.withdraw_id');
        $builder->join('customer c', 'w.customer_id = c.customer_id', 'left');
        $builder->join('withdraw_status ws', 'w.status_id = ws.withdraw_status_id', 'left');
        $query = $builder->get();
        return $query->getResultArray();
    }

   
   
    // -----------------------------------------------------------------
}
