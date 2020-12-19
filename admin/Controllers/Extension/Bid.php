<?php namespace Admin\Controllers\Extension;

use \Admin\Models\Setting\ExtensionModel;
use \Admin\Models\User\UserGroupModel;
use \Admin\Models\Setting\SettingModel;
use \Extensions\Models\Bid\BidModel;

class Bid extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/bid.list.heading_title'));

        $extensionModel = new ExtensionModel();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/bid.list.heading_title'));

        $extensionModel = new ExtensionModel();

        if ($this->validateForm()) {
            $extensionModel->install('project', $this->request->getVar('extension'));

            $userGroupModel = new UserGroupModel();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'ExtensionModel()/bid/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'ExtensionModel()/bid/' . $this->request->getVar('extension'));
            // Add Setting Key Since extension has no config Values
            $settingModel = new SettingModel();
            $settingModel->editSetting('extension_bid', ['extension_bid_status' => 1]);

            // Call install Method is exists
            $bidsModel = new BidModel();
            if (method_exists($bidsModel, 'install')) {
                $bidsModel->install();
            }

            $this->session->setFlashdata('success', lang('extension/bid.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('extension/bid.list.heading_title'));

        $extensionModel = new ExtensionModel();

        if ($this->validateForm()) {
            $extensionModel->uninstall('project', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $bidsModel = new BidModel();
            if (method_exists($bidsModel, 'uninstall')) {
                $bidsModel->uninstall();
            }

            $this->session->setFlashdata('success', lang('extension/bid.text_success'));
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

        $extensionModel = new ExtensionModel();

        $installedExtensions = $extensionModel->getInstalled('project');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/bid/' . ucfirst($value) . '.php')) {
                $extensionModel->uninstall('project', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['ExtensionModel()'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'ExtensionModel()/Controllers/Bid', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['ExtensionModel()'][] = [
                    'name'       => lang('bid/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('extension_bid_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php//bid/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/bid/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions,
                    'edit'       => base_url('index.php/ExtensionModel()/bid/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $this->document->output('extension/bid', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/bid')) {
            $this->session->setFlashdata('warning', lang('extension/bid.error_permission'));
            return false;
        }
        return true;
    }
    
    // --------------------------------------------------------------
}
