<?php namespace Catalog\Controllers\Common;

class Home extends \Catalog\Controllers\BaseController
{
	public function index()
	{

		$this->template->setTitle(service('registry')->get('config_meta_title'));
		$this->template->setDescription(service('registry')->get('config_meta_description'));
		$this->template->setKeywords(service('registry')->get('config_meta_keyword'));

		$data['text_login'] = lang('common/home.text_title');

		$this->template->output('common/home', $data);

	}

	//--------------------------------------------------------------------

}
