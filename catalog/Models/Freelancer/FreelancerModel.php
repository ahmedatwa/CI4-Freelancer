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

        \CodeIgniter\Events\Events::trigger('project_winner_accepted', $freelancer_id, $project_id);

        // Update Project Status
        $projects = $this->db->table('project');
        $projects->where('project_id', $project_id);
        $projects->set('status_id', 4);
        $projects->set('freelancer_id', $freelancer_id);
        $projects->update();
    }

    // -----------------------------------------------------------------
}
