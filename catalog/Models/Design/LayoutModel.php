<?php 

namespace Catalog\Models\Design;

use CodeIgniter\Model;

class LayoutModel extends Model
{
    public function getLayout(string $route)
    {
        $builder = $this->db->table('layout_route');
        $builder->select()->like('route', $route)
        		->where('site_id', 0)
        		->orderBy('route', 'DESC')->limit(1);
        $row = $builder->get()
        			   ->getRowArray();
        if ($row) {
            return $row['layout_id'];
        } else {
            return 0;
        }
    }

    public function getLayoutModules(int $layout_id, string $position)
    {
        $builder = $this->db->table('layout_module');
        $builder->select()
                ->where('layout_id', $layout_id)
                ->where('position', $position)
                ->orderBy('position ASC, sort_order ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }


    // --------------------------------------------------------
}
