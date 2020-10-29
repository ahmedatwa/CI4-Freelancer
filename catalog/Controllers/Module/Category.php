<?php namespace Catalog\Controllers\Module;

use \Catalog\Models\Catalog\CategoryModel;

class Category extends \Catalog\Controllers\BaseController
{
	public function index() {

		$data['heading_title'] = lang('module/category.heading_title');

        $filter_data = [
			'limit'             => 8,
			'start'             => 0,
        ];
        
        $data['categories'] = [];

        $categoryModel = new CategoryModel();

        $results = $categoryModel->getCategories($filter_data);

        foreach ($results as $result) {
            $data['categories'][] = [
                'name'     => $result['name'],
                'total'    => $categoryModel->getTotalProjectsByCategoryId($result['category_id']),
                'icon'     => $result['icon'],
                'href'        => (route_to('projects') . '?gid=' . $result['category_id']) ? route_to('projects') . '?gid=' . $result['category_id'] : base_url('project/project?gid=' . $result['category_id']),
            ];
        }

		return view('module/category', $data);
	}
}