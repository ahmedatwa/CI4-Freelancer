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
        $seoUrl = service('seo_url');

        $results = $categoryModel->getCategories($filter_data);

        foreach ($results as $result) {
            $keyword = $seoUrl->getKeywordByQuery('category_id=' . $result['category_id']);
            $data['categories'][] = [
                'name'  => $result['name'],
                'total' => $categoryModel->getTotalProjectsByCategoryId($result['category_id']),
                'icon'  => $result['icon'],
                'href'  => ($keyword) ? route_to('category', $result['category_id'], $keyword) : base_url('project/project/category?gid=' . $result['category_id']),
            ];
        }

		return view('module/category', $data);
	}
}