<?php 

namespace Catalog\Models\Setting;

use CodeIgniter\Model;

class ExtensionModel extends Model
{
    protected $table          = 'extension';
    protected $primaryKey     = 'extension_id';

    public function getExtensions(string $type)
    {
        $builder = $this->db->table($this->table);
        $builder->where('type', $type);
        $query = $builder->get();
        return $query->getResultArray();
    }

    // ----------------------------------------------------
}
