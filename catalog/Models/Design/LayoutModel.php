<?php

namespace Catalog\Models\Design;

use CodeIgniter\Model;

class LayoutModel extends Model
{
    protected $layoutRouteTable = 'layout_route';
    protected $layoutModuleTable = 'layout_module';

    public function getLayout(string $route): int
    {
        $builder = $this->db->table($this->layoutRouteTable);
        $builder->select()
                ->like('route', $route)
                ->orderBy('route', 'DESC', 'before')
                ->limit(1);
        $query = $builder->get();
        
        if ($row = $query->getRow()) {
            return $row->layout_id;
        } else {
            return 1;
        }
    }

    public function getLayoutModules(int $layout_id, string $position): array
    {
        $builder = $this->db->table($this->layoutModuleTable);
        $builder->select()
                ->where('layout_id', $layout_id)
                ->where('position', $position)
                ->orderBy('position ASC, sort_order ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }


    // --------------------------------------------------------
}
