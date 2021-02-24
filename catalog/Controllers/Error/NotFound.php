<?php 

namespace Catalog\Controllers\Error;

use Catalog\Controllers\BaseController;

class NotFound extends BaseController
{
	public function index() 
	{

		$this->template->setTitle(lang('error/not_found.text_not_found'));

        $data['base'] = slash_item('baseURL');
        
		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => lang($this->locale . '.list.text_home'),
			'href' => base_url(),
		];

		$data['breadcrumbs'][] = [
			'text' => lang('error/not_found.list.text_not_found'),
			'href' => '',
		];

		if ($this->request->uri) 
		{
			$info = [
				'uri'        => $this->request->uri,
				'ip_address' => $this->request->getIPAddress()
            ];

            log_message('error', 'System failed to load URI: {uri} logged from IP Address {ip_address}', $info);
		}

		$data['langData'] = lang('error/not_found.list');
		
	    $data['header'] = view_cell('\Catalog\Controllers\Common\Header::index');
        $data['footer'] = view_cell('\Catalog\Controllers\Common\Footer::index');

		return view ('error/not_found', $data);
	}

	// ---------------------------------------------------
}