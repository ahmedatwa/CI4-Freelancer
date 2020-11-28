<?php namespace Extensions\Controllers\Wallet;

class Wallet extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('wallet/wallet.list.heading_title'));

        $setting_model = new \Admin\Models\Setting\Settings();

        if (($this->request->getMethod() == 'post') ) {
                $setting_model->editSetting('wallet_extension', $this->request->getPost());

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
            'text' => lang('wallet/wallet.list.heading_title'),
            'href' => base_url('index.php/extensions/wallet/post?user_token=' . $this->session->get('user_token')),
        ];

        $data['action'] = base_url('index.php/extensions/wallet/wallet?user_token=' . $this->session->get('user_token'));
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

        if ($this->request->getPost('wallet_extension_status')) {
            $data['wallet_extension_status'] = $this->request->getPost('wallet_extension_status');
        } elseif (!empty($this->registry->get('wallet_extension_status'))) {
            $data['wallet_extension_status'] = $this->registry->get('wallet_extension_status');
        } else {
            $data['wallet_extension_status'] = '';
        }

        $this->document->moduleOutput('Extensions', 'wallet\wallet_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extensions/wallet/wallet')) {
            $this->session->setFlashdata('error_warning', lang('wallet/wallet.error_permission'));
            return false;
        }
        return true;
    }

        
    //--------------------------------------------------------------------
}
