<?php namespace Extensions\Controllers\Wallet;

class Wallet extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('wallet/wallet.list.heading_title'));

        $setting_model = new \Admin\Models\Setting\Settings();

        if (($this->request->getMethod() == 'post') ) {
                $setting_model->editSetting('extension_wallet', $this->request->getPost());

            return redirect()->to(base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token')))
                             ->with('success', lang('extension/wallet/wallet.text_success'));
        }

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

        $data['action'] = base_url('index.php/extension/wallet/wallet?user_token=' . $this->session->get('user_token'));
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

        if ($this->request->getPost('extension_wallet_status')) {
            $data['extension_wallet_status'] = $this->request->getPost('extension_wallet_status');
        } elseif (!empty($this->registry->get('extension_wallet_status'))) {
            $data['extension_wallet_status'] = $this->registry->get('extension_wallet_status');
        } else {
            $data['extension_wallet_status'] = '';
        }

        $this->document->output('extension/wallet/wallet_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/wallet/wallet')) {
            $this->session->setFlashdata('error_warning', lang('extension/wallet/wallet.error_permission'));
            return false;
        }
        return true;
    }

        
    //--------------------------------------------------------------------
}
