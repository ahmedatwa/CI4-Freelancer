<?php namespace Admin\Controllers\Localisation;

use \Admin\Models\Localisation\CurrencyModel;

class Currency extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $currencyModel = new CurrencyModel();

        $this->document->setTitle(lang('localisation/currency.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('localisation/currency.list.text_add'));

        $currencyModel = new CurrencyModel();

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

        $currencyModel = new CurrencyModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $currencyModel->editCurrency($this->request->getVar('currency_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/localisation/currency?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('localisation/currency.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $currencyModel = new CurrencyModel();
   
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

    public function refresh()
    {
        $this->document->setTitle(lang('localisation/currency.list.heading_title'));

        $currencyModel = new CurrencyModel();

        if ($this->validateDelete()) {
            $currencyModel->refresh($this->registry->get('config_currency'));

            $this->session->setFlashdata('success', lang('localisation/currency.text_success'));
            return redirect()->to(base_url('index.php/localisation/currency?user_token=' . $this->request->getVar('user_token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        $currencyModel = new CurrencyModel();
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
            $data['currencies'][] = [
                'currency_id'   => $result['currency_id'],
                'title'         => $result['title'] . (($result['code'] == $this->registry->get('config_currency')) ? lang('en.text_default') : null),
                'code'          => $result['code'],
                'value'         => $result['value'],
                'date_modified' => lang('en.medium_date', [strtotime($result['date_modified'])]),
                'edit'          => base_url('index.php/localisation/currency/edit?user_token=' . $this->request->getVar('user_token') . '&currency_id=' . $result['currency_id']),
            ];
        }

        $data['add'] = base_url('index.php/localisation/currency/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/localisation/currency/delete?user_token=' . $this->request->getVar('user_token'));
        $data['refresh'] = base_url('index.php/localisation/currency/refresh?user_token=' . $this->request->getVar('user_token'));

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
            $currencyModel = new CurrencyModel();
            $currency_info = $currencyModel->getCurrency($this->request->getVar('currency_id'));
        }

        if ($this->request->getPost('title')) {
            $data['title'] = $this->request->getPost('title');
        } elseif (!empty($currency_info['title'])) {
            $data['title'] = $currency_info['title'];
        } else {
            $data['title'] = '';
        }

        if ($this->request->getPost('code')) {
            $data['code'] = $this->request->getPost('code');
        } elseif (!empty($currency_info['code'])) {
            $data['code'] = $currency_info['code'];
        } else {
            $data['code'] = '';
        }

        if ($this->request->getPost('symbol_left')) {
            $data['symbol_left'] = $this->request->getPost('symbol_left');
        } elseif (!empty($currency_info['symbol_left'])) {
            $data['symbol_left'] = $currency_info['symbol_left'];
        } else {
            $data['symbol_left'] = '';
        }

        if ($this->request->getPost('symbol_right')) {
            $data['symbol_right'] = $this->request->getPost('symbol_right');
        } elseif (!empty($currency_info['symbol_right'])) {
            $data['symbol_right'] = $currency_info['symbol_right'];
        } else {
            $data['symbol_right'] = '';
        }

        if ($this->request->getPost('value')) {
            $data['value'] = $this->request->getPost('value');
        } elseif (!empty($currency_info['value'])) {
            $data['value'] = $currency_info['value'];
        } else {
            $data['value'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($currency_info)) {
            $data['status'] = $currency_info['status'];
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

        if (! $this->user->hasPermission('modify', 'localisation/currency')) {
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
