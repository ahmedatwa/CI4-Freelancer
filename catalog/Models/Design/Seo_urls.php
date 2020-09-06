<?php namespace Catalog\Models\Design;

use CodeIgniter\Model;

class Seo_urls extends Model
{
    // public function getIdByKeyword($keyword)
    // {
    //     $builder = $this->db->table('seo_url');
    //     $builder->where('keyword', $keyword);
    //     $row = $builder->get()->getRowArray();
    //     if ($row) {
    //          $query = explode('=', $row['query']);
    //          return $query[1];
    //      } else {
    //         return null;
    //      }
    // }

    public function getSeoUrlByKeyword($keyword)
    {
        $builder = $this->db->table('seo_url');
        $builder->select()
            ->where('keyword', $keyword)
            ->where('site_id', 0)
            ->where('language_id', getSettingValue('config_language_id'));
        $query = $builder->get();
        return $query->getRowArray();
    }

    // public function getSeoProfilesByKey($key) {
    //     if (!isset($this->profile[$key])) {
    //         $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "seo_profile` WHERE `key` = '" . $this->db->escape((string)$key) . "'");

    //         $this->profile[$key] = $query->rows;
    //     }

    //     return $this->profile[$key];
    // }

    public function getKeywordByQuery($query)
    {
        $builder = $this->db->table('seo_url');
        $builder->where('query', $query);
        $builder->where('language_id', getSettingValue('config_language_id'));
        $row = $builder->get()->getRowArray();
        return $row['keyword'];
    }
    

    // --------------------------------------------------------------------
}
