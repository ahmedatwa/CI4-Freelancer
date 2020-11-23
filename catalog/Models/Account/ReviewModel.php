<?php namespace Catalog\Models\Account;

class ReviewModel extends \CodeIgniter\Model
{
    protected $table          = 'review';
    protected $primaryKey     = 'review_id';
    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['project_id', 'freelancer_id', 'employer_id', 'comment', 'rating', 'recommended', 'ontime', 'submitted_by'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    protected $afterInsert = ['afterInsert'];

    protected function afterInsert(array $data)
    {
        \CodeIgniter\Events\Events::trigger('customer_review_add', $data['data']['customer_id'], $data['data']['project_id'], $data['id']);
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


    // public function getFreelancerReviews($data = [])
    // {
    //     $builder = $this->db->table('review r');
    //     $builder->select('r.comment, r.rating, r.status, r.review_id, r.project_id, r.freelancer_id, r.employer_id');
    //     $builder->join('project_description pd', 'r.project_id = pd.project_id', 'left');
    //     $builder->join('customer c', 'r.freelancer_id = c.customer_id', 'left');
      
    //     if (isset($data['customer_id'])) {
    //        $builder->where('c.customer_id', $data['customer_id']);
    //     }

    //     $sortData = [
    //         'p.date_added',
    //     ];

    //     if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
    //         $data['order_by'] = 'DESC';
    //     } else {
    //         $data['order_by'] = 'ASC';
    //     }

    //     if (isset($data['sort_by']) && in_array($data['sort_by'], $sortData)) {
    //         $builder->orderBy($data['sort_by'], 'DESC');
    //     } else {
    //         $builder->orderBy('r.date_added', 'ASC');
    //     }

    //     if (isset($data['start']) || isset($data['limit'])) {
    //         if ($data['start'] < 0) {
    //             $data['start'] = 0;
    //         }
    //         if ($data['limit'] < 1) {
    //             $data['limit'] = 20;
    //         }
    //         $builder->limit($data['limit'], $data['start']);
    //     }

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    // public function getEmployerReviews($data = [])
    // {
    //     $builder = $this->db->table('review r');
    //     $builder->select('r.comment, r.rating, r.status, r.review_id, r.project_id, r.freelancer_id, r.employer_id');
    //     $builder->join('project_description pd', 'r.project_id = pd.project_id', 'left');
    //     $builder->join('customer c', 'r.employer = c.customer_id', 'left');
      
    //     if (isset($data['customer_id'])) {
    //        $builder->where('c.customer_id', $data['customer_id']);
    //     }

    //     $sortData = [
    //         'p.date_added',
    //     ];

    //     if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
    //         $data['order_by'] = 'DESC';
    //     } else {
    //         $data['order_by'] = 'ASC';
    //     }

    //     if (isset($data['sort_by']) && in_array($data['sort_by'], $sortData)) {
    //         $builder->orderBy($data['sort_by'], 'DESC');
    //     } else {
    //         $builder->orderBy('r.date_added', 'ASC');
    //     }

    //     if (isset($data['start']) || isset($data['limit'])) {
    //         if ($data['start'] < 0) {
    //             $data['start'] = 0;
    //         }
    //         if ($data['limit'] < 1) {
    //             $data['limit'] = 20;
    //         }
    //         $builder->limit($data['limit'], $data['start']);
    //     }

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    // -----------------------------------------------------------------
}
