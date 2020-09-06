<?php namespace Admin\Controllers\Extension\Wallet;

class Wallet extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->wallets = new \Admin\Models\Extension\Wallet\Wallets();

        $this->document->setTitle(lang('extension/wallet/wallet.list.heading_title'));

        $this->getList();
    }

    protected function getList()
    {

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extensions?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/wallet/wallet.list.heading_title'),
            'href' => base_url('index.php/extension/wallet/post?user_token=' . $this->session->get('user_token')),
        ];

        // Data
        $filter_data = [
            'start' => 0,
            'limit' => $this->registry->get('config_admin_limit'),
         ];
        $data['wallets'] = [];
        $results = $this->wallets->getWallets($filter_data);

        foreach ($results as $result) {
            $data['wallets'][] = [
                'wallet_id'     => $result['wallet_id'],
                'name'       => $result['name'],
                'freelancer' => $result['freelancer'],
                'open'       => $this->getOpenDays($result['date_start'], $result['date_end']),
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'       => base_url('index.php/extension/wallet/post/save?user_token=' . $this->session->get('user_token') . '&wallet_id=' . $result['wallet_id']),
                'delete'     => base_url('index.php/extension/wallet/post/delete?user_token=' . $this->session->get('user_token') . '&wallet_id=' . $result['wallet_id']),
            ];
        }

        $data['add'] = base_url('index.php/extension/wallet/post/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/extension/wallet/post/delete?user_token=' . $this->session->get('user_token'));
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=wallet');

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

        $this->document->output('extension/wallet/wallet_list', $data);
    }
        
    //--------------------------------------------------------------------
}
