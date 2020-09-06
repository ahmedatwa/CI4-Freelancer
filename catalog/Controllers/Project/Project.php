<?php namespace Catalog\Controllers\Project;

use Catalog\Controllers\BaseController;

class Category extends BaseController
{
    public function index()
    {

        $this->template->setTitle(lang('service/category.list.heading_title'));
        
        $projects = new \Catalog\Models\Catalog\Projects();
        
        $data['breadcrumbs']   = array();
        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url(),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('service/category.list.text_Jobs'),
            'href' => base_url('service/category'),
        );
    
        $filter_data = array(
            'start' => 0,
            'limit' => 20,
        );
            
        $data['jobs'] = array();
        
        $results = $projects->findAll();

       // $data['total_jobs'] = $projects->getProjects();
		
		foreach ($results as $result) {
            if (!empty($data['image'])) {
                $image = $this->resize($data['image'], 460, 310);
            } else {
                $image = $this->resize('no_image.jpg', 460, 310);
            }
			$data['jobs'][] = array(
                'project_id' => $result['project_id'],
                'customer' => '',
                //'name'   => $result['name'],
                'price'  => $result['price'],
                'image'  => $image,
                'rating' => '',
                'href'   => base_url('service/service?service_id=' . $result['project_id'])
            );
		}
            
        //$paginate = $this->service->paginate(10);
        //$data['pager'] = $this->service->pager;
        //var_dump('expression');


        $this->template->output('project/category', $data);
    }
    
    
    //--------------------------------------------------------------------
}
