<?php namespace Catalog\Models\Design;

class Banners extends \CodeIgniter\Model
{
    public function getBanner($banner_id)
    {
        $builder = $this->db->table('banner b');
        $builder->join('banner_image bi', 'b.banner_id = bi.banner_id', 'left');
        $builder->distinct();
        $builder->where('b.banner_id', $banner_id);
        $builder->where('b.status', 1);
        $builder->where('bi.language_id', 1);

        $query = $builder->get();
        return $query->getRowArray();
    }

    // -------------------------------------------------
}
