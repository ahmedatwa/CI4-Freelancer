<?php namespace Catalog\Models\Setting;

class Extensions extends \CodeIgniter\Model
{
    protected $table          = 'extension';
    protected $primaryKey     = 'extension_id';

    public function getExtensions($type)
    {
        $builder = $this->db->table($this->table);
        $builder->where('type', $type);
        $query = $builder->get();
        return $query->getResultArray();
    }

    // ----------------------------------------------------
}
