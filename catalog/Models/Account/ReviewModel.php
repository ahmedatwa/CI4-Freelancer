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

    public function getFeedbackProjects($data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.type, p.status_id, p.runtime, p.employer_id, p.freelancer_id, ps.name as status, p.freelancer_review_id, p.employer_review_id');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('project_status ps', 'p.status_id = ps.status_id', 'left');
        $builder->where([
            'pd.language_id' => service('registry')->get('config_language_id'),
            'p.status_id'    => service('registry')->get('config_project_completed_status'),
            'p.freelancer_review_id'    => 0,
        ]);

        $builder->orWhere([
            'p.employer_review_id'    => 0,
        ]);

        if (isset($data['status'])) {
            $builder->where('p.status_id', $data['status']);
        }

        if (isset($data['customer_id'])) {
            $builder->where('p.freelancer_id', $data['customer_id']);
            $builder->orWhere('p.employer_id', $data['customer_id']);
        }

        if (isset($data['orderBy']) && $data['orderBy'] == 'DESC') {
            $data['orderBy'] = 'DESC';
        } else {
            $data['orderBy'] = 'ASC';
        }

        $sortData = ['pa.date_added'];

        if (isset($data['sortBy']) && in_array($data['sortBy'], $sortData)) {
            $builder->orderBy($data['sortBy'], 'DESC');
        } else {
            $builder->orderBy('p.date_added', 'ASC');
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

    public function getAvgReviewByFreelancerId(int $freelancer_id)
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
        if ($query['total']) {
            return $query['total'];
        } else {
            return 'N/A';
        }
        
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
        if ($query['total']) {
            return $query['total'];
        } else {
            return 'N/A';
        }
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

    public function getFreelancerReviews(int $freelancer_id)
    {
        $builder = $this->db->table('review r');
        $builder->select('r.comment, r.date_added, r.submitted_by, AVG(r.rating) AS rating, pd.name')
                ->join('project_description pd', 'r.project_id = pd.project_id', 'left')
                ->where([
                    'r.freelancer_id'   => $freelancer_id,
                    'r.submitted_by !=' => $freelancer_id
                ]);
        if ($builder->countAllResults()) {
            $query = $builder->get();
            return $query->getResultArray();
        } else {
            return [];
        }        
    }

    public function getTotalFreelancerReviews(int $freelancer_id)
    {
        $builder = $this->db->table('review r');
        $builder->select('r.comment, r.date_added, r.submitted_by, AVG(r.rating) AS rating, pd.name')
                ->join('project_description pd', 'r.project_id = pd.project_id', 'left')
                ->where([
                    'r.freelancer_id'   => $freelancer_id,
                    'r.submitted_by !=' => $freelancer_id
                ]);
        return $builder->countAllResults();        
    }
  // -----------------------------------------------------------------
}
