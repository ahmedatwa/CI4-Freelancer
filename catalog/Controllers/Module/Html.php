<?php namespace Catalog\Controllers\Module;

class Html extends \Catalog\Controllers\BaseController
{
    public function index($setting) 
    {
		if (isset($setting['module_description'])) {
			$data['heading_title'] = html_entity_decode($setting['module_description']['title'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description']['description'], ENT_QUOTES, 'UTF-8');
		} else {
			$data['heading_title'] = '';
			$data['html'] = '';
		}

		return view('module/html', $data);
	}
// -----------------------------------------
}
