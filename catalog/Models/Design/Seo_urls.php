<?php namespace Catalog\Models\Design;

class Seo_urls extends \CodeIgniter\Model
{
    public function getQueryByKeyword($keyword)
    {
        $builder = $this->db->table('seo_url');
        $builder->where('keyword', $keyword);
        $builder->where('language_id', \Catalog\Libraries\Registry::get('config_language_id'));
        $row = $builder->get()->getRowArray();
        if ($row) {
             return $row['query'];
         } else {
            return null;
         }
    }

    public function getKeywordByQuery($query)
    {
       $builder = $this->db->table('seo_url');
       $builder->where('query', $query);
       $builder->where('language_id', \Catalog\Libraries\Registry::get('config_language_id'));
       $row = $builder->get()->getRowArray();
        if ($row) {
             return $row['keyword'];
         } else {
            return null;
         }

    }    

    // --------------------------------------------------------------------
}
