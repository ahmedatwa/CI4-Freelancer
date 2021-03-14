<?php 

namespace Admin\Controllers\Module;

use Admin\Controllers\BaseController;
use Admin\Models\Setting\SettingModel;
use Admin\Models\Setting\ModuleModel;

class Bid_upgrade extends BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('bid_upgrade.list.heading_title'));

        $settingModel = new SettingModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $settingModel->editSetting('module_bid_upgrade', $this->request->getPost());

            return redirect()->to(base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token')))
                             ->with('success', lang('setting/module.text_success'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard', 'user_token=' . $this->request->getVar('user_token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('module/bid_upgrade.list.text_module'),
            'href' => base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (! $this->request->getVar('module_id')) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/bid_upgrade.list.heading_title'),
                'href' => base_url('index.php/module/bid_upgrade?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => base_url('index.php/module/bid_upgrade?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        if (! $this->request->getVar('module_id')) {
            $data['action'] = base_url('index.php/module/bid_upgrade?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/module/bid_upgrade?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
        }

        $data['cancel'] = base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getPost('module_bid_upgrade_status')) {
            $data['module_bid_upgrade_status'] = $this->request->getPost('module_bid_upgrade_status');
        } elseif ($this->registry->get('module_bid_upgrade_status')) {
            $data['module_bid_upgrade_status'] = $this->registry->get('module_bid_upgrade_status');
        } else {
            $data['module_bid_upgrade_status'] = '';
        }

        if ($this->request->getPost('module_bid_upgrade_setting')) {
            $data['module_bid_upgrade_setting'] = $this->request->getPost('module_bid_upgrade_setting');
        } elseif (!empty($this->registry->get('module_bid_upgrade_setting'))) {
            $data['module_bid_upgrade_setting'] = json_decode($this->registry->get('module_bid_upgrade_setting'), true);
        } else {
            $data['module_bid_upgrade_setting'] = [];
        }

        $this->document->output('module/bid_upgrade', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'module/bid_upgrade')) {
            $this->session->setFlashdata('error_warning', lang('module/bid_upgrade.error_permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
