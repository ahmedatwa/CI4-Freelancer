<?php namespace Catalog\Models\Tool;

class Online extends \CodeIgniter\Model
{
    protected $table          = 'customer_online';
    protected $primaryKey     = 'customer_online_id';

    public function addOnline($ip, $customer_id, $url, $referer)
    {
        $builder = $this->db->table($this->table);
        $builder->where('date_added < ', date('Y-m-d H:i:s', strtotime('-1 hour')));
        $builder->delete();
        $data = [
            'ip'          => $ip,
            'customer_id' => $customer_id,
            'url'         => $url,
            'referer'     => $referer
        ];
        $builder->set('date_added', 'NOW()', false);
        $builder->replace($data);
    }


    // --------------------------------------------
}
