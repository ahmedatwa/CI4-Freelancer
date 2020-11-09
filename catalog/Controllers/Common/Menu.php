<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Catalog\CategoryModel;

class Menu extends \Catalog\Controllers\BaseController
{
    public function index()
    {

        $data['categories'] = [];

        $categoryModel = new CategoryModel();
        
        $filter_data = [
            'category_id' => 0,
        ];

        $results = $categoryModel->getCategories($filter_data);

        foreach ($results as $result) {

                // Level 2
                $children_data = [];

                $children = $categoryModel->getCategories(['category_id' => $result['category_id']]);

                foreach ($children as $child) {

                    $children_data[] = [
                        'name'  => $child['name'],
                        'href'  => route_to('projects') . '?gid=' . $result['category_id']
                    ];
             }

            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $result['name'],
                'ico'         => $result['icon'],
                'children'    => $children_data,
                'href'        => (route_to('projects') . '?gid=' . $result['category_id']) ? route_to('projects') . '?gid=' . $result['category_id'] : base_url('project/project?gid=' . $result['category_id']),
            ];
        }

        return view('common/menu', $data);
    }


    //--------------------------------------------------------------------
}
