<?php namespace Admin\Models\Catalog;

use CodeIgniter\Model;

class Categories extends Model
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

    public function addCategory($data)
    {
        $builder = $this->db->table('category');
        $category_data = array(
            'parent_id'  => $data['parent_id'],
            'top'        => $data['top'] ?? 0,
            //'column'     => $data['column'],
            'sort_order' => $data['sort_order'],
            'status'     => $data['status']
        );
        $builder->set('date_modified', 'NOW()', false);
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($category_data);

        $category_id = $this->db->insertID();

        // Image
        if (isset($data['image'])) {
            $builder->set('image', $data['image']);
            $builder->where('category_id', $category_id);
            $builder->update();
        }

        // category_description
        $description_builder = $this->db->table('category_description');
        $seo_url = $this->db->table('seo_url');
        foreach ($data['category_description'] as $language_id => $value) {
            $category_description_data = [
                    'category_id'      => $category_id,
                    'language_id'      => $language_id,
                    'name'             => $value['name'],
                    'description'      => $value['description'],
                    'meta_title'       => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keyword'     => $value['meta_keyword'],
            ];
            $description_builder->insert($category_description_data);
            //  Seo Urls
            $seo_url_data = [
                    'site_id'     => 0,
                    'language_id' => $language_id,
                    'query'       => 'category_id=' . $category_id,
                    'keyword'     => generateSeoUrl($value['name']),
                ];
            $seo_url->insert($seo_url_data);
        }
        return $category_id;
    }

    public function editCategory($category_id, $data)
    {
        $builder = $this->db->table('category');

        $category_data = array(
            'parent_id'  => $data['parent_id'],
            'top'        => $data['top'] ?? 0,
            'sort_order' => $data['sort_order'],
            'status'     => $data['status'],
        );
        
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('category_id', $category_id);
        $builder->update($category_data);

        // Image
        if (isset($data['image'])) {
            $builder->set('image', $data['image']);
            $builder->where('category_id', $category_id);
            $builder->update();
        }
        // category_description Query
        $description_builder = $this->db->table('category_description');
        if (isset($data['category_description'])) {
            $description_builder->delete(['category_id' => $category_id]);
            $seo_url = $this->db->table('seo_url');
            $seo_url->delete(['query=' => 'category_id=' . $category_id]);
            foreach ($data['category_description'] as $language_id => $value) {
                $category_description_data = [
                    'category_id'      => $category_id,
                    'language_id'      => $language_id,
                    'name'             => $value['name'],
                    'description'      => $value['description'],
                    'meta_title'       => $value['meta_title'],
                    'meta_description' => $value['meta_description'],
                    'meta_keyword'     => $value['meta_keyword'],
                ];
                $description_builder->insert($category_description_data);
                //  Seo Urls
                $seo_url_data = [
                        'site_id'     => 0,
                        'language_id' => $language_id,
                        'query'       => 'category_id=' . $category_id,
                        'keyword'     => generateSeoUrl($value['name']),
                    ];
                $seo_url->insert($seo_url_data);
            }
        }
    }

    public function deleteCategory($category_id)
    {
        $category = $this->db->table('category');
        $category->delete(['category_id' => $category_id]);
        $category_description = $this->db->table('category_description');
        $category_description->delete(['category_id' => $category_id]);
        // $category_to_layout = $this->db->table('category_to_layout');
        // $category_to_layout->delete(['category_id' => $category_id]);
        $project_to_category = $this->db->table('project_to_category');
        $project_to_category->delete(['category_id' => $category_id]);
        $seo_url = $this->db->table('seo_url');
        $seo_url->delete(['query' => 'category_id=' . $category_id]);
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
