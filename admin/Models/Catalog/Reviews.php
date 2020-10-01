<?php namespace Admin\Models\Catalog;

use CodeIgniter\Model;

class Reviews extends Model
{
    protected $table          = 'project_review';
    protected $primaryKey     = 'project_review_id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
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
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        }
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        }
    }


    public function getReviews(array $data = [])
    {        
        $builder = $this->db->table('project_review pr');
        $builder->select('pr.project_review_id as review_id, pr.rating, pr.status, pr.date_added, pr.author, pd.name, pr.project_id');
        $builder->join('project_description pd', 'pr.project_id = pd.project_id', 'LEFT');
        $builder->where('pd.language_id', service('Registry')->get('config_language_id'));
       
        if (!empty($data['filter_date_added'])) {
            $builder->where('p.date_added', $data['filter_date_added']);
        }

        if (!empty($data['filter_name'])) {
            $builder->where('pd.name', $data['filter_name']);
        }

        $sorting_data = array(
            'jd.name',
        );

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

    public function getReview($review_id)
    {
        $builder = $this->db->table('project_review pr');
        $builder->join('project_description pd', 'pr.project_id = pd.project_id', 'left');
        $builder->select();
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addReview($data)
    {
        $builder = $this->db->table($this->table);
        $review_data = array(
            'author'     => $data['author'],
            'service_id' => $data['service_id'],
            'text'       => $data['text'],
            'rating'     => $data['rating'],
            'status'     => $data['status']
        );

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($review_data);
    }
    
    public function editReview($review_id, $data)
    {
        $builder = $this->db->table($this->table);
        $review_data = array(
            'author'     => $data['author'],
            'service_id' => $data['service_id'],
            'text'       => $data['text'],
            'rating'     => $data['rating'],
            'status'     => $data['status']
        );
        
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('review_id', $review_id);
        $builder->update($review_data);
    }

    public function deleteReview($review_id)
    {
        $builder = $this->db->table($this->table);
        $builder->delete(['review_id' => $review_id]);
    }

    public function getProjectByReviewID($review_id)
    {
        $builder = $this->db->table('project_description pd');
        $builder->join('review r', 'pd.project_id = r.project_id', 'left');
        $builder->where('review_id', $review_id);
        $query = $builder->get()->getRowArray();
        return $query['name'];
    }


    // -----------------------------------------------------------------
}
