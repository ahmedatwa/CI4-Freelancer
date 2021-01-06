<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Localization\LanguageModel;

class Language extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['action'] = base_url('common/language/language');

        $data['code'] = $this->session->get('language');

        $languageModel = new LanguageModel();

        $url = current_url();

        $url_query = $this->request->uri->getQuery();

        $path = $this->request->uri->getPath();

        $segments = $this->request->uri->getSegments();

        $locale = $segments[0] ?? 'en';

        $data['languages'] = [];

        $results = $languageModel->where('status', 1)->findAll();

        foreach ($results as $result) {
            $data['languages'][] = [
                  'name' => $result['name'],
                  'code' => $result['code'],
                  'href' => base_url() . '/' . str_replace($locale, $result['code'], urldecode($this->request->uri->getPath()))
                ];
        }

        $data['text_language'] = lang('common/language.text_language');

        return view('common/language', $data);
    }

    public function language()
    {
        if ($this->request->getMethod() == 'post') {
            if ($this->request->getPost('code')) {
                $code = (string) $this->request->getPost('code');
            } else {
                $code = 'en';
            }

            if ($this->request->getPost('redirect')) {
                $redirect = $this->request->getPost('redirect');
            } else {
                $redirect = '';
            }

            $this->session->remove('language');
            $this->session->set('language', $code);

            if ($redirect && substr($redirect, 0, strlen($this->registry->get('config_url'))) == $this->registry->get('config_url')) {
                return redirect()->to($redirect);
            } else {
                return redirect('/');
            }
        }
    }

    //--------------------------------------------------------------------
}
