<?php 

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\CategoryModel;

class Menu extends BaseController
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

                $childKeyword = $seoUrl->getKeywordByQuery('category_id=' . $child['category_id']);

                $children_data[] = [
                    'name'  => $child['name'],
                    'href'  => ($childKeyword) ? route_to('projects', $child['category_id'], $childKeyword . '?skills=' . $child['category_id']) : base_url('project/project/list?gid=' . $child['category_id'] . '&skills=' . $child['category_id'])
                ];
                }

            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name'],
                'ico'         => $category['icon'],
                'children'    => $children_data,
                'href'        => ($keyword) ? route_to('projects', $category['category_id'], $keyword . '?skills=' . $category['category_id']) : base_url('project/project/list?gid=' . $category['category_id'] . '&skills=' . $category['category_id'])
            ];
        }

        return view('common/menu', $data);
    }

    //--------------------------------------------------------------------
}