<?php namespace Admin\Controllers\Extension\Extensions;

use Admin\Models\Setting\Extensions;

class Wallet extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/extensions/wallet.list.heading_title'));

        $this->extensions = new Extensions();

        $this->getList();
    }

    public function install()
    {
        
        $this->document->setTitle(lang('extension/extensions/wallet.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->install('wallet', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extension/wallet/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extension/wallet/' . $this->request->getVar('extension'));

            $setting_model = new \Admin\Models\Setting\Settings();
            $setting_model->editSetting('extension', ['project_wallet_status' => 1]);

            // Call install Method is exists
            $wallets_model = new \Admin\Models\Extension\wallet\wallets();
            if (method_exists($wallets_model, 'install')) {
                $wallets_model->install();
            }

            $this->session->setFlashdata('success', lang('extension/extensions/wallet.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('extension/extensions/wallet.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->uninstall('wallet', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $wallets_model = new \Admin\Models\Extension\wallet\wallets();
            if (method_exists($wallets_model, 'install')) {
                $wallets_model->uninstall();
            }

            $this->session->setFlashdata('success', lang('extension/extensions/wallet.text_success'));
        }

        $this->getList();
    }

    protected function getList()
    {
        if ($this->session->getFlashdata('warning')) {
            $data['error_warning'] = $this->session->getFlashdata('warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $installedExtensions = $this->extensions->getInstalled('wallet');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Controllers/Extension/wallet/' . $value . '.php')) {
                $this->extensions->uninstall('wallet', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Controllers/Extension/wallet', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = [
                    'name'       => lang('extension/wallet/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('project_wallet_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/extensions/wallet/install?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/extensions/wallet/uninstall?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extension/wallet/' . strtolower($basename) .'?user_token=' . $this->session->get('user_token')),
                ];
            }
        }

        $this->document->output('extension/extensions/wallet', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/extensions/wallet')) {
            $this->session->setFlashdata('warning', lang('extension/extensions/wallet.error_permission'));
            return false;
        }
        return true;
    }
    
    // --------------------------------------------------------------
}
