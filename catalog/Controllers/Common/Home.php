<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Account\CustomerModel;

class Home extends \Catalog\Controllers\BaseController
{
	public function index()
	{
		$this->template->setTitle($this->registry->get('config_meta_title'));
		$this->template->setDescription($this->registry->get('config_meta_description'));
		$this->template->setKeywords($this->registry->get('config_meta_keyword'));

		$this->template->output('common/home');

	}

	//--------------------------------------------------------------------

}
