<?php namespace Admin\Models\Setting;

class Extensions extends \CodeIgniter\Model
{
    protected $table          = 'extension';
    protected $primaryKey     = 'extension_id';

    public function getInstalled(string $type)
    {
        $extension_data = [];
        $builder = $this->db->table($this->table);
        $builder->select()
                ->where('type', $type)->orderBy('code');
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $extension_data[] = $result['code'];
        }
        return $extension_data;
    }

    public function install(string $type, string $code)
    {
        $builder = $this->db->table($this->table);
        if (!in_array($code, $this->getInstalled($type))) {
            $data = [
            'type' => $type,
            'code' => $code
        ];
        $builder->set($data)
                ->insert();
        }
    }

    public function uninstall(string $type, string $code)
    {
        $extension = $this->db->table($this->table);
        $extension->delete(['type' => $type, 'code' => $code]);
        $setting = $this->db->table('setting');
        $setting->delete(['code' => $type . '_' . $code]);
    }

    // ----------------------------------------------------
}
