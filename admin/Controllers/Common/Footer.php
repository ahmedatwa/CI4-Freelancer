<?php namespace Admin\Controllers\Common;

class Footer extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $data['scripts'] = $this->document->getScripts();

		$data['text_footer']  = lang('common/footer.text_footer');
		$data['text_version'] = lang('common/footer.text_version');

        return view ('common/footer', $data);
    }

    //--------------------------------------------------------------------
}
