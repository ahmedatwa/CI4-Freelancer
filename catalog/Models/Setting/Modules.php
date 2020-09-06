<?php namespace Catalog\Models\Setting;

use CodeIgniter\Model;

class Modules extends Model
{
    public function getModule($module_id)
    {
        $builder = $this->db->table('module');
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


    // ----------------------------------------------------
}
