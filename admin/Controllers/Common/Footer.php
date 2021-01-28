<?php namespace Admin\Controllers\Common;

class Footer extends \Admin\Controllers\BaseController
{
    public function index()
    {
		$data['text_footer']  = sprintf(lang('common/footer.text_footer'), $this->registry->get('config_name'));
		$data['text_version'] = lang('common/footer.text_version');

        return view ('common/footer', $data);
    }

    //--------------------------------------------------------------------
}
