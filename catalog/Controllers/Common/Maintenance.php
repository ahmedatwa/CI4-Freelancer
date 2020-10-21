<?php namespace Catalog\Controllers\Common;

class Maintenance extends \Catalog\Controllers\BaseController
{
	public function index() {

		$this->template->setTitle(lang('common/maintenance.heading_title'));

		$this->response->setStatusCode(503);

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => lang('en.text_maintenance'),
			'href' => base_url('common/maintenance')
		];

		$data['text_maintenance'] = lang('common/maintenance.text_maintenance');
		$data['text_message'] = lang('common/maintenance.text_message');

		return view ('common/maintenance', $data);
	}
}
