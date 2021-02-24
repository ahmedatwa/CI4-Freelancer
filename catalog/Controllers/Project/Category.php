<?php 

namespace Catalog\Controllers\Project;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\CategoryModel;

class Category extends BaseController
{
   public function index()
    {
        $categoryModel = new CategoryModel();

        $seoUrl = service('seo_url');

        $this->template->setTitle(lang('project/category.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/category.text_by'),
            'href' => route_to('categories') ? route_to('categories') : base_url('project/category'),
        ];

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'c.category_id';
        }
       
        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'ASC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = $this->registry->get('theme_default_projects_limit') ?? 15;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
            'category_id'   => 0,
            'sort_by'       => $sort_by,
            'order_by'      => $order_by,
            'limit'         => $limit,
            'start'         => ($page - 1) * $limit,
        ];
    
        $data['categories'] = [];
        
        $results = $categoryModel->getCategories($filter_data);

        $total = $categoryModel->getTotalCategories();

        foreach ($results as $result) {
            
            $keyword = $seoUrl->getKeywordByQuery('category_id=' . $result['category_id']);

            $children = $categoryModel->getCategories([
                'category_id' => $result['category_id'],
            ]);

            $children_data = [];
            
            foreach ($children as $child) {
                $keyword_2 = $seoUrl->getKeywordByQuery('category_id=' . $child['category_id']);

                $children_data[] = [
                    'category_id' => $child['category_id'],
                    'parent_id'   => $child['parent_id'],
                    'name'        => $child['name'],
                    'icon'        => $child['icon'],
                    'description' => $child['description'],
                    'href'        => ($keyword_2) ? route_to('category', $child['category_id'], $keyword_2) : base_url('project/project/category?gid=' . $child['category_id']),
                ];
            }

            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $result['name'],
                'icon'        => $result['icon'],
                'description' => word_limiter(strip_tags($result['description']), 10),
                'href'        => ($keyword) ? route_to('category', $result['category_id'], $keyword) : base_url('project/project/category?gid=' . $result['category_id']),
                'children'    => $children_data,
            ];
        }

        $data['heading_title'] = lang('project/category.heading_title');
        $data['text_by'] = lang('project/category.text_by');

        $data['add_project'] = base_url('project/project/add');
        $data['login']       = base_url('account/login');

        $data['sort_by']       = $sort_by;
        $data['order_by']      = $order_by;
        $data['limit']         = $limit;
        $data['page']          = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        $this->template->output('project/category', $data);
    }
    
    public function autocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_category')) {
            $categoryModel = new CategoryModel();

            if ($this->request->getVar('filter_category')) {
                $filter_name = html_entity_decode($this->request->getVar('filter_category'), ENT_QUOTES, 'UTF-8');
            } else {
                $filter_name = null;
            }

            $filter_data = [
                'filter_name' => $filter_name,
                'start' => 0,
                'limit' => 5,
            ];

            $results = $categoryModel->getCategories($filter_data);

            foreach ($results as $result) {
                $json[] = [
                    'category_id' => $result['category_id'],
                    'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                ];
            }
       }

        return $this->response->setJSON($json);
    }
    
    //--------------------------------------------------------------------
}
