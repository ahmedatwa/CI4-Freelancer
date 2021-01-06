<?php namespace Catalog\Controllers\Module;

use \Catalog\Models\Catalog\ProjectModel;

class Featured extends \Catalog\Controllers\BaseController
{
    public function index($setting)
    {
        $data['heading_title'] = lang('module/account.heading_title');

		$seoUrl = service('seo_url');

        // featured block
        $data['featured'] = [];

        $projectModel = new ProjectModel();

        $filter_data = [
			'limit'         => $this->registry->get('module_featured_limit'),
			'start'         => 0,
		];

        $results = $projectModel->getProjects($filter_data);

        foreach ($results as $result) {
            $keyword = $seoUrl->getKeywordByQuery('project_id=' . $result['project_id']);
            $data['featured'][] = [
				'project_id'  => $result['project_id'],
				'name'        => $result['name'],
				'type'        => ($result['type'] == 1) ? lang($this->locale . '.text_fixed_price') : lang($this->locale . '.text_per_hour'),
				'date_added'  => $this->dateDifference($result['date_added']),
				'href'        => (route_to('single_project', $keyword)) ? route_to('single_project', $keyword) : base_url('project/project/project?pid=' . $result['project_id']),
			];
        }

		$data['heading_title'] = lang('module/featured.heading_title');
		$data['text_browse']   = lang('module/featured.text_browse');
		$data['text_apply']    = lang('module/featured..text_apply');


		$data['projects_all']  = route_to('projects') ? route_to('projects') : base_url('project/project');


        return view('module/featured', $data);
    }
}
