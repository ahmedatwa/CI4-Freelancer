<?php

namespace Catalog\Models\Account;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ActivityModel extends Model
{
    protected $table         = 'customer_activity';
    protected $table_2       = 'customer_ip';
    protected $primaryKey    = 'customer_activity_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['seen'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';

    public function getActivitiesByCustomerID(array $data = [])
    {
        $builder = $this->db->table($this->table);
        $builder->select('customer_id, data, key, date_added');
        if (isset($data['customer_id'])) {
           $builder->where([
            'seen' => 0,
            'customer_id' => $data['customer_id']
        ]);
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 10;
            }
            $builder->limit($data['limit'], $data['start']);
        }
        
        $builder->orderBy('date_added', 'DESC');
        $builder->notLike('key', 'admin_', 'both');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalActivitiesByCustomerID(array $data = [])
    {
        $builder = $this->db->table($this->table);
        $builder->distinct();
        if (isset($data['customer_id'])) {
           $builder->where([
            'seen' => 0,
            'customer_id' => $data['customer_id']
        ]);
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 10;
            }
            $builder->limit($data['limit'], $data['start']);
        }
        
        $builder->orderBy('date_added', 'DESC');
        $builder->notLike('key', 'admin_', 'both');
        return $builder->countAllResults();
    }
    
    public function addActivity(string $key, array $data, int $seen = 0)
    {
        $builder = $this->db->table($this->table);
        $activity_data = [
            'customer_id'   => $data['customer_id'],
            'key'           => $key,
            'data'          => json_encode($data),
            'ip'            => \Config\Services::request()->getIPAddress(),
            'user_agent'    => \Config\Services::request()->getUserAgent(),
            'seen'          => $seen,
            'date_added'    => Time::now()->getTimestamp(),
        ];

        $builder->insert($activity_data);
    }

    public function AddCustomerIP(array $data)
    {
        $builder = $this->db->table($this->table_2);
        $ip_data = [
            'customer_id'   => $data['customer_id'],
            'ip'            => \Config\Services::request()->getIPAddress(),
            'user_agent'    => \Config\Services::request()->getUserAgent(),
            'date_added'    => Time::now()->getTimestamp(),
        ];

        $builder->insert($ip_data);
    }

    public function getCustomerIP(int $customer_id)
    {
        $builder = $this->db->table($this->table_2);
        $builder->where('customer_id', $customer_id);
        $query = $builder->get();
        if ($builder->countAllResults()) {
            return $query->getRowArray();
        } else {
            return;
        }
    }

    // ---------------------------------------------
}
