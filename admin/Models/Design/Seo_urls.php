<?php namespace Admin\Models\Design;

use CodeIgniter\Model;

class Seo_urls extends Model
{
    protected $table          = 'seo_url';
    protected $primaryKey     = 'seo_url_id';
    protected $returnType     = 'array';
    
    public function getSeoUrls(array $data = [])
    {
        $builder = $this->db->table('seo_url su');
        $builder->join('language l', 'su.language_id = l.language_id', 'left');
        $builder->select('l.name AS language, su.seo_url_id, su.query, su.keyword');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getKeywordByQuery($query)
    {
        $keywords = array();

        $builder = $this->db->table($this->table);
        $builder->where('query', $query);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $keywords[$result['language_id']] = array(
                    'keyword' => $result['keyword'],
            );
        }
        return $keywords;
        
    }
    
    public function getSeoUrlsByQuery($keyword)
    {
        $builder = $this->db->table($this->table);
        $builder->where('keyword', $keyword);
        $query = $builder->get();
        return $query->getResultArray();
    }


    // --------------------------------------------------------------------
}
