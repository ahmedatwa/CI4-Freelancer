<?php namespace Catalog\Controllers\Project;

use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Design\Seo_urls;

class Project extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();
        $seo_urls = new Seo_urls();

        helper('number');

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

        if ($this->request->getGet('sortBy')) {
            $sortBy = $this->request->getGet('sortBy');
        } else {
            $sortBy = 'p.date_added';
        }

        if ($this->request->getGet('orderBy')) {
            $orderBy = $this->request->getGet('orderBy');
        } else {
            $orderBy = 'ASC';
        }

        if ($this->request->getGet('limit')) {
            $limit = $this->request->getGet('limit');
        } else {
            $limit = 5;
        }

        if ($this->request->getGet('page')) {
            $page = $this->request->getGet('page');
        } else {
            $page = 1;
        }

        $filter_data = [
            'sortBy'  => $sortBy,
            'orderBy' => $orderBy,
            'limit'   => $limit,
            'start'   => ($page - 1) * $limit,
        ];
    
        $data['projects'] = [];
        
        $results = $projectModel->getProjects($filter_data);
        $projects_total = $projectModel->getTotalProjects();
        
        foreach ($results as $result) {
            $data['projects'][] = [  
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'description' => substr($result['description'], 0, 200) . '...',
                'tags'        => ($result['tags']) ? explode(',', $result['tags']) : '',
                'price'       => number_to_currency(1234.56, 'USD'),
                'type'        => ($result['status'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'date_added'  => $result['date_added'],
                'href'        => route_to('project', getKeywordByQuery('project_id=' . $result['project_id']))
            ];
        }

        $pager = \Config\Services::pager();

        //$paginate = $projectModel->paginate(20);
        $data['pagination'] = $pager->makeLinks($page, $limit, $projects_total);//$projectModel->pager;


        $this->template->output('project/projects', $data);
    }

    public function getProject($keyword)
    {
        $projectModel = new ProjectModel();

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
        
        $data['isLogged'] = $this->customer->isLogged();

        $projectInfo = $projectModel->getProjectByID($project_id);

        if ($projectInfo) {
            $data['name'] = $projectInfo['name'];
            $data['price'] = $projectInfo['price'];
            $data['description'] = $projectInfo['description'];
            $data['skills'] = explode(',', $projectInfo['skills']);
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
            // $data[''] = $projectInfo[''];
        } else {
            $data['name'] = '';
        }

        $data['text_about']       = lang('project/project.text_about');
        $data['text_budget']      = lang('project/project.text_budget');
        $data['text_description'] = lang('project/project.text_description');
        $data['text_attachments'] = lang('project/project.text_attachments');
        $data['text_skills']      = lang('project/project.text_skills');
        $data['']                 = lang('project/project.');
        $data[''] = lang('project/project.');
        $data[''] = lang('project/project.');
        $data[''] = lang('project/project.');
        $data[''] = lang('project/project.');
        $data[''] = lang('project/project.');
        $data[''] = lang('project/project.');
        $data[''] = lang('project/project.');
        $data[''] = lang('project/project.');
        $data[''] = lang('project/project.');
        

        
        $this->template->output('project/project', $data);
    }
    
    
    //--------------------------------------------------------------------
}
