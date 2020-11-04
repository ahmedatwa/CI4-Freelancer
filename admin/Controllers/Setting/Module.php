<?php namespace Admin\Controllers\Setting;

class Module extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('setting/extension.list.heading_title'));

        $this->extensions = new \Admin\Models\Setting\Extensions();
        $this->modules = new \Admin\Models\Setting\Modules();

        $this->getList();
    }

    public function install()
    {
        $this->document->setTitle(lang('setting/module.list.heading_title'));

        $this->extensions = new \Admin\Models\Setting\Extensions();

        $this->modules = new \Admin\Models\Setting\Modules();

        if ($this->validateForm()) {
            $this->extensions->install('module', $this->request->getGet('extension'));

            $userGroupModel = new \Admin\Models\User\Users_group();

            $userGroupModel->addPermission($this->user->getGroupId(), 'access', 'module/' . $this->request->getVar('extension'));

            $userGroupModel->addPermission($this->user->getGroupId(), 'modify', 'module/' . $this->request->getVar('extension'));

            $this->session->setFlashdata('success', lang('setting/module.text_success'));
        }

        $this->getList();
    }

    public function uninstall()
    {
        $this->document->setTitle(lang('setting/module.list.heading_title'));

        $this->extensions = new \Admin\Models\Setting\Extensions();
        
        $this->modules = new \Admin\Models\Setting\Modules();

        if ($this->validateForm()) {
            $this->extensions->uninstall('module', $this->request->getVar('extension'));
            $this->modules->deleteModulesByCode($this->request->getVar('extension'));

            $this->session->setFlashdata('success', lang('setting/module.text_success'));
        }

        $this->getList();
    }

    public function add()
    {
        $this->extensions = new \Admin\Models\Setting\Extensions();
        
        $this->modules = new \Admin\Models\Setting\Modules();

        if ($this->validate()) {
            $name = $this->request->getPost('extension');
            
            $this->modules->addModule($this->request->getVar('extension'), lang("module/{$name}.list.heading_title"));

            $this->session->setFlashdata('success', lang('extenaion/extensions/module.text_success'));
        }

        $this->getList();
    }

    public function delete()
    {
        $this->extensions = new \Admin\Models\Setting\Extensions();
        
        $this->modules = new \Admin\Models\Setting\Modules();

        if ($this->request->getVar('module_id') && $this->validateForm()) {
            $this->modules->deleteModule($this->request->getVar('module_id'));

            $this->session->setFlashdata('success', lang('setting/module.text_success'));
        }
        
        $this->getList();
    }
    
    protected function getList()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/module.list.heading_title'),
            'href' => base_url('index.php/setting/module?user_token=' . $this->session->get('user_token')),
        ];


        $data['text_layout'] = sprintf(lang('setting/module.list.text_layout'), base_url('index.php/design/layout?user_token=' . $this->session->get('user_token')));

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $installedExtensions = $this->extensions->getInstalled('module');

        foreach ($installedExtensions as $key => $value) {
            if (!is_file(APPPATH . 'Controllers/Module/' . $value . '.php')) {
                $this->extensions->uninstall('module', $value);
                unset($installedExtensions[$key]);
            }
        }

        $data['extensions'] = [];
        
        helper('filesystem');

        $files = directory_map(APPPATH . 'Controllers/Module', 1);

        if ($files) {
            foreach ($files as $file) {
                $basename = basename($file, '.php');

                $module_data = [];

                $modules = $this->modules->getModulesByCode($basename);

                foreach ($modules as $module) {
                    if ($module['setting']) {
                        $setting_info = json_decode($module['setting'], true);
                    } else {
                        $setting_info = [];
                    }
                    
                    $module_data[] = [
                        'module_id' => $module['module_id'],
                        'name'      => $module['name'],
                        'status'    => (isset($setting_info['status']) && $setting_info['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                        'edit'      => base_url('index.php/module/' . strtolower($basename) . '?user_token=' . $this->session->get('user_token') . '&module_id=' . $module['module_id']),
                        'delete'    => base_url('index.php/setting/module/delete?user_token=' . $this->session->get('user_token') . '&module_id=' . $module['module_id'])
                    ];
                }

                $data['extensions'][] = [
                    'name'       => lang('module/' . strtolower($basename) . '.list.heading_title'),
                    'width'      => $this->registry->get('module_' . strtolower($basename) . '_width'),
                    'status'     => $this->registry->get('module_' . strtolower($basename) . '_status') ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                    'sort_order' => $this->registry->get('module_' . strtolower($basename) . '_sort_order'),
                    'module'     => $module_data,
                    'install'    => base_url('index.php/setting/module/install?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'uninstall'  => base_url('index.php/setting/module/uninstall?user_token=' . $this->session->get('user_token') . '&extension=' . strtolower($basename)),
                    'installed'  => in_array(strtolower($basename), $installedExtensions),
                    'edit'       => base_url('index.php/module/' . strtolower($basename) .'?user_token=' . $this->session->get('user_token')),
                ];
            }
        }


        $this->document->output('setting/module', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'setting/module')) {
            $this->session->setFlashdata('warning', lang('setting/module.error_permission'));
        } else {
            return true;
        }
    }
}
