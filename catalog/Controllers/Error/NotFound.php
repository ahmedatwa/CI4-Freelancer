<?php namespace Catalog\Controllers\Error;

class NotFound extends \Catalog\Controllers\BaseController
{
	public function index() 
	{

		$this->template->setTitle(lang('error/not_found.text_not_found'));

        $data['base'] = slash_item('baseURL');
        
		$data['text_not_found'] = lang('error/not_found.text_not_found');
		$data['text_404']       = lang('error/not_found.text_404');
		$data['text_sorry']     = lang('error/not_found.text_sorry');

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => lang($this->locale . '.text_home'),
			'href' => base_url(),
		];

		$data['breadcrumbs'][] = [
			'text' => lang('error/not_found.text_not_found'),
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

	    $data['header'] = view_cell('\Catalog\Controllers\Common\Header::index');
        $data['footer'] = view_cell('\Catalog\Controllers\Common\Footer::index');

		return view ('error/not_found', $data);
	}

	// ---------------------------------------------------
}