<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Catalog\CategoryModel;

class Menu extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['categories'] = [];

        $categoryModel = new CategoryModel();
        
        $categories = $categoryModel->getCategories(['category_id' => 0]);

        foreach ($categories as $category) {

            // Level 2
            $children_data = [];

            $children = $categoryModel->getCategories(['category_id' => $category['category_id']]);

            foreach ($children as $child) {
                $children_data[] = [
                    'name'  => $child['name'],
                    'href'  => route_to('projects') . '?gid=' . $child['category_id']
                    ];
                }

            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name'],
                'ico'         => $category['icon'],
                'children'    => $children_data,
                'href'        => (route_to('projects') . '?gid=' . $category['category_id']) ? route_to('projects') . '?gid=' . $category['category_id'] : base_url('project/project?gid=' . $category['category_id']),
            ];
        }

        return view('common/menu', $data);
    }


    //--------------------------------------------------------------------
}
