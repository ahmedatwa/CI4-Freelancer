<?php namespace Catalog\Models\Employer;

class EmployerModel extends \CodeIgniter\Model
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

    
    // Award Freelancer for Project
    public function addWinner($data)
    {
        $builder = $this->db->table('project_bids');
        $builder->set('selected', 1);
        $builder->where([
            'freelancer_id' =>  $data['freelancer_id'],
            'project_id'    =>  $data['project_id'],
            'bid_id'        =>  $data['bid_id']
        ]);

        $builder->set('date_modified', 'NOW()', false);
        $builder->update();

        // Update Project Status
        $projects = $this->db->table('project');
        $projects->where('project_id', $data['project_id']);
        $projects->set('status_id', 6);
        $projects->update();

        // trigget new offer for freelancer
        \CodeIgniter\Events\Events::trigger('project_offer_selected', $data);
    }

    

    // -----------------------------------------------------------------
}
