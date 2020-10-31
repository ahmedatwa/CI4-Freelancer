<?php namespace Catalog\Models\Account;


class ActivityModel extends \CodeIgniter\Model
{

    protected $table      = 'customer_activity';
    protected $primaryKey = 'customer_activity_id';
    protected $returnType = 'array';

    public function getActivitiesByCustomerID($customer_id)
    {
        $builder = $this->db->table('customer_activity');
        $builder->select();
        $builder->where('freelancer_id', $customer_id);
        $builder->orWhere('employer_id', $customer_id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getFreelancerUserName($freelancer_id)
    {
        $builder = $this->db->table('customer');
        $builder->select('username');
        $builder->where('customer_id', $freelancer_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getEmployerUserName($employer_id)
    {
        $builder = $this->db->table('customer');
        $builder->select('username');
        $builder->where('customer_id', $employer_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addActivity($key, $data)
    {
        $builder = $this->db->table('customer_activity');
        $request = \Config\Services::request();

        $activity_data = [
            'customer_id'   => $data['customer_id'] ?? 0,
            'freelancer_id' => $data['freelancer_id'] ?? 0,
            'employer_id'   => $data['employer_id'] ?? 0,
            'key'           => $key,
            'data'          => json_encode($data),
            'ip'            => $request->getIPAddress(),
            'user_agent'    => $request->getUserAgent(),
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($activity_data);
    }


} // END OF Activities Model FILE
