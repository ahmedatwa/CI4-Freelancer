<?php namespace Admin\Controllers\Module;

use \Admin\Models\Setting\Modules;

class Video extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('module/video.list.heading_title'));

        $modules = new Modules();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
               if (! $this->request->getVar('module_id')) {
                   $modules->addModule('video', $this->request->getPost());
            } else {
                   $modules->editModule($this->request->getVar('module_id'), $this->request->getPost());
            }

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
            'text' => lang('module/account.list.text_module'),
            'href' => base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (! $this->request->getVar('module_id')) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/video.list.heading_title'),
                'href' => base_url('index.php/module/video?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('module/video.list.heading_title'),
                'href' => base_url('index.php/module/video?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        if (! $this->request->getVar('module_id')) {
            $data['action'] = base_url('index.php/module/video?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/module/video?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
        }

        $data['cancel'] = base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'));

        if ($this->request->getVar('module_id') && ($this->request->getMethod() != 'post')) {
            $module_info = $modules->getModule($this->request->getVar('module_id'));
        }

       if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('module_description')) {
            $data['module_description'] = $this->request->getPost('module_description');
        } elseif (!empty($module_info)) {
            $data['module_description'] = $module_info['module_description'];
        } else {
            $data['module_description'] = [];
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        if ($this->request->getPost('image') && is_file(DIR_IMAGE . $this->request->getPost('image'))) {
            $data['thumb'] = resizeImage($this->request->getPost('image'), 864, 415);
        } elseif (isset($module_info['module_description']['image']) && is_file(DIR_IMAGE . $module_info['module_description']['image'])) {
            $data['thumb'] = resizeImage($module_info['module_description']['image'], 200, 100);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 200, 100);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 200, 100);


        $this->document->output('module/video', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'module/video')) {
            $this->session->setFlashdata('error_warning', lang('module/video.error_permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
