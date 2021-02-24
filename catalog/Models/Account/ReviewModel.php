<?php 

namespace Catalog\Models\Account;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table         = 'review';
    protected $primaryKey    = 'review_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['project_id', 'freelancer_id', 'employer_id', 'comment', 'rating', 'recommended', 'ontime', 'submitted_by', 'status'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';
    // User Activity Events
    protected $afterInsert   = ['afterInsert'];

    protected function afterInsert(array $data)
    {
        \CodeIgniter\Events\Events::trigger('customer_review_add', $data['data']);
        return $data['id'];
    }

    public function getAvgReviewByFreelancerId($freelancer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->selectAvg('rating', 'total');
        $builder->where(['freelancer_id' => $freelancer_id, 'status' => 1]);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
    }    

    public function getRecommendedByFreelancerId($freelancer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->selectCount('recommended', 'total');
        $builder->where('freelancer_id', $freelancer_id);
        $query = $builder->get()->getRowArray();
        return $query['total'];
    }

    public function getTotalJobsByFreelancerId($freelancer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->where('freelancer_id', $freelancer_id);
        return $builder->countAllResults();
    }

    public function getOntimeByFreelancerId($freelancer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->selectCount('ontime', 'total');
        $builder->where([
            'freelancer_id' => $freelancer_id,
            'ontime' => 1
        ]);
        $query = $builder->get()->getRowArray();
        return $query['total'];
    }

    public function getAvgReviewByEmployerId($employer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->selectAvg('rating', 'total');
        $builder->where(['employer_id' => $employer_id, 'status' => 1]);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
    }

    public function getSuccessByEmployerId($employer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->selectAvg('rating', 'total');
        $builder->where(['employer_id' => $employer_id, 'status' => 1]);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
    }

    public function getFreelancerReviews($freelancer_id)
    {
        $builder = $this->db->table('review r');
        $builder->select('r.comment, r.date_added, r.submitted_by, AVG(r.rating) AS rating, pd.name');
        $builder->join('project_description pd', 'r.project_id = pd.project_id', 'left');
        $builder->where('r.freelancer_id', $freelancer_id)
                ->where('r.submitted_by !=', $freelancer_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $key => $value) {
           if (is_null(array_values($value)[0])) {
               return [];
           } else {
               return $query->getResultArray();
           }
       }
    }

  // -----------------------------------------------------------------
}
