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
        $builder = $this->db->table('category c');
        $builder->select('cd.category_id, cd.name, c.sort_order, c.status, cd.description, c.icon');
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $builder->where('cd.language_id', service('registry')->get('config_language_id'));
        $builder->where('c.status !=', '0');

        if (isset($data['category_id'])) {
            $builder->where('c.parent_id', $data['category_id']);
        }

        if (isset($data['filter_name'])) {
            $builder->like('cd.name', $data['filter_name'], 'after');
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('cd.category_id', 'DESC');
        } else {
            $builder->orderBy('cd.category_id', 'ASC');
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

    public function getChildrenByCategoryId($category_id)
    {
        $children_data = [];
        $builder = $this->db->table('category c');
        $builder->select('cd.category_id, cd.name');
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $builder->where('cd.language_id', service('registry')->get('config_language_id'));
        $builder->where('c.status !=', 0);
        $builder->where('c.parent_id', $category_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $children_data[] = [
                'category_id' => $result['category_id'],
                'name'        => $result['name'],
                'href'        => route_to('projects') . '?gid=' . $result['category_id'],
            ];
        }

        return $children_data;
 
    }

    public function getCategoriesByProjectId($project_id)
    {
        $builder = $this->db->table('project_to_category p2c');
        $builder->select();
        $builder->join('category_description cd', 'p2c.category_id = cd.category_id', 'left');
        $builder->where('p2c.project_id', $project_id);
        $builder->where('cd.language_id', service('registry')->get('config_language_id'));
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
