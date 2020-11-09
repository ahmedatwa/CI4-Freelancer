<?php namespace Admin\Controllers\Module;

use \Admin\Models\Setting\Modules;

class Carousel extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('module/carousel.list.heading_title'));

        $modules = new Modules();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            if (! $this->request->getVar('module_id')) {
                $modules->addModule('carousel', $this->request->getPost());
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
            'text' => lang('module/carousel.list.text_extension'),
            'href' => base_url('index.php/setting/module?user_token=' . $this->request->getVar('user_token'))
        ];

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = [
                'text' => lang('module/carousel.list.heading_title'),
                'href' => base_url('index.php/module/carousel?user_token=' . $this->request->getVar('user_token'))
            ];
        } else {
            $data['breadcrumbs'][] = [
                'text' => lang('heading_title'),
                'href' => base_url('index.php/module/carousel?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'))
            ];
        }

        if (! $this->request->getVar('module_id')) {
            $data['action'] = base_url('index.php/module/carousel?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/module/carousel?user_token=' . $this->request->getVar('user_token') . '&module_id=' . $this->request->getVar('module_id'));
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

        if ($this->request->getPost('banner_id')) {
            $data['banner_id'] = $this->request->getPost('banner_id');
        } elseif (!empty($module_info)) {
            $data['banner_id'] = $module_info['banner_id'];
        } else {
            $data['banner_id'] = '';
        }

        if ($this->request->getPost('width')) {
            $data['width'] = $this->request->getPost('width');
        } elseif (!empty($module_info)) {
            $data['width'] = $module_info['width'];
        } else {
            $data['width'] = 130;
        }

        if ($this->request->getPost('height')) {
            $data['height'] = $this->request->getPost('height');
        } elseif (!empty($module_info)) {
            $data['height'] = $module_info['height'];
        } else {
            $data['height'] = 100;
        }

        if ($this->request->getPost('autoplay')) {
            $data['autoplay'] = $this->request->getPost('autoplay');
        } elseif (!empty($module_info['autoplay'])) {
            $data['autoplay'] = $module_info['autoplay'];
        } else {
            $data['autoplay'] = true;
        }

        if ($this->request->getPost('dots')) {
            $data['dots'] = $this->request->getPost('dots');
        } elseif (!empty($module_info['dots'])) {
            $data['dots'] = $module_info['dots'];
        } else {
            $data['dots'] = true;
        }

        if ($this->request->getPost('infinite')) {
            $data['infinite'] = $this->request->getPost('infinite');
        } elseif (!empty($module_info['infinite'])) {
            $data['infinite'] = $module_info['infinite'];
        } else {
            $data['infinite'] = true;
        }

        if ($this->request->getPost('arrows')) {
            $data['arrows'] = $this->request->getPost('arrows');
        } elseif (!empty($module_info['arrows'])) {
            $data['arrows'] = $module_info['arrows'];
        } else {
            $data['arrows'] = false;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = 1;
        }

        $banners_model = new \Admin\Models\Design\Banners();
        $data['banners'] = $banners_model->getBanners();

        $this->document->output('module/carousel', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                'name'   => 'required|min_length[3]',
                'width'  => 'required|alpha_numeric',
                'height' => 'required|alpha_numeric',
            ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }

        if (!$this->user->hasPermission('modify', 'module/carousel')) {
            $this->session->setFlashdata('error_warning', lang('module/carousel.error_permission'));
            return false;
        }
        return true;
    }

    // ---------------------------------------------------------------
}
