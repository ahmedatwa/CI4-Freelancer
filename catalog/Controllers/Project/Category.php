<?php namespace Catalog\Controllers\Project;

use \Catalog\Models\Catalog\CategoryModel;

class Category extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('category/category.heading_title'));
        
        $categoryModel = new CategoryModel();

        if ($this->request->getGet('category_id')) {
            $category_id = $this->request->getGet('category_id');
        } else {
            $category_id = null;
        }

        $category_info = $categoryModel->getCategory($category_id);

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/category.list.text_categories'),
            'href' => base_url('project/category'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $category_info['name'],
            'href' => route_to('category', $category_id),
        ];
    
        $filter_data = [
            'category_id' => $category_id,
            'start'       => 0,
            'limit'       => $this->registry->get('config_admin_limit'),
        ];

        $data['categories'] = [];

        $results = $categoryModel->getCategories($filter_data);

        $data['total_categories'] = $categoryModel->getTotalCategories();
        
        foreach ($results as $result) {
            if (!empty($data['image'])) {
                $image = $this->resize($data['image'], 460, 310);
            } else {
                $image = $this->resize('no_image.jpg', 460, 310);
            }
            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $result['name'],
                'children'    => route_to('project', getKeywordByQuery('category_id=' . $result['category_id'])),
                'image'       => $image,
                'href'        => route_to('category', getKeywordByQuery('category_id=' . $result['category_id'])),
            ];
        }

        $paginate = $categoryModel->paginate(10);
        $data['pager'] = $categoryModel->pager;


        $this->template->output('project/category', $data);
    }
    
    
    //--------------------------------------------------------------------
}
