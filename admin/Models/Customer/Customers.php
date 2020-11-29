<?php namespace Admin\Models\customer;

class customers extends \CodeIgniter\Model
{
    protected $table          = 'customer';
    protected $primaryKey     = 'customer_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['firstname', 'lastname', 'email', 'password', 'status', 'customer_group_id', 'newsletter'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // Password Hashing Events
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['data']['password']);
        }
        return $data;
    }

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

    public function getCustomers(array $data = [])
    {
        $builder = $this->db->table('customer c');
        $builder->select('c.customer_id, CONCAT(c.firstname, " ", c.lastname) AS name, c.email, c.status, c.ip, cgd.name AS customer_group, c.date_added, c.customer_group_id');
        $builder->join('customer_group_description cgd', 'c.customer_group_id = cgd.customer_group_id', 'left');
        $builder->where('cgd.language_id', service('registry')->get('config_language_id'));
        
        if (!empty($data['filter_name'])) {
            $builder->like('CONCAT(c.firstname, " ", c.lastname)', $data['filter_name'], 'after');
        }

        if (!empty($data['filter_employer'])) {
            $builder->where('c.customer_group_id', $data['filter_employer']);
        }

        if (!empty($data['filter_freelancer'])) {
            $builder->where('c.customer_group_id', $data['filter_freelancer']);
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('name', 'DESC');
        } else {
            $builder->orderBy('name', 'ASC');
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

    public function deleteCustomer($customer_id)
    {
        $customer = $this->db->table('customer');
        $customer->delete(['customer_id' => $customer_id]);
        $customer_activity = $this->db->table('customer_activity');
        $customer_activity->delete(['customer_id' => $customer_id]);
        $customer_history = $this->db->table('customer_history');
        $customer_history->delete(['customer_id' => $customer_id]);
        $customer_login = $this->db->table('customer_login');
        $customer_login->delete(['customer_id' => $customer_id]);
        $customer_online = $this->db->table('customer_online');
        $customer_online->delete(['customer_id' => $customer_id]);
        $customer_reviews = $this->db->table('customer_reviews');
        $customer_reviews->delete(['customer_id' => $customer_id]);
    }

    public function getReviews(array $data)
    {
        $builder = $this->db->table('review r');
        $builder->select('r.review_id, r.rating, r.status, r.date_added, pd.name, r.employer_id, r.freelancer_id, r.submitted_by');
        $builder->join('project_description pd', 'r.project_id = pd.project_id', 'LEFT');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));
       
        if (!empty($data['filter_date_added'])) {
            $builder->where('p.date_added', $data['filter_date_added']);
        }

        if (!empty($data['customer_id'])) {
            $builder->where('r.employer_id', $data['customer_id']);
            $builder->orWhere('r.freelancer_id', $data['customer_id']);
        }

        $sorting_data = [
            'r.date_added',
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

    public function approve($review_id)
    {
        $builder = $this->db->table('customer_review');
        $builder->where('review_id', $review_id);
        $builder->set('status', 1);
        $builder->update();
    }

    // -----------------------------------------------------------------
}
