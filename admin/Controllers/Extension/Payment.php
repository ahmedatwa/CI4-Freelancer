<?php namespace Admin\Controllers\Extension;

use Admin\Models\Setting\Extensions;

class Payment extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/payment.list.heading_title'));

        $extensionsModel = new Extensions();

        $this->getList();
    }

    public function install()
    {
        
        $this->document->setTitle(lang('extension/payment.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->install('payment', $this->request->getVar('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/payment/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/payment/' . $this->request->getVar('extension'));

            // Call install Method is exists
            $paymentModel = new \Extensions\Models\payment\paymentModel();
            if (method_exists($paymentModel, 'install')) {
                $paymentModel->install();
            }

            $this->session->setFlashdata('success', lang('extension/payment.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('extension/payment.list.heading_title'));

        $extensionsModel = new Extensions();

        if ($this->validateForm()) {
            $extensionsModel->uninstall('payment', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $paymentModel = new \Extensions\Models\payment\paymentModel();
            if (method_exists($paymentModel, 'install')) {
                $paymentModel->uninstall();
            }

            $this->session->setFlashdata('success', lang('extension/payment.text_success'));
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

        $installedExtensions = $extensionsModel->getInstalled('payment');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Payment/' . ucfirst($value) . '.php')) {
                $extensionsModel->uninstall('payment', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Payment', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = [
                    'name'       => lang('payment/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('payment_extension_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/payment/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/payment/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extensions/payment/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $this->document->output('extension/payment', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/payment')) {
            $this->session->setFlashdata('warning', lang('extension/payment.error_permission'));
            return false;
        }
        return true;
    }
    
    // --------------------------------------------------------------
}
