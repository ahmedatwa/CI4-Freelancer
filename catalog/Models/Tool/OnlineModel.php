<?php 

namespace Catalog\Models\Tool;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class OnlineModel extends Model
{
    protected $table          = 'customer_online';
    protected $primaryKey     = 'customer_online_id';

    public function addOnline($ip, $customer_id, $url, $referer)
    {
        $builder = $this->db->table($this->table);
        $builder->where('date_added < ', date('Y-m-d H:i:s', strtotime('-1 hour')));
        $builder->delete();
        $online_data = [
            'ip'          => $ip,
            'customer_id' => $customer_id,
            'url'         => $url,
            'referer'     => $referer,
            'date_added'  => Time::now()->getTimestamp(),
        ];
        $builder->replace($online_data);
    }


    // --------------------------------------------
}
