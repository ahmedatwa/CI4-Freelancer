<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Catalog\CategoryModel;

class Menu extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['categories'] = [];

        $categoryModel = new CategoryModel();

        $seoUrl = service('seo_url');
        
        $categories = $categoryModel->getCategories(['category_id' => 0]);

        foreach ($categories as $category) {

            $keyword = $seoUrl->getKeywordByQuery('category_id=' . $category['category_id']);

            // Level 2
            $children_data = [];

            $children = $categoryModel->getCategories(['category_id' => $category['category_id']]);

            foreach ($children as $child) {
                $children_data[] = [
                    'name'  => $child['name'],
                    'href'  => ($keyword) ? route_to('category', $child['category_id'], $keyword) : base_url('project/project?gid=' . $child['category_id']),
                    ];
                }

            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name'],
                'ico'         => $category['icon'],
                'children'    => $children_data,
                'href'        => ($keyword) ? route_to('category', $category['category_id'], $keyword) : base_url('project/project?gid=' . $category['category_id']),
            ];
        }

        return view('common/menu', $data);
    }


    //--------------------------------------------------------------------
}
