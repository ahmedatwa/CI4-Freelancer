<?php 

namespace Catalog\Models\Design;

use CodeIgniter\Model;

class SeoUrlModel extends Model
{
    public function getQueryByKeyword(string $keyword)
    {
        $builder = $this->db->table('seo_url');
        $builder->where('keyword', $keyword);
        $builder->where('language_id', service('registry')->get('config_language_id'));
        $row = $builder->get()
                       ->getRowArray();
        if ($row) {
             return $row['query'];
         } else {
            return null;
         }
    }

    public function getKeywordByQuery(string $query)
    {
       $builder = $this->db->table('seo_url');
       $builder->where('query', $query);
       $builder->where('language_id', service('registry')->get('config_language_id'));
       $row = $builder->get()->getRowArray();
        if ($row) {
             return $row['keyword'];
         } else {
            return null;
         }

    }    

    // --------------------------------------------------------------------
}
