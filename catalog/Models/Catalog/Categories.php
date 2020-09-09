<?php namespace Catalog\Models\Catalog;

class Categories extends \CodeIgniter\Model
{
    protected $table          = 'category';
    protected $primaryKey     = 'category_id';
    protected $returnType     = 'array';

    public function getCategory($category_id)
    {
        $builder = $this->db->table('category');
        $builder->select('category.category_id, category_description.name, category.status');
        $builder->join('category_description', 'category.category_id = category_description.category_id', 'left');
        $builder->where('category.category_id', $category_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getCategories(array $data = [])
    {
        $builder = $this->db->table('category');
        $builder->select('category_description.category_id, category_description.name, category.sort_order, category.status');
        $builder->join('category_description', 'category.category_id = category_description.category_id', 'left');
        $builder->where('category_description.language_id', service('registry')->get('config_language_id'));

        if (isset($data['category_id'])) {
            $builder->where('category.parent_id', $data['category_id']);
        }

        if (isset($data['parent_id'])) {
            $builder->where('category.parent_id', $data['parent_id']);
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('category_description.name', 'DESC');
        } else {
            $builder->orderBy('category_description.name', 'ASC');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getCategoryChildren($category_id)
    {
        $children = array();

        $builder = $this->db->table('category');
        $builder->distinct('category.category_id, cd.name, category.sort_order, category.status');
        $builder->join('category_description', 'category_description.category_id = category.category_id', 'left');
        $builder->where('category_description.language_id', service('registry')->get('config_language_id'));
        $builder->where('category.parent_id', $category_id);
        $builder->where('category.parent_id !=', 0);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $children[] = [
                'name'        => $result['name'],
                'category_id' => $result['category_id']
            ];
         return $children;
        }

   
    }

    public function getTotalCategories()
    {
        $builder = $this->db->table('category');
        return $builder->countAll();
    }
    
    // -----------------------------------------------------------------
}
