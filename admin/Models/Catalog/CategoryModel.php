<?php namespace Admin\Models\Catalog;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table          = 'category';
    protected $primaryKey     = 'category_id';
    protected $returnType     = 'array';
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        }
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        }
    }


    public function getCategory($category_id)
    {
        $builder = $this->db->table('category c');
        $builder->distinct('cd.category_id, cd.name, c.sort_order, c.status');
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getCategories(array $data = [])
    {
        $builder = $this->db->table('category c');
        $builder->distinct('cd.category_id, cd.name, c.sort_order, c.status');
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $builder->where('language_id', \Admin\Libraries\Registry::get('config_language_id'));

        if (!empty($data['filter_name'])) {
            $builder->like('cd.name', $data['filter_name'], 'both');
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('cd.name', 'DESC');
        } else {
            $builder->orderBy('cd.name', 'ASC');
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

    public function getCategoryDescriptions($category_id)
    {
        $category_description_data = [];

        $builder = $this->db->table('category_description');
        $builder->select()->where('category_id', $category_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $category_description_data[$result['language_id']] = [
                'name'             => $result['name'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
                'description'      => $result['description']
            ];
        }

        return $category_description_data;
    }
    
    public function getParentByCategoryId($category_id)
    {
        $builder = $this->db->table('category c');
        $builder->select('cd.name');
        $builder->join('category_description cd', 'c.parent_id = cd.category_id', 'left');
        $builder->where('c.category_id', $category_id);
        $row = $builder->get()->getRowArray();
        if ($row['name']) {
            return $row['name'] . ' <i class="fas fa-angle-right"></i> ';
        } else {
            return '';
        }
    }
    
    public function getCategoryLayouts($category_id)
    {
        $category_layout_data = array();

        $builder = $this->db->table('category_to_layout');
        $builder->select()->where('category_id', $category_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $category_layout_data[$result['store_id']] = $result['layout_id'];
        }

        return $category_layout_data;
    }
    
    public function getTotalCategoriesByLayoutId($layout_id)
    {
        $builder = $this->db->table('category');
        $builder->where('layout_id', $layout_id);
        return $builder->countAllResults();
    }



    // -----------------------------------------------------------------
}
