<?php namespace Catalog\Controllers\Project;

class Category extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('category/category.list.heading_title'));
        
        $categories_model = new \Catalog\Models\Catalog\Categories();

        if ($this->request->getGet('category_id')) {
            $category_id = $this->request->getGet('category_id');
        } else {
            $category_id = null;
        }

        $category_info = $categories_model->getCategory($category_id);

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
            'href' => base_url('project/category?category_id=' . $category_id),
        ];
    
        $filter_data = [
            'category_id' => $category_id,
            'start'       => 0,
            'limit'       => getSettingValue('config_admin_limit'),
        ];

        $data['categories'] = [];

        $results = $categories_model->getCategories($filter_data);

        $data['total_categories'] = $categories_model->getTotalCategories();
        
        foreach ($results as $result) {
            if (!empty($data['image'])) {
                $image = $this->resize($data['image'], 460, 310);
            } else {
                $image = $this->resize('no_image.jpg', 460, 310);
            }
            $data['categories'][] = [
                'category_id' => $result['category_id'],
                'name'        => $result['name'],
                'children'    => base_url('project/category?category_id=' . $result['category_id']),
                'image'       => $image,
                'href'        => base_url('project/category?category_id=' . $result['category_id']),
            ];
        }

        $paginate = $categories_model->paginate(10);
        $data['pager'] = $categories_model->pager;


        $this->template->output('project/category', $data);
    }
    
    
    //--------------------------------------------------------------------
}
