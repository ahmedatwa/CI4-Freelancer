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
        $builder->join('withdraw_status ws', 'w.withdraw_status_id = ws.withdraw_status_id', 'left');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getWithdrawStatuses()
    {
        $builder = $this->db->table('withdraw_status');
        $builder->select();
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function addWithdrawStatus($data)
    {
        $builder = $this->db->table('withdraw_status');
        $rowData = [
        'name' => $data['name'],
        'language_id' => 1,
    ];
        $builder->insert($rowData);
    }

    public function editWithdrawStatus($withdraw_status_id, $data)
    {
        $builder = $this->db->table('withdraw_status');
        $builder->where('withdraw_status_id', $withdraw_status_id);
        $rowData = [
        'name' => $data['name'],
        'language_id' => 1,
    ];
        $builder->update($rowData);
    }

    public function deleteWithdrawStatus($withdraw_status_id)
    {
        $builder = $this->db->table('withdraw_status');
        $builder->delete(['withdraw_status_id' => $withdraw_status_id]);
    }


    // History
    public function getWithdrawHistories($dispute_id)
    {
        $builder = $this->db->table('withdraw_history wh');
        $builder->select('wh.date_added, ws.name AS status, wh.comment, wh.notify');
        $builder->join('withdraw_status ws', 'wh.withdraw_status_id = ws.withdraw_status_id', 'left');
        $builder->where('wh.withdraw_id', $dispute_id);
        $builder->orderBy('wh.date_added', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function addWithdrawHistory($withdraw_id, $withdraw_status_id, $comment, $notify, $amount, $customer_id)
    {
        $builder = $this->db->table('withdraw');
        $builder->set('withdraw_status_id', $withdraw_status_id);
        $builder->set('date_modified', 'NOW()', false);
        $builder->set('date_processed', 'NOW()', false);
        $builder->where('withdraw_id', $withdraw_id);
        $builder->update();

        $history = $this->db->table('withdraw_history');
        $history->set('withdraw_id', $withdraw_id);
        $history->set('withdraw_status_id', $withdraw_status_id);
        $history->set('notify', $notify);
        $history->set('comment', $comment);
        $history->set('date_added', 'NOW()', false);
        $history->insert();

        // update customer balance
        $history = $this->db->table('customer_to_balance');
        $history->set('customer_id', $customer_id);
        $history->set('withdrawn', $amount);
        $builder->set('date_modified', 'NOW()', false);
        $history->insert();

        if ($notify) {
            \CodeIgniter\Events\Events::trigger('customer_withdraw_notify', $withdraw_status_id, $withdraw_id, $notify);
        }
    }

   
   
    // -----------------------------------------------------------------
}
