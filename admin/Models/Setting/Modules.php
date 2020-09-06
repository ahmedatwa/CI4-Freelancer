<?php namespace Admin\Models\Setting;

use CodeIgniter\Model;

class Modules extends Model
{
    protected $table          = 'module';
    protected $primaryKey     = 'module_id';

    public function addModule($code, $data)
    {
        $builder = $this->db->table($this->table);
        $module_data = array(
            'name'    => $data['name'],
            'code'    => $code,
            'setting' => json_encode($data)
        );
        $builder->insert($module_data, true);
    }

    public function editModule(int $module_id, $data)
    {
        $builder = $this->db->table($this->table);
        $builder->where('module_id', $module_id);
        $module_data = array(
            'name' => $data['name'],
            'setting' => json_encode($data)
        );
        $builder->update($module_data);
    }

    public function deleteModule($module_id)
    {
        // Modules
        $builder = $this->db->table($this->table);
        $builder->delete(['module_id' => $module_id]);
        // Layout Module
        $layout_module = $this->db->table('layout_module');
        $layout_module->delete(['code', $module_id]);
    }

    public function getModule($module_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('module_id', $module_id);
        $query = $builder->get();
        $row  = $query->getRowArray();
        if ($row) {
            return json_decode($row['setting'], true);
        } else {
            return array();
        }
    }

    public function getModulesByCode($code)
    {
        $builder = $this->db->table($this->table);
        $builder->select();
        $builder->where('code', $code)->orderBy('name');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function deleteModulesByCode($code)
    {
        // Modules
        $builder = $this->db->table($this->table);
        $builder->delete(['code' => $code]);
        // Layout Modules
        $layout_module = $this->db->table('layout_module');
        $layout_module->where('code', $code)->delete();
    }

    // ----------------------------------------------------
}
