<?php 

namespace Admin\Models\Catalog;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

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
        if (isset($data['data'])) {
            $data['id'] = [
                'key'   => 'category_id',
                'value' => $data['id'][0]
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'category_add', $data['id'], $data['data']);
        }
        return $data;
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']) && isset($data['id'])) {
            $data['id'] = [
                'key'   => 'category_id',
                'value' => $data['id'][0]
            ];
            
            \CodeIgniter\Events\Events::trigger('user_activity_update', 'category_edit', $data['id'], $data['data']);
        }
        return $data;
    }

    public function editCategory($category_id, $data)
    {
        $builder = $this->db->table('category');

        $category_data = [
           'parent_id'     => $data['parent_id'],
           'top'           => $data['top'] ?? 0,
           'sort_order'    => $data['sort_order'],
           'icon'          => $data['icon'],
           'status'        => $data['status'],
           'date_added'    => Time::now()->getTimestamp(),
           'date_modified' => Time::now()->getTimestamp(),
        ];
        
        $builder->set('date_modified', 'NOW()', false);
        $builder->set($category_data);
        $builder->where('category_id', $category_id);
        $builder->update($category_data);

        // category_description Query
        if (isset($data['category_description'])) {

            $builder_description = $this->db->table('category_description');
            $builder_description->delete(['category_id' => $category_id]);
            foreach ($data['category_description'] as $language_id => $category_description) {
                $category_description_data = [
                    'category_id'      => $category_id,
                    'language_id'      => $language_id,
                    'name'             => $category_description['name'],
                    'keyword'          => generateSeoUrl($category_description['name']),
                    'description'      => $category_description['description'],
                    'meta_title'       => $category_description['meta_title'],
                    'meta_description' => $category_description['meta_description'],
                    'meta_keyword'     => $category_description['meta_keyword'],
                ];
                $builder_description->set($category_description_data);
                $builder_description->insert($category_description_data);
            }
        }
        // Event Call 
        $eventData = [
            'id' => [
                '0' => $category_id
            ],
            'data' => $category_data
        ];
        $this->afterUpdateEvent($eventData);
    }

    public function addCategory($data)
    {
        $builder = $this->db->table('category');

        $category_data = [
           'parent_id'     => $data['parent_id'],
           'top'           => $data['top'] ?? 0,
           'icon'          => $data['icon'],
           'sort_order'    => $data['sort_order'],
           'status'        => $data['status'],
           'date_added'    => Time::now()->getTimestamp(),
           'date_modified' => Time::now()->getTimestamp(),
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set($category_data);
        $builder->insert($category_data);
        // Get Last Inserted ID
        $category_id = $this->db->insertID();
        // category_description Query
        if (isset($data['category_description'])) {
            $builder_description = $this->db->table('category_description');
            $seo_url = $this->db->table('seo_url');
            $seo_url->delete(['query' => 'category_id=' . $category_id]);

            foreach ($data['category_description'] as $language_id => $category_description) {
                $category_description_data = [
                    'category_id'      => $category_id,
                    'language_id'      => $language_id,
                    'name'             => $category_description['name'],
                    'keyword'          => generateSeoUrl($category_description['name']),
                    'description'      => $category_description['description'],
                    'meta_title'       => $category_description['meta_title'],
                    'meta_description' => $category_description['meta_description'],
                    'meta_keyword'     => $category_description['meta_keyword'],
                ];
                $builder_description->set($category_description_data);
                $builder_description->insert($category_description_data);
            }
        }
        // Event Call 
        $eventData = [
            'id' => [
                '0' => $category_id
            ],
            'data' => $category_data
        ];
        $this->afterInsertEvent($eventData);
    }

    public function deleteCategory($category_id)
    {
        $builder = $this->db->table('category');
        $builder->delete(['category_id' => $category_id]);
        $builder_description = $this->db->table('category_description');
        $builder_description->delete(['category_id' => $category_id]);

    }

    public function getCategory($category_id)
    {
        $builder = $this->db->table('category c');
        $builder->select();
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $builder->where('c.category_id', $category_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getCategories(array $data = [])
    {
        $builder = $this->db->table('category c');
        $builder->distinct('cd.category_id, cd.name, c.sort_order, c.status');
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $builder->where('language_id', service('registry')->get('config_language_id'));

        if (!empty($data['filter_name'])) {
            $builder->like('cd.name', $data['filter_name'], 'after');
        }

        if (!empty($data['filter_parent_id'])) {
            $builder->where('c.parent_id', $data['filter_parent_id']);
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

    public function getCategoryParents()
    {
        $builder = $this->db->table('category c');
        $builder->select('cd.category_id, cd.name');
        $builder->join('category_description cd', 'c.category_id = cd.category_id', 'left');
        $builder->where('c.parent_id', 0);
        $builder->orderBy('cd.name', 'DESC');
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
