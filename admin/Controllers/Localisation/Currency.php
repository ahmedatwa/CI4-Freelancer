<?php namespace Admin\Controllers\Localisation;

use \Admin\Models\Localisation\Currencies;

class Currency extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $currencyModel = new Currencies();

        $this->document->setTitle(lang('localisation/currency.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('localisation/currency.list.text_add'));

        $currencyModel = new Currencies();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $currencyModel->addCurrency($this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/currency?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/currency.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('localisation/currency.list.text_edit'));

        $currencyModel = new Currencies();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $currencyModel->editCurrency($this->request->getVar('currency_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/currency?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/currency.text_success'));
        }
        $this->getForm();
    }

public function refresh($force = false)
    {
        $currency_data = [];

        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');

        $body = $response->getBody();
        var_dump($body);

        if ($body) {
                $dom = new \DOMDocument('1.0', 'UTF-8');

                $dom->loadXml($body);

                $cube = $dom->getElementsByTagName('Cube')->item(0);


                $currencies = [];

                $currencies['EUR'] = 1.0000;

                foreach ($cube->getElementsByTagName('Cube') as $currency) {
                    var_dump($currency);
                   
                    if ($currency->getAttribute('currency')) {
                        $currencies[$currency->getAttribute('currency')] = $currency->getAttribute('rate');
                    }
                }

                if ($currencies) {
                   // $this->load->model('localisation/currency');

                    //$results = $this->model_localisation_currency->getCurrencies();

                    // foreach ($results as $result) {
                    //     if (isset($currencies[$result['code']])) {
                    //         $from = $currencies['EUR'];

                    //         $to = $currencies[$result['code']];

                    //         $this->model_localisation_currency->editValueByCode($result['code'], 1 / ($currencies[$default] * ($from / $to)));
                    //     }
                    // }
                }
            }


        //     if ((float)$value) {
        //         $this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '" . (float)$value . "', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($currency) . "'");
        //     }
        // }

        // $this->db->query("UPDATE " . DB_PREFIX . "currency SET value = '1.00000', date_modified = '" .  $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE code = '" . $this->db->escape($this->config->get('config_currency')) . "'");

        // $this->cache->delete('currency');
    }

    public function delete()
    {
        $json = [];

        $currencyModel = new Currencies();
   
        $this->document->setTitle(lang('localisation/currency.list.heading_title'));

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $currency_id) {
                $currencyModel->deleteCurrency($currency_id);
                $json['success'] = lang('localisation/currency.text_success');
                $json['redirect'] = 'index.php/localisation/currency?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('localisation/currency.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        $currencyModel = new Currencies();
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/currency.list.heading_title'),
            'href' => base_url('index.php/localisation/currency?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $data['currencies'] = [];

        $results = $currencyModel->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['currencies'][] = array(
                'currency_id'   => $result['currency_id'],
                'title'         => $result['title'],
                'code'          => $result['code'],
                'value'         => $result['value'],
                'date_modified' => $result['date_modified'],
                'edit'          => base_url('index.php/localisation/currency/edit?user_token=' . $this->request->getVar('user_token') . '&currency_id=' . $result['currency_id']),
            );
        }

        $data['add'] = base_url('index.php/localisation/currency/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/localisation/currency/delete?user_token=' . $this->request->getVar('user_token'));

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->request->getVar('user_token');

        $this->document->output('localisation/currency_list', $data);
    }

    protected function getForm()
    {
        $currencyModel = new Currencies();
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('localisation/currency.list.heading_title'),
            'href' => base_url('index.php/localisation/currency/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('currency_id') ? lang('localisation/currency.list.text_add') : lang('localisation/currency.list.text_edit');

        $data['cancel'] = base_url('index.php/localisation/currency?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('currency_id')) {
            $data['action'] = base_url('index.php/localisation/currency/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/localisation/currency/edit?user_token=' . $this->request->getVar('user_token') . '&currency_id=' . $this->request->getVar('currency_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->request->getVar('currency_id') && ($this->request->getMethod() != 'post')) {
            $user_info = $currencyModel->getCurrency($this->request->getVar('currency_id'));
        }

        if ($this->request->getPost('title')) {
            $data['title'] = $this->request->getPost('title');
        } elseif (!empty($user_info['title'])) {
            $data['title'] = $user_info['title'];
        } else {
            $data['title'] = '';
        }

        if ($this->request->getPost('code')) {
            $data['code'] = $this->request->getPost('code');
        } elseif (!empty($user_info['code'])) {
            $data['code'] = $user_info['code'];
        } else {
            $data['code'] = '';
        }

        if ($this->request->getPost('symbol_left')) {
            $data['symbol_left'] = $this->request->getPost('symbol_left');
        } elseif (!empty($user_info['symbol_left'])) {
            $data['symbol_left'] = $user_info['symbol_left'];
        } else {
            $data['symbol_left'] = '';
        }

        if ($this->request->getPost('symbol_right')) {
            $data['symbol_right'] = $this->request->getPost('symbol_right');
        } elseif (!empty($user_info['symbol_right'])) {
            $data['symbol_right'] = $user_info['symbol_right'];
        } else {
            $data['symbol_right'] = '';
        }

        if ($this->request->getPost('value')) {
            $data['value'] = $this->request->getPost('value');
        } elseif (!empty($user_info['value'])) {
            $data['value'] = $user_info['value'];
        } else {
            $data['value'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($user_info)) {
            $data['status'] = $user_info['status'];
        } else {
            $data['status'] = 1;
        }

        $this->document->output('localisation/currency_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'title' => [
                    'label' => 'Currency Title',
                    'rules' => 'required|min_length[3]|max_length[32]',
                ],
                'code'  => [
                    'label' => 'Currency Code',
                    'rules' => 'required|min_length[3]',
                ],
                ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }

        if (! $this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('localisation/currency.error_permission'));
            return false;
        }
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'localisation/currency')) {
            $this->session->setFlashdata('error_warning', lang('localisation/currency.error_permission'));
            return false;
        }
        return true;
    }
        
    //--------------------------------------------------------------------
}
