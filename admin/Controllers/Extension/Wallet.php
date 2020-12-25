<?php namespace Admin\Controllers\Extension;

use \Admin\Models\Setting\Extensions;

class Wallet extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/wallet.list.heading_title'));

        $extensionsModel = new Extensions();

        $this->getList();
    }

    public function install()
    {
        
        $this->document->setTitle(lang('extension/wallet.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->install('wallet', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/wallet/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/wallet/' . $this->request->getVar('extension'));

            $settingModel = new \Admin\Models\Setting\Settings();
            $settingModel->editSetting('wallet_extension', ['wallet_extension_status' => 1]);

            // Call install Method is exists
            $walletModel = new \Extensions\Models\wallet\walletModel();
            if (method_exists($walletModel, 'install')) {
                $walletModel->install();
            }

            $this->session->setFlashdata('success', lang('extension/wallet.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('extension/wallet.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->uninstall('wallet', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $walletModel = new \Extensions\Models\wallet\walletModel();
            if (method_exists($walletModel, 'install')) {
                $walletModel->uninstall();
            }

            $this->session->setFlashdata('success', lang('extension/wallet.text_success'));
        }

        $this->getList();
    }

    protected function getList()
    {
        $extensionsModel = new Extensions();

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

        $installedExtensions = $extensionsModel->getInstalled('wallet');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Wallet/' . ucfirst($value) . '.php')) {
                $extensionsModel->uninstall('wallet', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Wallet', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = [
                    'name'       => lang('wallet/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('wallet_extension_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/wallet/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/wallet/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extensions/wallet/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $this->document->output('extension/wallet', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/wallet')) {
            $this->session->setFlashdata('warning', lang('extension/wallet.error_permission'));
            return false;
        }
        return true;
    }
    
    // --------------------------------------------------------------
}
