<?php namespace Catalog\Models\Setting;

use CodeIgniter\Model;

class Settings extends Model
{
    protected $table          = 'setting';
    protected $primaryKey     = 'setting_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['site_id', 'code', 'name', 'setting', 'serialized'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // User Activity Events
    //protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];

    protected function afterUpdateEvent(array $data)
    {
        \CodeIgniter\Events\Events::trigger('user_activity_update', 'Setting');
    }

    public function getSetting()
    {
        $setting_data = array();
        
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

    public function getSettingValue($key, $site_id = 0) {
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
