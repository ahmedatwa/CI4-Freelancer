<?php namespace Admin\Models\Catalog;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table          = 'review';
    protected $primaryKey     = 'review_id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    protected $allowedFields = ['status', 'comment', 'rating'];
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';
    // Registry
    protected $registry;

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data'])) {
            $data['id'] = [
                'key'   => 'review_id',
                'value' => $data['id']
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'review_add', $data['id'], $data['data']);
        }
        return $data;
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $data['id'] = [
                'key'   => 'review_id',
                'value' => $data['id'][0]
            ];
            
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'review_edit', $data['id'], $data['data']);
        }
        return $data;
    }


    public function getReviews(array $data = [])
    {
        $builder = $this->db->table('review r');
        $builder->select('r.review_id as review_id, r.rating, r.status, r.date_added, pd.name, r.project_id, CONCAT(c.firstname, " ", c.lastname) As author');
        $builder->join('project_description pd', 'r.project_id = pd.project_id', 'left');
        $builder->join('customer c', 'c.customer_id = r.submitted_by', 'left');
        $builder->where('pd.language_id', service('Registry')->get('config_language_id'));
       
        if (!empty($data['filter_date_added'])) {
            $builder->where('p.date_added', $data['filter_date_added']);
        }

        if (!empty($data['filter_name'])) {
            $builder->where('pd.name', $data['filter_name']);
        }

        $sorting_data = [
            'jd.name',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
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

    public function getReview(int $review_id)
    {
        $builder = $this->db->table('review r');
        $builder->select('CONCAT(c.firstname, " ", c.lastname) As author, r.project_id, r.comment, r.rating, r.date_added, r.status');
        $builder->join('project_description pd', 'r.project_id = pd.project_id', 'left');
        $builder->join('customer c', 'c.customer_id = r.submitted_by', 'left');
        $builder->where('r.review_id', $review_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addReview(array $data)
    {
        $builder = $this->db->table($this->table);
        $review_data = [
            'author'     => $data['author'],
            'service_id' => $data['service_id'],
            'text'       => $data['text'],
            'rating'     => $data['rating'],
            'status'     => $data['status']
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($review_data);
    }
    
    public function editReview(int $review_id, array $data)
    {
        $builder = $this->db->table($this->table);
        $review_data = [
            'author'     => $data['author'],
            'service_id' => $data['service_id'],
            'text'       => $data['text'],
            'rating'     => $data['rating'],
            'status'     => $data['status']
        ];
        
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('review_id', $review_id);
        $builder->update($review_data);
    }

    public function deleteReview(int $review_id)
    {
        $builder = $this->db->table($this->table);
        $builder->delete(['review_id' => $review_id]);
    }

    public function getProjectByReviewID(int $review_id)
    {
        $builder = $this->db->table('project_description pd');
        $builder->join('review r', 'pd.project_id = r.project_id', 'left');
        $builder->where('review_id', $review_id);
        $query = $builder->get()->getRowArray();
        return $query['name'];
    }


    // -----------------------------------------------------------------
}
