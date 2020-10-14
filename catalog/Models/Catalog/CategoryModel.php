<?php namespace Catalog\Models\Catalog;

class CategoryModel extends \CodeIgniter\Model
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
        $builder->where('category.status !=', '0');

        if (isset($data['category_id'])) {
            $builder->where('category.parent_id', $data['category_id']);
        }

        if (isset($data['filter_name'])) {
            $builder->like('category_description.name', $data['filter_name'], 'both');
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

    public function getCategoriesByProjectId($project_id)
    {
        $builder = $this->db->table('project_to_category p2c');
        $builder->select('name');
        $builder->join('category_description cd', 'p2c.category_id = cd.category_id', 'left');
        $builder->where('p2c.project_id', $project_id);
        $query = $builder->get();
        return $query->getResultArray();
         
    }

    public function getCategoryByProjectId($project_id)
    {
        $builder = $this->db->table('project_to_category p2c');
        $builder->select('name');
        $builder->join('category_description cd', 'p2c.category_id = cd.category_id', 'left');
        $builder->where('p2c.project_id', $project_id);
        $query = $builder->get()
                         ->getRowArray();
        return $query['name'];                 
         
    }

    public function getTotalProjectsByCategoryId($category_id)
    {
        $builder = $this->db->table('project_to_category');
        $builder->where('category_id', $category_id);
        return $builder->countAllResults();
    }

    public function getTotalCategories()
    {
        $builder = $this->db->table('category');
        return $builder->countAll();
    }
    
    // -----------------------------------------------------------------
}
