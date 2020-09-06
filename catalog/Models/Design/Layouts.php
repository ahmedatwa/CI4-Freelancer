<?php namespace Catalog\Models\Design;

class Layouts extends \CodeIgniter\Model
{
    public function getLayout($route)
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

    public function getLayoutModules($layout_id)
    {
        $builder = $this->db->table('layout_module');
        $builder->select()
                ->where('layout_id', $layout_id)
                ->orderBy('position ASC, sort_order ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }


    // --------------------------------------------------------
}
