<?php 

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\ProjectModel;

class Employer_project extends BaseController
{
	public function index()
	{
		$projectModel = new ProjectModel();

		if ($keyword = $this->request->uri->getSegment(2)) {
            $queryID = $projectModel->findID($keyword);
        }

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } elseif ($queryID) {
            $project_id = $queryID;
        } else {
            $project_id = 0;
        }


		$filter_data = [
            'limit' => $this->registry->get('module_employer_project_limit'),
            'start' => 0,
        ];
        
        $data['more_projects'] = [];
            
        $filter_data = [
            'start'           => 0,
            'limit'           => 5,
            'current_project' => $project_id
        ];

        $more_projects = $projectModel->getProjects($filter_data);

        foreach ($more_projects as $result) {
            $data['more_projects'][] = [
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'href'        => ($result['keyword']) ? route_to('single_project', $result['project_id'], $result['keyword']) : base_url('project/project/view?pid=' . $result['project_id']),
            ];
        }

        $data['langData'] = lang('module/employer_project.list');
        
		return view('module/employer_project', $data);
	}

	// --------------------------------------------
}