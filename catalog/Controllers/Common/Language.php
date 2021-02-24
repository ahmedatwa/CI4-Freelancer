<?php 

namespace Catalog\Controllers\Common;

use Catalog\Controllers\BaseController;
use Catalog\Models\Localization\LanguageModel;

class Language extends BaseController
{
    public function index()
    {
        $data['action'] = base_url('common/language/language');

        if ($this->request->getCookie(config('App')->cookiePrefix . 'language')) {
            $code = \Config\Services::encrypter()->decrypt(base64_decode($this->request->getCookie(config('App')->cookiePrefix . 'language', FILTER_SANITIZE_STRING)));
        } else {
            $code = $this->registry->get('config_language');
        }

        $data['code'] = $code;

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

            $cookie = [
                'name'     => 'language',
                'value'    => $this->request->getPost('code', FILTER_SANITIZE_STRING),
                'expire'   => '86500',
                'domain'   => config('App')->cookieDomain,
                'path'     => config('App')->cookiePath,
                'prefix'   => config('App')->cookiePrefix,
                'secure'   => config('App')->cookieSecure,
                'httponly' => config('App')->cookieHTTPOnly,
                'samesite' => config('App')->cookieSameSite
            ];

            if ($redirect && substr($redirect, 0, strlen($this->registry->get('config_url'))) == $this->registry->get('config_url')) {
                return redirect()->to($redirect)->withCookies();
            } else {
                return redirect('/')->withCookies();
            }
        }
    }

    //--------------------------------------------------------------------
}
