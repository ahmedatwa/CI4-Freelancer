<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Localization\CurrencyModel;

class Currency extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['action'] = base_url('common/currency/currency');

        $data['code'] = $this->request->getCookie(config('App')->cookiePrefix . 'currency', FILTER_SANITIZE_STRING);

        $currencyModel = new CurrencyModel();

        $data['currencies'] = [];

        $results = $currencyModel->getCurrencies();

        foreach ($results as $result) {
            if ($result['status']) {
                $data['currencies'][] = [
                  'title'        => $result['title'],
                  'code'         => $result['code'],
                  'symbol_left'  => $result['symbol_left'],
                  'symbol_right' => $result['symbol_right']
                ];
            }
        }

        $route = current_url();

        $url_query = $this->request->uri->getQuery();

        $url = '';

        if ($url_query) {
            $url = '?' . $url_query;
        }

        $data['redirect'] = base_url($route . $url);

        $data['text_currency'] = lang('common/currency.text_currency');

        return view('common/currency', $data);
    }

    public function currency()
    {
        if ($this->request->getMethod() == 'post') {
            if ($this->request->getPost('code')) {
                $cookie = [
                    'name'     => 'currency',
                    'value'    => (string) $this->request->getPost('code'),
                    'expire'   => '86500',
                    'domain'   => config('App')->cookieDomain,
                    'path'     => config('App')->cookiePath,
                    'prefix'   => config('App')->cookiePrefix,
                    'secure'   => config('App')->cookieSecure,
                    'httponly' => config('App')->cookieHTTPOnly,
                    'samesite' => config('App')->cookieSameSite
                    ];

                $this->response->setCookie($cookie);
            }

            if ($this->request->getPost('redirect')) {
                return redirect()->to($this->request->getPost('redirect'))->withCookies();
            } else {
                return redirect()->to(base_url())->withCookies();
            }
        }
    }

    //--------------------------------------------------------------------
}
