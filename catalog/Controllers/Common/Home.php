<?php namespace Catalog\Controllers\Common;

class Home extends \Catalog\Controllers\BaseController
{
	public function index()
	{

		$this->template->setTitle(getSettingValue('config_meta_title'));
		$this->template->setDescription(getSettingValue('config_meta_description'));
		$this->template->setKeywords(getSettingValue('config_meta_keyword'));

		$data['text_login'] = lang('common/home.text_title');

		$this->template->output('common/home', $data);

	}

	//--------------------------------------------------------------------

}
