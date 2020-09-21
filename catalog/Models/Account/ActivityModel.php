<?php namespace Catalog\Models\Account;

class ActivityModel extends \CodeIgniter\Model
{
    public function addActivity($key, $data)
    {
        $builder = $this->db->table('customer_activity');
        $request = \Config\Services::request();

        $activity_data = [
            'customer_id'=> $data['customer_id'],
            'key'        => $key,
            'data'       => json_encode($data),
            'ip'         => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent(),
        ];
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($activity_data);
    }


} // END OF Activities Model FILE
