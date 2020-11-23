<?php namespace Catalog\Models\Freelancer;

class WithdrawModel extends \CodeIgniter\Model
{
    protected $table          = 'withdraw';
    protected $primaryKey     = 'withdraw_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['customer_id', 'amount', 'currency', 'withdraw_status_id'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function getWithdrawalByCustomerId($customer_id)
    {
        $builder = $this->db->table('withdraw w');
        $builder->select('w.customer_id, ws.name as status, w.amount, w.date_added, w.withdraw_id, w.date_processed');
        $builder->join('withdraw_status ws', 'w.withdraw_status_id = ws.withdraw_status_id', 'left');
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function addRequest($data)
    {
        $builder = $this->db->table($this->table);
        $data = [
            'customer_id'        => $data['customer_id'],
            'amount'             => $data['amount'],
            'currency'           => $data['currency'] ?? service('registry')->get('config_currency'),
            'withdraw_status_id' => $data['withdraw_status_id']
        ];
        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->set($data);
        $builder->insert();
        // update balance
        $balance_table = $this->db->table('customer_to_balance');
        $balance_table->select();
        $balance_table->where('customer_id', $data['customer_id']);
        $query = $balance_table->get();
        $row = $query->getRow();
        if ($row) {
            $balance_data = [
            'available'   => $row->available - $data['amount']
        ];
            $balance_table->set('date_modified', 'NOW()', false);
            $balance_table->update($balance_data);
        } 
        //Event Trigget
        \CodeIgniter\Events\Events::trigger('customer_activity_withdraw', $data['customer_id'], $data['amount']);

    }

    // -----------------------------------------------------------------
}
