<?php namespace Catalog\Models\Localisation;

class Language extends \CodeIgniter\Model
{
    public function getLanguageByCode($code)
    {
        $builder = $this->db->table('language');
        $builder->select();
        $builder->where('code', $code);
        $query = $builder->get();
        return $query->getRowArray();
    }

    // -------------------------------------------------
}
