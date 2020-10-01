<?php namespace Catalog\Controllers\Project;

use \Catalog\Models\Catalog\CategoryModel;
use \Catalog\Models\Catalog\ProjectModel;

class Category extends \Catalog\Controllers\BaseController
{
   public function index()
    {
        $projectModel = new ProjectModel();
        $seoUrl = service('seo_url');


        $this->template->setTitle(lang('project/category.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/category.text_projects'),
            'href' => base_url('project/category'),
        ];

        if ($this->request->getVar('filter')) {
            $filter = explode(',', $this->request->getVar('filter'));
        } else {
            $filter = [];
        }
        
        if ($this->request->getVar('filter_price')) {
            $filter_price = explode(',', $this->request->getVar('filter_price'));
        } else {
            $filter_price = [];
        }

        if ($this->request->getVar('sort_by')) {
            $sortBy = $this->request->getVar('sort_by');
        } else {
            $sortBy = 'p.date_added';
        }

        if ($this->request->getVar('order_by')) {
            $orderBy = $this->request->getVar('order_by');
        } else {
            $orderBy = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 20;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $url = '';

        if ($this->request->getVar('limit')) {
            $url .= '&limit=' . $this->request->getVar('limit');
        }

        if ($this->request->getVar('sort_by')) {
            $url .= '&sort_by=' . $this->request->getVar('sort_by');
        }

        if ($this->request->getVar('order_by')) {
            $url .= '&order_by=' . $this->request->getVar('order_by');
        }

        $filter_data = [
            'sortBy'  => 'p.date_added',
            'orderBy' => 'DESC',
            'limit'   => $limit,
            'start'   => ($page - 1) * $limit,
        ];
    
        $data['projects'] = [];
        
        $results = $projectModel->getProjects($filter_data);
        $total = $projectModel->getTotalProjects();
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();
        foreach ($results as $result) {
            $data['projects'][] = [
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'description' => substr($result['description'], 0, 100) . '...',
                'meta_keyword'=> ($result['meta_keyword']) ? explode(',', $result['meta_keyword']) : '',
                'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'        => ($result['status'] == 1) ? lang('project/category.list.text_fixed_price') : lang('project/category.list.text_per_hour'),
                'date_added'  => $this->dateDifference($result['date_added']),
                'href'        => base_url('project/project?project_id=' . $result['project_id']),
            ];
        }

        $data['sorts'] = [];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_newest'),
            'value' => 'p.date_added-ASC',
            'href'  => route_to('projects') . '?sort_by=p.date_added&order_by=desc'
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_lowest'),
            'value' => 's.price-DESC',
            'href'  => base_url('service/category?category_id=' . $this->request->getVar('category_id') . '&sort_by=s.price&order_by=DESC' .$url)
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_highest'),
            'value' => 's.price-DESC',
            'href'  => base_url('service/category?category_id=' . $this->request->getVar('category_id') . '&sort_by=s.price&order_by=DESC' .$url)
        ];

        $categoryModel = new CategoryModel();

        $data['categories'] = [];
        $categories = $categoryModel->getCategories(['start' => 0, 'limit' => 5]);
        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name']
            ];
        }

        $data['text_search_keyword']  = lang('project/category.text_search_keyword');
        $data['button_search']        = lang('project/category.button_search');
        $data['text_found']           = lang('project/category.text_found', [$total]);
        $data['text_sidebar']         = lang('project/category.text_sidebar');
        $data['text_type']            = lang('project/category.text_type');
        $data['text_skills']          = lang('project/category.text_skills');
        $data['text_languages']       = lang('project/category.text_languages');
        $data['text_state']           = lang('project/category.text_state');
        $data['text_fixed_price']     = lang('project/category.text_fixed_price');
        $data['text_per_hour']        = lang('project/category.text_per_hour');
        $data['text_budget']          = lang('project/category.text_budget');
        $data['text_all_open']        = lang('project/category.text_all_open');
        $data['text_all_open_closed'] = lang('project/category.text_all_open_closed');
        $data['text_projects']        = lang('project/category.text_projects');
        $data['button_hire']          = lang('en.button_hire');
        $data['button_work']          = lang('en.button_work');
        $data['button_bid_now']       = lang('project/category.button_bid_now');

        $data['filter']   = $filter;
        $data['sort_by']  = $sortBy;
        $data['order_by'] = $orderBy;
        $data['limit']    = $limit;
        $data['page']     = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $total);

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
                    'name'        => $result['name']
                ];
            }
       }

        return $this->response->setJSON($json);
    }
    
    //--------------------------------------------------------------------
}
