<?php namespace Catalog\Controllers\Common;

use \Catalog\Models\Localization\CurrencyModel;

class Currency extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $data['action'] = base_url('common/currency/currency');

        $data['code'] = $this->session->get('currency');

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

        if ($this->request->getPost('code')) {
            $this->session->set('currency', $this->request->getPost('code'));
        }

    
        if ($this->request->getPost('redirect')) {
            return redirect()->to($this->request->getPost('redirect'));
        } else {
            return redirect()->to(base_url());
        }
    }

    //--------------------------------------------------------------------
}
