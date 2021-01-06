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

    public function payMilestone(array $data, $project_id)
    {
      $builder = $this->db->table($this->table);

      if (isset($data['freelancer_id'])) {
            $freelancer_data = [
                'customer_id' => $data['freelancer_id'],
                'project_id'  => $project_id,
                'income'      => $data['amount'],
            ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($freelancer_data);
        $balance_id = $this->db->insertID();
      }  
      // Employer Balance
      if (isset($data['employer_id'])) {
            $employer_data = [
                'customer_id' => $data['employer_id'],
                'project_id'  => $project_id,
                'used'        => $data['amount'],
            ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($employer_data);
        
        \CodeIgniter\Events\Events::trigger('customer_milestone_payment', $data['freelancer_id'], $project_id, $balance_id);
      }  
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
            'selected'      => 1,
            'accepted'      => 1,
        ]);

        $project_bid->set('paid', 1)->update();

        \CodeIgniter\Events\Events::trigger('customer_transfer_funds', $data);
        \CodeIgniter\Events\Events::trigger('mail_payment', $data);
    }

    public function getBalanceByCustomerID(int $customer_id)
    {
        $builder = $this->db->table('customer_to_balance');
        $builder->select('SUM(used) AS used, SUM(withdrawn) As withdrawn, SUM(income) AS income, available');
        $builder->where('customer_id', $customer_id);

        $query = $builder->get();

        foreach ($query->getResultArray() as $result) {
            $total = ($result['available'] + $result['income']) - ($result['used'] + $result['withdrawn']);
        }
        
        if ($total) {
            return $total;
        } else {
            return '0.00';
        }
    }

    public function getWithdrawnByCustomerID($customer_id)
    {
        $builder = $this->db->table('customer_to_balance');
        $builder->selectSum('withdrawn', 'total');
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        $row = $query->getRowArray();   
        if ($row['total']) {
            return $row['total'];
        } else {
            return '0.00';
        }
    }

    public function getUsedByCustomerID($customer_id)
    {
        $builder = $this->db->table('customer_to_balance');
        $builder->selectSum('used', 'total');
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        $row = $query->getRowArray();   
        if ($row['total']) {
            return $row['total'];
        } else {
            return '0.00';
        }
    }

    // -----------------------------------------------------------------
}
