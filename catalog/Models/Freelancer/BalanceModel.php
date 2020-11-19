<?php namespace Catalog\Models\Freelancer;

class BalanceModel extends \CodeIgniter\Model
{
    protected $table          = 'customer_to_balance';
    protected $primaryKey     = 'balance_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['customer_id', 'project_id', 'income', 'withdrawn', 'used', 'available', 'pending'];
    
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    protected $afterInsert = ['afterInsert'];

    protected function afterInsert(array $data)
    {
        \CodeIgniter\Events\Events::trigger('customer_balance_update', $data['data']['customer_id'], $data['data']['project_id'], $data['id']);
    }

    public function transferProjectFunds($data)
    {
        // update freelancer balance
        $builder = $this->db->table('customer_to_balance');

        if (isset($data['freelancer_id'])) {
            $builder->where([
            'customer_id'   => $data['freelancer_id'],
            'project_id'    => $data['project_id'],
        ]);
            $amount_data = [
            'customer_id' => $data['freelancer_id'],
            'project_id'  => $data['project_id'],
            'income'      => $data['amount'],
        ];
            $builder->set('date_modified', 'NOW()', false);
            $builder->replace($amount_data);
        }

        // update emplyer balance
        if (isset($data['employer_id'])) {
            $builder->where([
            'customer_id'   => $data['employer_id'],
            'project_id'    => $data['project_id'],
        ]);

            $amount_data = [
            'customer_id' => $data['employer_id'],
            'project_id'  => $data['project_id'],
            'used'        => $data['amount'],
        ];

            $builder->set('date_modified', 'NOW()', false);
            $builder->replace($amount_data);
        }
        // update project bid query
        $project_bid = $this->db->table('project_bids');
        $project_bid->where([
            'freelancer_id' => $data['freelancer_id'],
            'project_id'    => $data['project_id'],
        ]);

        $project_bid->select('quote');
        $row = $project_bid->get()->getRow();

        if ($data['amount'] == $row->quote) {
            $project_bid->set('status', 1)
                 ->update();
        } elseif ($data['amount'] < $row->quote) {
            $project_bid->set('status', 2)
                 ->update();
        }

        \CodeIgniter\Events\Events::trigger('customer_transfer_funds', $data);
        \CodeIgniter\Events\Events::trigger('mail_payment', $data);
    }

    public function getBalanceByCustomerID($customer_id)
    {
        $builder = $this->db->table('customer_to_balance');
        $builder->select('SUM(used) AS used, SUM(withdrawn) As withdrawn, SUM(income) AS income, available');
        $builder->where('customer_id', $customer_id);
        $query = $builder->get()
                         ->getResultArray();
        foreach ($query as $result) {
            $total = ($result['available'] + $result['income']) - ($result['used'] + $result['withdrawn']);
        }
        
        if ($total) {
            return $total;
        } else {
            return '0.00';
        }
    }

    // -----------------------------------------------------------------
}
