<?php 

namespace Admin\Models\Design;

use CodeIgniter\Model;

class LayoutModel extends Model
{
    protected $table          = 'layout';
    protected $primaryKey     = 'layout_id';
    protected $returnType     = 'array';

    public function addLayout($data)
    {
        $builder = $this->db->table($this->table);
        $builder->set('name', $data['name']);
        $builder->insert();

        $layout_id = $this->db->insertID();

        if (isset($data['layout_route'])) {
            $layout_route = $this->db->table('layout_route');
                $layout_data = [
                    'layout_id' => $layout_id,
                    'site_id'   => 0,
                    'route'     => $data['layout_route']
                ];

            $layout_route->insert($layout_data);
        }

        if (isset($data['layout_module'])) {
            $layout_module = $this->db->table('layout_module');
            foreach ($data['layout_module'] as $module) {
                $layout_module_data = array(
                    'layout_id'  => $layout_id,
                    'code'       => $module['code'],
                    'position'   => $module['position'],
                    'sort_order' => $module['sort_order']
                );
            $layout_module->insert($layout_module_data);
            }
        }

        return $layout_id;
    }

    public function editLayout($layout_id, $data)
    {
        $builder = $this->db->table($this->table);
        $builder->set('name', $data['name']);
        $builder->where('layout_id', $layout_id);
        $builder->update();

        // Layout Routes
        $routes = $this->db->table('layout_route');
        $routes->delete(['layout_id' => $layout_id]);

        if (isset($data['layout_route'])) {
                $layout_route_data = [
                    'layout_id' => $layout_id,
                    'site_id'   => 0,
                    'route'     => $data['layout_route']
                ];
            $routes->insert($layout_route_data);
        }

        // Layout Module
        $layout_module = $this->db->table('layout_module');
        $layout_module->delete(['layout_id' => $layout_id]);

        if (isset($data['layout_module'])) {
            foreach ($data['layout_module'] as $module) {
                $layout_module_data = array(
                    'layout_id'  => $layout_id,
                    'code'       => $module['code'],
                    'position'   => $module['position'],
                    'sort_order' => $module['sort_order']
                );
                $layout_module->insert($layout_module_data);
            }
        }
    }

    public function deleteLayout($layout_id)
    {
        $builder = $this->db->table('layout');
        $builder->delete(['layout_id' => $layout_id]);
        $layout_route = $this->db->table('layout_route');
        $layout_route->delete(['layout_id' => $layout_id]);
        $layout_module = $this->db->table('layout_module');
        $layout_module->delete(['layout_id' => $layout_id]);
        // $category_to_layout = $this->db->table('category_to_layout');
        // $category_to_layout->delete(['layout_id' => $layout_id]);
        // $product_to_layout = $this->db->table('product_to_layout');
        // $product_to_layout->delete(['layout_id' => $layout_id]);
        // $information_to_layout = $this->db->table('information_to_layout');
        // $information_to_layout->delete(['layout_id' => $layout_id]);
    }

    public function getLayouts(array $data = [])
    {
        $builder = $this->db->table($this->table);

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $builder->orderBy($data['sort']);
        } else {
            $builder->orderBy('name');
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

    public function getLayout(int $layout_id)
    {
        $builder = $this->db->table($this->table);
        $builder->distinct()->where('layout_id', (int) $layout_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getLayoutRoutes(int $layout_id)
    {
        $builder = $this->db->table('layout_route');
        $builder->select()->where('layout_id', (int) $layout_id);
        $query = $builder->get();
        $row = $query->getRow();
        if ($row) {
           return $row->route;
        } else {
           return ''; 
        }
    }

    public function getLayoutModules(int $layout_id)
    {
        $builder = $this->db->table('layout_module');
        $builder->select()
                ->where('layout_id', (int) $layout_id)
                ->orderBy('position ASC, sort_order ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getTotalLayouts()
    {
        $builder = $this->db->table($this->table);
        return $builder->countAllResults();
    }



    // --------------------------------------------------------
}
