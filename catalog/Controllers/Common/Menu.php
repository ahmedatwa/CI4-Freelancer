<?php namespace Catalog\Controllers\Common;

class Menu extends \Catalog\Controllers\BaseController
{
    public function index()
    {

        $data['categories'] = [];

        $categoryModel = new \Catalog\Models\Catalog\CategoryModel();
        
        $results = $categoryModel->getCategories();

        foreach ($results as $result) {
            $data['categories'][] = [
                'name'     => $result['name'],
                'icon'     => $result['icon'],
                'children' => $categoryModel->getChildrenByCategoryId($result['category_id']),
                'href'        => (route_to('projects') . '?gid=' . $result['category_id']) ? route_to('projects') . '?gid=' . $result['category_id'] : base_url('project/project?gid=' . $result['category_id']),
            ];
        }


        return view('common/menu', $data);
    }


    //--------------------------------------------------------------------
}
