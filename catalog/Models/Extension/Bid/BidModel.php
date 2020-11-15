<?php namespace Catalog\Models\Extension\Bid;

class BidModel extends \CodeIgniter\Model
{
    protected $table          = 'project_bids';
    protected $primaryKey     = 'bid_id';
    protected $returnType     = 'array';
    protected $allowedFields = ['project_id', 'freelancer_id', 'quote', 'delivery', 'status'];
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data']['freelancer_id'])) {
            \CodeIgniter\Events\Events::trigger('bid_add', $this->db->insertID(), $data['data']['freelancer_id']);
        } else {
            \CodeIgniter\Events\Events::trigger('bid_add', $this->db->insertID(), $data['data']['freelancer_id']);
        }
    }

    public function getBids(array $data =[])
    {
        $builder = $this->db->table('project_bids pb');
        $builder->select('c.username, c.email, pb.quote, pb.bid_id, pb.status, pb.delivery, c.image, c.customer_id, pb.freelancer_id, ');
        $builder->join('customer c', 'pb.freelancer_id = c.customer_id', 'left');
        $builder->join('project_description pd', 'pb.project_id = pd.project_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));

        if (isset($data['project_id'])) {
            $builder->where('pb.project_id', $data['project_id']);
        }

        if (isset($data['freelancer_id'])) {
            $builder->where('pb.freelancer_id', $data['freelancer_id']);
        }

        $builder->orderBy('pb.date_added', 'ASC');
        

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalBids()
    {
        $builder = $this->db->table('project_bids b');
        $builder->join('project_description pd', 'b.project_id = pd.project_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));

        if (isset($data['project_id'])) {
            $builder->where('pd.project_id', $data['project_id']);
        }
        if (isset($data['orderBy']) && $data['orderBy'] == 'DESC') {
            $builder->orderBy($data['orderBy'], 'DESC');
        } else {
            $builder->orderBy('b.date_added', 'ASC');
        }

        return $builder->countAllResults();
    }

     public function getTotalBidsByProjectId($project_id)
    {
        $builder = $this->db->table('project_bids');
        $builder->where('project_id', $project_id);
        return $builder->countAllResults();
    }

    public function addBid(array $data)
    {
        
        $builder = $this->db->table('project_bids');
        $bid_data = [
            'project_id'    => $data['project_id'],
            'freelancer_id' => $data['freelancer_id'],
            'employer_id'   => $data['employer_id'],
            'quote'         => $data['quote'],
            'delivery'      => $data['delivery'],
            'description'   => $data['description'],
            'status'        => 1
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($bid_data);
        // trigger Bid Emailto Employer
        \CodeIgniter\Events\Events::trigger('project_bid_add', $data);

        if (isset($data['fee'])) {
            
            $revenue = $this->db->table('project_bids_upgrade');
            $revenue_data = [
                'project_id' => $data['project_id'],
                'payer_id'   => $data['freelancer_id'],
                'bid_id'     => $this->db->insertID(),
                'amount'     => $data['fee'],
                'reason'     => 'Optional Upgrade',
            ];

            $revenue->set('date_added', 'NOW()', false);
            $revenue->insert($revenue_data);
        }
    }

    public function isAwarded($freelancer_id)
    {
       $builder = $this->db->table('project_bids');
       $builder->select('selected');
       $builder->where('freelancer_id', $freelancer_id);
       $row = $builder->get()->getRow();
       if ($row->selected != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getBidByProjectId($project_id)
    {
        $builder = $this->db->table('project_bids');
        $builder->select();
        $builder->where('project_id', $project_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function isAccepted($freelancer_id)
    {
       $builder = $this->db->table('project_bids');
       $builder->select('accepted');
       $builder->where('freelancer_id', $freelancer_id);
       $row = $builder->get()->getRow();
       if ($row->accepted != 0) {
            return true;
        } else {
            return false;
        }
    }


    // -----------------------------------------------------------------
}
