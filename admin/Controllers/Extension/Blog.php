<?php namespace Admin\Controllers\Extension;

use \Admin\Models\Setting\ExtensionModel;
use \Extensions\Models\Blog\BlogModel;
use \Admin\Models\User\UserGroupModel;
use \Admin\Models\Setting\SettingModel;

class Blog extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/blog.list.heading_title'));

        $extensionsModel = new ExtensionModel();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/blog.list.heading_title'));
        
        $extensionsModel = new ExtensionModel();

        if ($this->validateForm()) {

            $extensionsModel->install('blogger', $this->request->getVar('extension'));

            $userGroupModel = new UserGroupModel();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'extensions/blog/' . $this->request->getVar('extension'));
            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'extensions/blog/' . $this->request->getVar('extension'));

            $settingModel = new SettingModel();
            $settingModel->editSetting('blog_extension', ['blog_extension_status' => 1]);

            // Call install Method is exists
            $blogModel = new BlogModel();
            if (method_exists($blogModel, 'install')) {
                $blogModel->install();
            }

            $this->session->setFlashdata('success', lang('extension/blog.text_success'));
        }

       $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $extensionsModel = new ExtensionModel();

        if ($this->validateForm()) {
            $extensionsModel->uninstall('blogger', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $blogModel = new BlogModel();
            if (method_exists($blogModel, 'uninstall')) {
                $blogModel->uninstall();
            }

            $settingModel = new SettingModel();
            $settingModel->editSetting('blog_extension', ['blog_extension_status' => 0]);

            $this->session->setFlashdata('success', lang('extension/blog.text_success'));
        }

        $this->getList();
    }

    protected function getList()
    {
        $extensionsModel = new ExtensionModel();

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

        $installedExtensions = $extensionsModel->getInstalled('blogger');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Extensions/Controllers/Blog/' . ucfirst($value) . '.php')) {
                $extensionsModel->uninstall('blog', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Extensions/Controllers/Blog', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = [
                    'name'       => lang('blog/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('blog_extension_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/blog/install?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/blog/uninstall?user_token=' . $this->request->getVar('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/extensions/blog/' . strtolower($basename) .'?user_token=' . $this->request->getVar('user_token')),
                ];
            }
        }

        $this->document->output('extension/blog', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/blog')) {
            $this->session->setFlashdata('warning', lang('extension/blog.error_permission'));
            return false;
        }
        return true;
    }
    
    // --------------------------------------------------------------
}
