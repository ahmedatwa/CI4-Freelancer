<?php namespace Admin\Controllers\Extension;
/*----
@ Extension to Extend Project to Apply Bidding System
------*/
use Admin\Models\Setting\Extensions;

class Bid extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/bid.list.heading_title'));

        $extensionsModel = new Extensions();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/bid.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->install('project', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/bid/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/bid/' . $this->request->getVar('extension'));
            // Add Setting Key Since extension has no config Values
            $settingModel = new \Admin\Models\Setting\Settings();
            $settingModel->editSetting('bidding_extension', ['bidding_extension_status' => 1]);

            // Call install Method is exists
            $bidsModel = new \Extensions\Models\Bid\BidModel();
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

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->uninstall('project', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $bidsModel = new \Extensions\Models\Bid\BidModel();
            if (method_exists($bidsModel, 'uninstall')) {
                $bidsModel->uninstall();
            }

            $this->session->setFlashdata('success', lang('extension/bid.text_success'));
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

        $installedExtensions = $extensionsModel->getInstalled('project');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/bid/' . ucfirst($value) . '.php')) {
                $extensionsModel->uninstall('project', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Bid', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = [
                    'name'       => lang('bid/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('project_bidding_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/bid/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/bid/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extensions/bid/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
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
