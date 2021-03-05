<?php 

namespace Catalog\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class DepositModel extends Model
{
    protected $table         = 'customer_deposit';
    protected $primaryKey    = 'balance_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['available', 'status', 'customer_id'];
    // User Activity Events
    //protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate   = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname']) || isset($data['data']['lastname']) || isset($data['data']['tag_line'])) {
            $name  = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('customer_activity_update', $data['id'], $name);
        }
        return $data;
    }

    public function deposit(array $data)
    {
        $builder = $this->db->table($this->table);
        $fund_data = [
            'customer_id'   => $data['customer_id'],
            'amount'        => $data['amount'],
            'currency'      => $data['currency'],
            'status'        => $data['status'],
            'date_added'    => Time::now()->getTimestamp(),
            'date_modified' => Time::now()->getTimestamp()
        ];
        $builder->insert($fund_data);
        // update balance
        $balance_table = $this->db->table('customer_to_balance');
        $balance_table->select('available');
        $balance_table->where('customer_id', $data['customer_id']);
        $query = $balance_table->get();

        if ($row = $query->getRow()) {
            $balance_data = [
               'available'     => $row->available + $data['amount'],
               'date_modified' => Time::now()->getTimestamp()
            ];
            $balance_table->where('customer_id', $data['customer_id']);
            $balance_table->update($balance_data);
        } else {
            $balance_data = [
                'available'     => $data['amount'],
                'customer_id'   => $data['customer_id'],
                'currency'      => $data['currency'],
                'date_added'    => Time::now()->getTimestamp(),
                'date_modified' => Time::now()->getTimestamp()
            ];
            $balance_table->insert($balance_data);
        }
    }

    // -----------------------------------------------------------------
}
