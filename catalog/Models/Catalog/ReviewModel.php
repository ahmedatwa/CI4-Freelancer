<?php namespace Catalog\Models\Catalog;

class ReviewModel extends \CodeIgniter\Model
{
    protected $table          = 'project_review';
    protected $primaryKey     = 'project_review_id';
    protected $returnType     = 'array';

    public function getAvgReviewByFreelancerId($freelancer_id)
    {
        $builder = $this->db->table('project_review');
        $builder->selectAvg('rating', 'total');
        $builder->where(['freelancer_id' => $freelancer_id, 'status' => 1]);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
    }    

    public function getAvgReviewByEmployerId($employer_id)
    {
        $builder = $this->db->table('project_review');
        $builder->selectAvg('rating', 'total');
        $builder->where(['employer_id' => $employer_id, 'status' => 1]);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
    }

    // -----------------------------------------------------------------
}
