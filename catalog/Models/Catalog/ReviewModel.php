<?php namespace Catalog\Models\Catalog;

class ReviewModel extends \CodeIgniter\Model
{
    protected $table          = 'review';
    protected $primaryKey     = 'review_id';
    protected $returnType     = 'array';

    public function getAvgReviewByFreelancerId($freelancer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->selectAvg('rating', 'total');
        $builder->where(['freelancer_id' => $freelancer_id, 'status' => 1]);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
    }

    public function getAvgReviewByEmployerId($employer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->selectAvg('rating', 'total');
        $builder->where(['employer_id' => $employer_id, 'status' => 1]);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
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
