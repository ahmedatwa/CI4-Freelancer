<?php namespace Admin\Controllers\Extension\Extensions;

use Admin\Models\Setting\Extensions;

class Bid extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $this->extensions = new Extensions();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->install('bid', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extension/bid/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extension/bid/' . $this->request->getVar('extension'));

            $setting_model = new \Admin\Models\Setting\Settings();
            $setting_model->editSetting('extension', ['project_bid_status' => 1]);

            // Call install Method is exists
            $bids_model = new \Admin\Models\Extension\Bid\Bids();
            if (method_exists($bids_model, 'install')) {
                $bids_model->install();
            }

            $this->session->setFlashdata('success', lang('setting/extension.list.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->uninstall('bid', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $bids_model = new \Admin\Models\Extension\Bid\Bids();
            if (method_exists($bids_model, 'install')) {
                $bids_model->uninstall();
            }

            $this->session->setFlashdata('success', lang('setting/extension.list.text_success'));
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

        $installedExtensions = $this->extensions->getInstalled('bid');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Controllers/Extension/bid/' . $value . '.php')) {
                $this->extensions->uninstall('bid', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = array();
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Controllers/Extension/bid', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = array(
                    'name'       => lang('extension/bid/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('project_bid_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/extensions/bid/install?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/extensions/bid/uninstall?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extension/bid/' . strtolower($basename) .'?user_token=' . $this->session->get('user_token')),
                );
            }
        }

        $this->document->output('extension/extensions/bid', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/extensions/bid')) {
            $this->session->setFlashdata('warning', lang('extension/extensions/bid.error_permission'));
            return false;
        }
        return true;
    }
    
    // --------------------------------------------------------------
}
