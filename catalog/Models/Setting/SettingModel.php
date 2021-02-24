<?php

namespace Catalog\Models\Setting;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table          = 'setting';
    protected $primaryKey     = 'setting_id';
    protected $returnType     = 'array';

    public function getSetting()
    {
        $setting_data = [];
        
        $builder = $this->db->table('setting');

        $builder->select();

        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            if (!$result['serialized']) {
                $setting_data[$result['name']] = $result['setting'];
            } else {
                $setting_data[$result['name']] = json_decode($result['setting'], true);
            }
        }
        return $setting_data;
    }

    public function getSettingValue($key, $site_id = 0)
    {
        $builder = $this->db->table('setting');
        $builder->select('setting');
        $builder->where('site_id', $site_id);
        $builder->where('name', $key);
        $query = $builder->get()->getRowArray();
        if ($builder) {
            return $query['setting'];
        } else {
            return null;
        }
    }
    // ----------------------------------------------------
}
