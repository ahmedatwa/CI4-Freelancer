<?php namespace Admin\Controllers\Extension\Extensions;

use Admin\Models\Setting\Extensions;

class Blog extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('extension/extensions/blog.list.heading_title'));

        $this->extensions = new Extensions();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('extension/extensions/blog.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->install('blog', $this->request->getVar('extension'));

            $user_group_model = new \Admin\Models\User\Users_group();

            $user_group_model->addPermission($this->user->getGroupId(), 'access', 'extension/blog/' . $this->request->getVar('extension'));
            $user_group_model->addPermission($this->user->getGroupId(), 'modify', 'extension/blog/' . $this->request->getVar('extension'));

            $setting_model = new \Admin\Models\Setting\Settings();
            $status = ['blog_status' => 1];
            $setting_model->editSetting('extension', $status);

            // Call install Method is exists
            $blog_model = new \Admin\Models\Extension\Blog\Blogs();
            if (method_exists($blog_model, 'install')) {
                $blog_model->install();
            }

            $this->session->setFlashdata('success', lang('extension/extensions/blog.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $this->extensions = new Extensions();

        if ($this->validateForm()) {
            $this->extensions->uninstall('blog', $this->request->getVar('extension'));
            // Call uninstall Method is exists
            $blog_model = new \Admin\Models\Extension\Blog\Blogs();
            if (method_exists($blog_model, 'uninstall')) {
                $blog_model->uninstall();
            }

            $this->session->setFlashdata('success', lang('extension/extensions/blog.text_success'));
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

        $installed_extensions = $this->extensions->getInstalled('blog');

        foreach ($installed_extensions as $key => $value) {
            if (!is_file(APPPATH . 'Controllers/Extension/blog/' . $value . '.php')) {
                $this->extensions->uninstall('blog', $value);
                unset($installed_extensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Controllers/Extension/blog', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');
                
                $data['extensions'][] = [
                    'name'       => lang('extension/blog/' . strtolower($basename) . '.list.heading_title'),
                    'status'     => ($this->registry->get('blog_status')) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'install'    => base_url('index.php/extension/extensions/blog/install?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/extension/extensions/blog/uninstall?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installed_extensions),
                    'edit'       => base_url('index.php/extension/blog/' . strtolower($basename) .'?user_token=' . $this->session->get('user_token')),
                ];
            }
        }

        $this->document->output('extension/extensions/blog', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'extension/extensions/blog')) {
            $this->session->setFlashdata('warning', lang('extension/extensions/blog.error_permission'));
            return false;
        }
        return true;
    }
    
    // --------------------------------------------------------------
}
