<?php namespace Catalog\Models\Freelancer;

class FreelancerModel extends \CodeIgniter\Model
{
    protected $table          = 'project_bids';
    protected $primaryKey     = 'bid_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['customer_id', 'amount', 'currency', 'status_id'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    
    public function getFreelancerBidsById($freelancer_id)
    {
        $builder = $this->db->table('project_bids pb');
        $builder->select('pb.quote, pb.delivery, pb.date_added, pd.name, pb.project_id, pb.selected, pb.accepted');
        $builder->join('project_description pd', 'pb.project_id = pd.project_id', 'left');
        $builder->where('pb.freelancer_id', $freelancer_id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function acceptOffer(int $freelancer_id, int $project_id)
    {
        $builder = $this->db->table('project_bids');
        $builder->where([
            'freelancer_id' => $freelancer_id,
            'project_id'    => $project_id,
        ]);

        $builder->set('accepted', 1);
        $builder->update();

        \CodeIgniter\Events\Events::trigger('offer_accepted', $freelancer_id, $project_id);

        // Update Project Status
        $projects = $this->db->table('project');
        $projects->where('project_id', $project_id);
        $projects->set('status_id', 4);
        $projects->set('freelancer_id', $freelancer_id);
        $projects->update();
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

    // -----------------------------------------------------------------
}
