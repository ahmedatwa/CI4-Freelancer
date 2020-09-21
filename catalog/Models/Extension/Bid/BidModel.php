<?php namespace Catalog\Models\Extension\Bid;

class BidModel extends \CodeIgniter\Model
{
    protected $table          = 'bids';
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
        $builder = $this->db->table('bids b');
        $builder->select('CONCAT(c.firstname, " ", c.lastname) AS freelancer, b.quote, b.bid_id, b.status, b.delivery, c.image, c.customer_id, c.image, b.freelancer_id');
        $builder->join('customer c', 'b.freelancer_id = c.customer_id', 'left');
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
        $builder = $this->db->table('bids b');
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


    // -----------------------------------------------------------------
}
