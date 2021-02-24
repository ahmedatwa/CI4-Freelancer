<?php 

namespace Catalog\Models\Freelancer;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class FreelancerModel extends Model
{
    protected $table         = 'project_bids';
    protected $primaryKey    = 'bid_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['customer_id', 'amount', 'currency', 'status_id'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    
    public function getFreelancerBidsById($freelancer_id)
    {
        $builder = $this->db->table('project_bids pb');
        $builder->select('pb.quote, pb.delivery, pb.date_added, pd.name, pb.project_id, pb.selected, pb.accepted, pb.bid_id, pb.employer_id');
        $builder->join('project_description pd', 'pb.project_id = pd.project_id', 'left');
        $builder->where('pb.freelancer_id', $freelancer_id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    // Selected for project offer
    public function addWinner($data)
    {
        $builder = $this->db->table('project_bids');
        $builder->where([
            'freelancer_id' =>  $data['freelancer_id'],
            'project_id'    =>  $data['project_id'],
            'bid_id'        =>  $data['bid_id'],
            'date_modified' => Time::now()->getTimestamp()
        ]);
        $builder->set('selected', 1)->update();
        // Update Project Status
        $projects = $this->db->table('project');
        $projects->where('project_id', $data['project_id']);
        $projects->set('status_id', 6);
        $projects->update();

        // trigget new offer for freelancer
        \CodeIgniter\Events\Events::trigger('project_offer_selected', $data);
    }
    // Accept the employer offer
    public function acceptOffer(int $freelancer_id, int $project_id, int $bid_id, int $employer_id)
    {
        $builder = $this->db->table('project_bids');
        $builder->where([
            'freelancer_id' => $freelancer_id,
            'project_id'    => $project_id,
            'bid_id'        => $bid_id,
        ]);

        $builder->set('accepted', 1)->update();
        // Notfication Event
        \CodeIgniter\Events\Events::trigger('project_offer_accepted', $freelancer_id, $project_id, $bid_id, $employer_id);

        // Update Project Status
        $projects = $this->db->table('project');
        $projects->where('project_id', $project_id);
        $projects->set([
            'status_id'     => 4,
            'freelancer_id' => $freelancer_id
        ]);
        $projects->update();
    }

    public function updateProjectStatus(int $project_id, array $data)
    {
        $builder = $this->db->table('project');
        $builder->where('project_id', $project_id);
        $builder->set('status_id', 2)->update(); 

        \CodeIgniter\Events\Events::trigger('mail_project_status_update', $project_id, $data['freelancer_id'], $data['employer_id']);
        \CodeIgniter\Events\Events::trigger('project_status_update', $project_id, $data['freelancer_id'], $data['employer_id']);
    }

    // -----------------------------------------------------------------
}
