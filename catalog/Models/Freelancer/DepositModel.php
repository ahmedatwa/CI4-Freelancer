<?php namespace Catalog\Models\Freelancer;

class DepositModel extends \CodeIgniter\Model
{
    protected $table          = 'customer_deposit';
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

    public function insertFunds($data)
    {
        $builder = $this->db->table($this->table);
        $data = [
            'customer_id' => $data['customer_id'],
            'amount'      => $data['amount'],
            'currency'    => $data['currency'],
            'status'      => $data['status']
        ];
        $builder->set('date_added', 'NOW()', false);
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
            'available'   => $row->available + $data['amount']
        ];
            $balance_table->set('date_modified', 'NOW()', false);
            $balance_table->update($balance_data);
        } else {
            $balance_data = [
            'available' => $data['amount'],
            'customer_id' => $data['customer_id']
        ];
            $balance_table->set('date_added', 'NOW()', false);
            $balance_table->insert($balance_data);
        }
    }

    // -----------------------------------------------------------------
}
