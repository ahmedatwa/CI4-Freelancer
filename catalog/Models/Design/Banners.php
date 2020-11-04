<?php namespace Catalog\Models\Design;

class Banners extends \CodeIgniter\Model
{
    public function getBanner($banner_id)
    {
        $builder = $this->db->table('banner b');
        $builder->select();
        $builder->join('banner_image bi', 'b.banner_id = bi.banner_id', 'left');
        $builder->where([
            'b.banner_id' => $banner_id,
            'b.status' => 1,
            'bi.language_id' => service('registry')->get('config_language_id')
        ]);

        $builder->orderBy('bi.sort_order', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    // -------------------------------------------------
}
