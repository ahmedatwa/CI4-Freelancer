<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Catalog\ProjectModel; 

class Search extends \Catalog\Controllers\BaseController
{
    public function index()
    {

        $projectModel = new ProjectModel();

        if ($this->request->getVar('keyword')) {
            $filter_keyword = $this->request->getVar('keyword');
        } else {
            $filter_keyword = '';
        }

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

        $filter_data = array(
            'filter_keyword'=> $filter_keyword,
            'filter' => $filter,
            'filter_price' => $filter_price,
            'sort_by'      => $sortBy,
            'order_by'     => $orderBy,
            'limit'        => $limit,
            'start'        => ($page - 1) * $limit,
        );

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('common/search.text_home'),
            'href' => base_url(),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('common/search.text_search'),
            'href' => base_url('common/search?keyword=' . $this->request->getVar('keyword')),
        ];

        if ($orderBy == 'DESC') {
            $orderBy = '&order_by=ASC';
        } else {
            $orderBy = '&order_by=DESC';
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

        $data['projects'] = [];        
        $results = $projectModel->getProjects($filter_data);
        $projects_total = $projectModel->getTotalProjects();

        foreach ($results as $result) {
            $data['projects'][] = [  
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'description' => substr($result['description'], 0, 100) . '...',
                'tags'        => ($result['tags']) ? explode(',', $result['tags']) : '',
                'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'        => ($result['status'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'date_added'  => $this->dateDifference($result['date_added']),
                'href'        => route_to('project', getKeywordByQuery('project_id=' . $result['project_id'])),
            ];
        }

        $data['sorts'] = [];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_newest'),
            'value' => 'p.date_added-ASC',
            'href'  => route_to('projects') . $this->request->getVar('category_id') . '&sort_by=s.price&order_by=ASC' . $url)
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



        $url = '';

        if ($this->request->getVar('sort_by')) {
            $url .= '&sort_by=' . $this->request->getVar('sort_by');
        }

        if ($this->request->getVar('order_by')) {
            $url .= '&order_by=' . $this->request->getVar('order_by');
        }

        $data['limits'] = [];

        $limits = array_unique(array(20, 25, 50, 75, 100));

        sort($limits);

        foreach ($limits as $value) {
            $data['limits'][] = array(
                'text'  => sprintf(lang('common/search.text_per_page'), $value),
                'value' => $value,
                'href'  => base_url('service/category?category_id=' . $this->request->getVar('category_id') . $url . '&limit=' . $value)
            );
        }

        $data['skills'] = [];

        $projectModel->get

        $data['heading_title']    = lang('common/search.heading_title');
        $data['text_price']       = lang('common/search.text_price');
        $data['text_sort']        = lang('common/search.text_sort');
        $data['text_default']     = lang('common/search.text_default');
        $data['text_name_asc']    = lang('common/search.text_name_asc');
        $data['text_name_desc']   = lang('common/search.text_name_desc');
        $data['text_price_asc']   = lang('common/search.text_price_asc');
        $data['text_price_desc']  = lang('common/search.text_price_desc');
        $data['text_rating_asc']  = lang('common/search.text_rating_asc');
        $data['text_rating_desc'] = lang('common/search.text_rating_desc');
        $data['text_limit']       = lang('common/search.text_limit');
        $data['text_grid']        = lang('common/search.text_grid');
        $data['text_list']        = lang('common/search.text_list');
        $data['text_new']         = lang('common/search.text_new');
        $data['text_recent']      = lang('common/search.text_recent');
        $data['text_featured']    = lang('common/search.text_featured');
        $data['text_search']      = lang('common/search.text_search');
        $data['text_categories']  = lang('common/search.text_categories');
        $data['text_empty']       = lang('common/search.text_empty');

        $data['button_cart']      = lang('common/search.button_cart');
        $data['button_list']      = lang('common/search.button_list');
        $data['button_search']    = lang('common/search.button_search');
        $data['button_grid']      = lang('common/search.button_grid');
        $data['button_more_info'] = lang('common/search.button_more_info');    
        
        $data['filter']   = $filter;
        $data['filter_keyword']   = $filter_keyword;
        $data['sort_by']  = $sortBy;
        $data['order_by'] = $orderBy;
        $data['limit']    = $limit;
        $data['page']     = $page;

        
        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $projects_total);


        $this->template->output('common/search', $data);
    }
}
