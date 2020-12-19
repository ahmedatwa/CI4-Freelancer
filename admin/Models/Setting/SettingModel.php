<?php namespace Admin\Models\Setting;

class SettingModel extends \CodeIgniter\Model
{
    protected $table          = 'setting';
    protected $primaryKey     = 'setting_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['site_id', 'code', 'name', 'setting', 'serialized'];
    protected $useTimestamps  = true;
    protected $afterUpdate = ['afterUpdateEvent'];

    protected function afterUpdateEvent(array $data)
    {
        \CodeIgniter\Events\Events::trigger('user_activity_update', 'Setting');
    }

    public function getSetting()
    {
        $setting_data = [];
        
        $builder = $this->db->table($this->table);
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

    public function editSetting(string $code, array $data = [], int $site_id = 0)
    {
        $builder = $this->db->table($this->table);
        $builder->delete(['site_id' => $site_id, 'code' => $code]);

        foreach ($data as $key => $value) {
            if (substr($key, 0, strlen($code)) == $code) {
                if (!is_array($value)) {
                    $setting  = $value;
                    $serialized = 0;
                } else {
                    $setting  = json_encode($value);
                    $serialized = 1;
                }
                $setting_data = [
                    'site_id'    => $site_id,
                    'code'       => $code,
                    'name'       => $key,
                    'setting'    => $setting,
                    'serialized' => $serialized,
                ];
                $builder->insert($setting_data, true);
            }
        }
    }


    // ----------------------------------------------------
}
