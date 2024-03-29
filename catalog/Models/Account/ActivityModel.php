<?php namespace Catalog\Models\Account;

class ActivityModel extends \CodeIgniter\Model
{
    protected $table         = 'customer_activity';
    protected $primaryKey    = 'customer_activity_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['seen'];

    public function getActivitiesByCustomerID($customer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('customer_id, data, key, date_added');
        $builder->where([
            'seen' => 0,
            'customer_id' => $customer_id
        ]);
        $builder->orderBy('date_added', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDashboardActivitiesByCustomerId($customer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->distinct();
        $builder->where('customer_id', $customer_id);
        $builder->like('date_added', Date('Y-m-d'), 'after');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalActivitiesByCustomerID($customer_id)
    {
        $builder = $this->db->table($this->table);
        $builder->distinct();
        $builder->where([
            'seen' => 0,
            'customer_id' => $customer_id
        ]);

        return $builder->countAllResults();
    }

    public function addActivity($key, $data, int $seen = 0)
    {
        $builder = $this->db->table($this->table);

        $request = \Config\Services::request();

        $activity_data = [
            'customer_id'   => $data['customer_id'],
            'key'           => $key,
            'data'          => json_encode($data),
            'ip'            => $request->getIPAddress(),
            'user_agent'    => $request->getUserAgent(),
            'seen'          => $seen,
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($activity_data);
    }

    public function AddCustomerIP(array $data)
    {
        $builder = $this->db->table('customer_ip');
        $request = \Config\Services::request();

        $ipData = [
            'customer_id'   => $data['customer_id'],
            'ip'            => $request->getIPAddress(),
            'user_agent'    => $request->getUserAgent(),
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->insert($ipData);
    }

    public function getCustomerIP(int $customer_id)
    {
      $builder = $this->db->table('customer_ip');
      $builder->where('customer_id', $customer_id);
      $query = $builder->get();
      if ($builder->countAllResults()) {
          return $query->getRowArray();
      } else {
        return;
      } 
    }

} // END OF Activities Model FILE
