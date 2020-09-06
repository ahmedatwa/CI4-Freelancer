<?php namespace Catalog\Controllers\Module;

class Account extends \Catalog\Controllers\BaseController
{
	public function index() {

		$data['heading_title']   = lang('module/account.heading_title');
		$data['text_register']   = lang('module/account.text_register');
		$data['text_login']      = lang('module/account.text_login');
		$data['text_logout']     = lang('module/account.text_logout');
		$data['text_forgotten']  = lang('module/account.text_forgotten');
		$data['text_account']    = lang('module/account.text_account');
		$data['text_edit']       = lang('module/account.text_edit');
		$data['text_password']   = lang('module/account.text_password');
		$data['text_download']   = lang('module/account.text_download');
		$data['text_newsletter'] = lang('module/account.text_newsletter');

		$data['logged']     = $this->customer->isLogged();
		$data['register']   = base_url('account/register');
		$data['login']      = base_url('account/login');
		$data['logout']     = base_url('account/logout');
		$data['forgotten']  = base_url('account/forgotten');
		$data['account']    = base_url('account/account');
		$data['edit']       = base_url('account/edit');
		$data['password']   = base_url('account/password');
		$data['download']   = base_url('account/download');
		$data['newsletter'] = base_url('account/newsletter');


		return view('module/account', $data);
	}

	// --------------------------------------------
}