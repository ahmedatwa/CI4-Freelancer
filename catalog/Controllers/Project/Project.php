<?php namespace Catalog\Controllers\Project;

use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Design\Seo_urls;

class Project extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();
        $seo_urls = new Seo_urls();

        $this->template->addStyle('catalog/default/vendor/select2/css/select2.min.css');
        $this->template->addScript('catalog/default/vendor/select2/js/select2.full.min.js');

        $this->template->setTitle(lang('project/project.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/project.text_projects'),
            'href' => route_to('projects'),
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
        $projects_total = $projectModel->getTotalProjects();
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();
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

        $data['skills'] = [];
        $skills = $projectModel->getSkills(['start' => 0, 'limit' => 3]);
        foreach ($skills as $skill) {
            $data['skills'][] = [
                'skill_id'   => $skill['skill_id'],
                'text' => $skill['text']
            ];
        }

        $data['filter']   = $filter;
        $data['sort_by']  = $sortBy;
        $data['order_by'] = $orderBy;
        $data['limit']    = $limit;
        $data['page']     = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $projects_total);

        $this->template->output('project/projects', $data);
    }

    public function getProject($keyword)
    {
        $projectModel = new ProjectModel();

        $this->template->setTitle($keyword .' | '. $this->registry->get('config_name'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/project.text_projects'),
            'href' => route_to('project', $keyword),
        ];

        if ($this->request->getGet('project_id')) {
            $project_id = $this->request->getGet('project_id');
        } else {
            $seoUrlsModel = new \Catalog\Models\Design\Seo_urls();
            $query = (string) $seoUrlsModel->getQueryByKeyword($keyword);
            $project_id = substr($query, -1);
        }

        if ($this->customer->isLogged()) {
            $data['freelancer_id'] = $this->customer->getCustomerId();
        } else {
            $data['freelancer_id'] = 0;
        }

        $data['logged']          = $this->customer->isLogged();
        $data['config_currency'] = $this->registry->get('config_currency');
        $data['register']        = route_to('account/register');
        
        $projectInfo = $projectModel->getProject($project_id);

        if ($projectInfo) {
            $data['project_id']  = $projectInfo['project_id'];
            $data['name']        = $projectInfo['name'];
            $data['budget']      = $this->currencyFormat($projectInfo['budget_min']) . ' - ' . $this->currencyFormat($projectInfo['budget_max']);
            $data['description'] = $projectInfo['description'];
            $data['skills']      = $projectModel->getSkillsByProjectId($project_id);
            $data['days_left']   = $this->dateDifference($projectInfo['date_added'], $projectInfo['date_end']);
            $data['rating']      = round($projectInfo['total']);
            $data['employer']    = $projectInfo['employer'];
            $data['employer_id'] = $projectInfo['employer_id'];
        } else {
            $data['project_id']  = '';
            $data['name']        = '';
            $data['budget']      = '';
            $data['description'] = '';
            $data['skills']      = '';
            $data['days_left']   = '';
            $data['rating']      = '';
            $data['employer']    = '';
            $data['employer_id'] = '';
        }

        $data['text_about']       = lang('project/project.text_about');
        $data['text_budget']      = lang('project/project.text_budget');
        $data['text_description'] = lang('project/project.text_description');
        $data['text_attachments'] = lang('project/project.text_attachments');
        $data['text_skills']      = lang('project/project.text_skills');
        $data['text_bid']         = lang('project/project.text_bid');
        $data['text_rate']        = lang('project/project.text_rate');
        $data['text_delivery']    = lang('project/project.text_delivery');
        $data['text_register']    = lang('common/header.text_register');
        $data['text_facebook']    = lang('en.text_facebook');
        $data['text_twitter']     = lang('en.text_twitter');
        $data['text_gplus']       = lang('en.text_gplus');
        

        $projectModel->updateViewed($project_id);

        $this->template->output('project/project', $data);
    }
    
    public function autocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_skill')) {

            if ($this->request->getVar('filter_skill')) {
                $filter_skill = $this->request->getVar('filter_skill');
            } else {
                $filter_skill = '';
            }

            $filter_data = [
              'filter_skill' => $filter_skill,
              'start'        => 0,
              'limit'        => 5
            ];

            $projectModel = new ProjectModel();
            $results = $projectModel->getSkills($filter_data);
            foreach ($results as $result) {
                $json[] = [
                    'skill_id' => $result['skill_id'],
                    'text'     => $result['text']
                ];
            }

       }
        return $this->response->setJSON($json);
    }
    //--------------------------------------------------------------------
}
