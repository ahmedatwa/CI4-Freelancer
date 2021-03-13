<?php namespace Admin\Controllers\Design;

use \Admin\Models\Design\LayoutModel;
use \Admin\Models\Setting\ExtensionModel;
use \Admin\Models\Setting\ModuleModel;

class Layout extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('design/layout.list.heading_title'));

        $layoutModel = new LayoutModel();

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('design/layout.list.heading_title'));

        $layoutModel = new LayoutModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $layoutModel->addLayout($this->request->getPost());
            return redirect()->to(base_url('index.php/design/layout?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('design/layout.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('design/layout.list.heading_title'));

        $layoutModel = new LayoutModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $layoutModel->editLayout($this->request->getVar('layout_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/design/layout?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('design/layout.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $this->document->setTitle(lang('design/layout.list.heading_title'));
   
        $layoutModel = new LayoutModel();

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $layout_id) {
                $layoutModel->deleteLayout($layout_id);
                $json['success'] = lang('design/layout.text_success');
                $json['redirect'] = 'index.php/design/layout?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('design/layout.error_permission');
        }
        return $this->response->setJSON($json);
    }
    
    protected function getList()
    {
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('design/layout.list.heading_title'),
            'href' => base_url('index.php/design/layout?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['add'] = base_url('index.php/design/layout/add?user_token=' . $this->request->getVar('user_token'));
        $data['delete'] = base_url('index.php/design/layout/delete?user_token=' . $this->request->getVar('user_token'));

        $data['layouts'] = [];

        $layoutModel = new LayoutModel();

        $results = $layoutModel->getLayouts();

        foreach ($results as $result) {
            $data['layouts'][] = array(
                'layout_id' => $result['layout_id'],
                'name'      => $result['name'],
                'edit'      => base_url('index.php/design/layout/edit?user_token=' . $this->request->getVar('user_token') . '&layout_id=' . $result['layout_id'])
            );
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->request->getPost()['selected'])) {
            $data['selected'] = (array)$this->request->getPost()['selected'];
        } else {
            $data['selected'] = [];
        }

        $this->document->output('design/layout_list', $data);
    }

    protected function getForm()
    {
        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('design/layout.list.heading_title'),
            'href' => base_url('index.php/design/layout?user_token=' . $this->request->getVar('user_token'))
        ];

        $data['text_form'] = !$this->request->getVar('layout_id') ? lang('design/layout.list.text_add') : lang('design/layout.list.text_edit');

        $data['cancel'] = base_url('index.php/design/layout?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('layout_id')) {
            $data['action'] = base_url('index.php/design/layout/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/design/layout/edit?user_token=' . $this->request->getVar('user_token') . '&layout_id=' . $this->request->getVar('layout_id'));
        }

        $data['user_token'] = $this->request->getVar('user_token');

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $layoutModel = new LayoutModel();

        if ($this->request->getVar('layout_id') && ($this->request->getMethod() != 'post')) {
            $layout_info = $layoutModel->getLayout($this->request->getVar('layout_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($layout_info['name'])) {
            $data['name'] = $layout_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('layout_route')) {
            $data['layout_route'] = $this->request->getPost('layout_route');
        } elseif ($this->request->getVar('layout_id')) {
            $data['layout_route'] = $layoutModel->getLayoutRoutes($this->request->getVar('layout_id'));
        } else {
            $data['layout_route'] = '';
        }

        $extensionModel = new ExtensionModel();
        $moduleModel = new ModuleModel();
        $layoutModel = new LayoutModel();

        $data['extensions'] = [];
        
        // Get a list of installed modules
        $extensions = $extensionModel->getInstalled('module');

        // Add all the modules which have multiple settings for each module
        foreach ($extensions as $code) {
            $module_data = [];

            $modules = $moduleModel->getModulesByCode($code);

            foreach ($modules as $module) {
                $module_data[] = [
                    'name' => strip_tags(lang('module/' . $code . '.list.heading_title') . ' &gt; ' . $module['name']),
                    'code' => $code . '.' .  $module['module_id']
                ];
            }

            if ($this->registry->get('module_' . $code . '_status') || $module_data) {
                $data['extensions'][] = [
                    'name'   => strip_tags(lang('module/' . $code . '.list.heading_title')),
                    'code'   => $code,
                    'module' => $module_data
                ];
            }
        }

        // Modules layout
        if ($this->request->getPost('layout_module')) {
            $layout_modules = $this->request->getPost('layout_module');
        } elseif ($this->request->getVar('layout_id')) {
            $layout_modules = $layoutModel->getLayoutModules($this->request->getVar('layout_id'));
        } else {
            $layout_modules = [];
        }

        $data['layout_modules'] = [];
        
        // Add all the modules which have multiple settings for each module
        foreach ($layout_modules as $layout_module) {

            $part = explode('.', $layout_module['code']);

            if (!isset($part[1])) {
                $data['layout_modules'][] = [
                    'name'       => strip_tags(lang('design/layout.list.heading_title')),
                    'code'       => $layout_module['code'],
                    'edit'       => base_url('index.php/module/' . $part[0], '?user_token=' . $this->request->getVar('user_token'), true),
                    'position'   => $layout_module['position'],
                    'sort_order' => $layout_module['sort_order']
                ];
            } else {
                $module_info = $moduleModel->getModule($part[1]);
                
                if ($module_info) {
                    $data['layout_modules'][] = [
                        'name'       => strip_tags($module_info['name']),
                        'code'       => $layout_module['code'],
                        'edit'       => base_url('index.php/module/' . $part[0], '?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $part[1]),
                        'position'   => $layout_module['position'],
                        'sort_order' => $layout_module['sort_order']
                    ];
                }
            }
        }
        
        $this->document->output('design/layout_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'design/layout')) {
            $this->error['warning'] = lang('design/layout.list.error_permission');
            return false;
        }

        if (! $this->validate([
            "name" => 'required|min_length[3]|max_length[64]'
        ])) {
            $this->session->setFlashdata('error_warning', lang('design/layout.list.error_name'));
            return false;
        }
        
        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('design/layout.error_permission'));
            return false;
        }

        foreach ($this->request->getPost('selected') as $layout_id) {
            if ($this->registry->get('config_layout_id') == $layout_id) {
                $this->session->setFlashdata('error_warning', lang('design/layout.list.error_default'));
            }
        }

        return true;
    }
}
