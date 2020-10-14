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

        if ($this->request->getVar('gid')) {
            $filter_category_id = $this->request->getVar('gid');
        } else {
            $filter_category_id = null;
        }

        if ($this->request->getVar('type')) {
            $filter_type = explode('_', $this->request->getVar('type'));
        } else {
            $filter_type = [];
        }
        
        if ($this->request->getVar('state')) {
            $filter_state = $this->request->getVar('state');
        } else {
            $filter_state = null;
        }
        
        if ($this->request->getVar('skills')) {
            $filter_skills = explode('_', $this->request->getVar('skills'));
        } else {
            $filter_skills = [];
        }
        
        if ($this->request->getVar('filter_min')) {
            $filter_min = $this->request->getVar('filter_min');
        } else {
            $filter_min = null;
        }

        if ($this->request->getVar('filter_max')) {
            $filter_max = $this->request->getVar('filter_max');
        } else {
            $filter_max = null;
        }

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'p.date_added';
        }
       
        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 10;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
            'filter_category_id'   => $filter_category_id,
            'filter_type'   => $filter_type,
            'filter_state'  => $filter_state, 
            'filter_min'    => $filter_min,
            'filter_max'    => $filter_max,
            'filter_skills' => $filter_skills,
            'sort_by'       => $sort_by,
            'order_by'      => $order_by,
            'limit'         => $limit,
            'start'         => ($page - 1) * $limit,
        ];
    
        $data['projects'] = [];
        
        $results = $projectModel->getProjects($filter_data);
        $total = $projectModel->getTotalProjects();
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();

        foreach ($results as $result) {
            $keyword = $seoUrl->getKeywordByQuery('project_id=' . $result['project_id']);
            $data['projects'][] = [
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'description' => substr($result['description'], 0, 100) . '...',
                'meta_keyword'=> ($result['meta_keyword']) ? explode(',', $result['meta_keyword']) : '',
                'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'        => ($result['type'] == 1) ? lang('en.text_fixed_price') : lang('en.text_per_hour'),
                'date_added'  => $this->dateDifference($result['date_added']),
                'href'        => (route_to('project')) ? route_to('project', $keyword) : base_url('project/project?pid=' . $result['project_id']),
            ];
        }

        // Filter Skills
        $url = '';

        if ($this->request->getVar('order_by')) {
            $url .= '&order_by=' . $this->request->getVar('order_by');
        }

        if ($this->request->getVar('sort_by')) {
            $url .= '&sort_by=' . $this->request->getVar('sort_by');
        }
        
        if ($this->request->getVar('type')) {
            $url .= '&type=' . $this->request->getVar('type');
        }
        
        if ($this->request->getVar('state')) {
            $url .= '&state=' . $this->request->getVar('state');
        }
        
        $data['action_skills'] = str_replace('&amp;', '&', base_url('project/category?gid=') . $this->request->getVar('gid') . $url);
       
        // Filter State
        $url = '';

        if ($this->request->getVar('order_by')) {
            $url .= '&order_by=' . $this->request->getVar('order_by');
        }

        if ($this->request->getVar('sort_by')) {
            $url .= '&sort_by=' . $this->request->getVar('sort_by');
        }
        
        if ($this->request->getVar('type')) {
            $url .= '&type=' . $this->request->getVar('type');
        }
        
        if ($this->request->getVar('skills')) {
            $url .= '&skills=' . $this->request->getVar('skills');
        }

        $data['action_state'] = str_replace('&amp;', '&', base_url('project/category?gid=') . $this->request->getVar('gid') . $url);

         // Filter Type
         
        $url = '';

        if ($this->request->getVar('order_by')) {
            $url .= '&order_by=' . $this->request->getVar('order_by');
        }

        if ($this->request->getVar('sort_by')) {
            $url .= '&sort_by=' . $this->request->getVar('sort_by');
        }
        
        if ($this->request->getVar('state')) {
            $url .= '&state=' . $this->request->getVar('state');
        }
        
        if ($this->request->getVar('skills')) {
            $url .= '&skills=' . $this->request->getVar('skills');
        }
        $data['action_type'] = str_replace('&amp;', '&', base_url('project/category?gid=') . $this->request->getVar('gid') . $url);
    
        
        // 


        $data['action_price'] = str_replace('&amp;', '&', base_url('project/category?gid=') . $this->request->getVar('gid') . $url);


        $data['sorts'] = [];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_newest'),
            'value' => 'p.date_added-ASC',
            'href'  => base_url('project/category?gid=' . $this->request->getVar('gid') . '&sort_by=budget_min&order_by=ASC' . $url)
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_lowest'),
            'value' => 'p.budget_min-ASC',
            'href'  => base_url('project/category?gid=' . $this->request->getVar('gid') . '&sort_by=budget_min&order_by=ASC' . $url)
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_highest'),
            'value' => 'p.budget_min-DESC',
            'href'  => base_url('project/category?gid=' . $this->request->getVar('gid') . '&sort_by=budget_min&order_by=DESC' . $url)
        ];

        $data['states'] = [];

        $data['states'][] = [
            'id'    => 'open',
            'value' => '8',
            'text'  => lang('project/category.text_all_open'),
        ];
        $data['states'][] = [
            'id'    => 'open_closed',
            'value' => '8_7',
            'text'  => lang('project/category.text_all_open_closed'),
        ];

        $data['types'] = [];

        $data['types'][] = [
            'id'    => 'fixed_price',
            'value' => '1',
            'text'  => lang('en.text_fixed_price'),
        ];
        $data['types'][] = [
            'id'    => 'per_hour',
            'value' => '2',
            'text'  => lang('en.text_per_hour'),
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

        $data['text_search_keyword'] = lang('project/category.text_search_keyword');
        $data['button_search']       = lang('project/category.button_search');
        $data['text_found']          = lang('project/category.text_found', [$total]);
        $data['text_sidebar']        = lang('project/category.text_sidebar');
        $data['text_type']           = lang('project/category.text_type');
        $data['text_skills']         = lang('project/category.text_skills');
        $data['text_languages']      = lang('project/category.text_languages');
        $data['text_state']          = lang('project/category.text_state');
        $data['text_budget']         = lang('project/category.text_budget');
        $data['heading_title']       = lang('project/category.text_projects');
        
        $data['text_projects']       = lang('project/category.text_projects');
        $data['button_hire']         = lang('en.button_hire');
        $data['button_work']         = lang('en.button_work');
        $data['button_bid_now']      = lang('project/category.button_bid_now');
        $data['text_select']         = lang('en.text_select');

        $data['add_project'] = base_url('project/project/add');
        $data['login']       = base_url('account/login');

        $data['filter_type']   = $filter_type;
        $data['filter_state']  = $filter_state;
        $data['filter_min']    = $filter_min;
        $data['filter_max']    = $filter_max;
        $data['filter_skills'] = $filter_skills;
        $data['sort_by']       = $sort_by;
        $data['order_by']      = $order_by;
        $data['limit']         = $limit;
        $data['page']          = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

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
