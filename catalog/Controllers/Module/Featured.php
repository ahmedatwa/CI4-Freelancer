<?php 

namespace Catalog\Controllers\Module;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\ProjectModel;

class Featured extends BaseController
{
    public function index($setting)
    {

		$seoUrl = service('seo_url');

        // featured block
        $data['featureds'] = [];

        $projectModel = new ProjectModel();

        $filter_data = [
			'limit'  => $this->registry->get('module_featured_limit'),
			'start'  => 0,
		];

        $results = $projectModel->getProjects($filter_data);

        foreach ($results as $result) {
            $keyword = $seoUrl->getKeywordByQuery('project_id=' . $result['project_id']);
            $data['featureds'][] = [
				'project_id'  => $result['project_id'],
				'name'        => $result['name'],
				'type'        => ($result['type'] == 1) ? lang($this->locale . '.text_fixed_price') : lang($this->locale . '.text_per_hour'),
				'date_added'  => $this->dateDifference($result['date_added']),
				'href'        => ($keyword) ? route_to('single_project', $result['project_id'], $keyword) : base_url('project/project/view?pid=' . $result['project_id']),
			];
        }

		$data['projects_all']  = route_to('projects') ? route_to('projects') : base_url('project/project');
        
        $data['langData'] = lang('module/featured.list');

        return view('module/featured', $data);
    }
    // -----------------------------------------------------
}