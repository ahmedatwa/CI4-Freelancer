<?php namespace Catalog\Controllers\Module;

class Html extends \Catalog\Controllers\BaseController
{
    public function index($setting) {
		if (isset($setting['module_description'][$this->registry->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->registry->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description'][$this->registry->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');

			return view('module/html', $data);
		}
	}
// -----------------------------------------
}
