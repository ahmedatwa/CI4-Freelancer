<?php namespace Catalog\Models\Localization;

class LanguageModel extends \CodeIgniter\Model
{
	protected $table      = 'language';
	protected $primaryKey = 'language_id';
	protected $returnType = 'array';

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
