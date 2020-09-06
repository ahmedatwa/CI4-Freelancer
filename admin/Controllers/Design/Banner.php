<?php namespace Admin\Controllers\Design;

class Banner extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $this->document->setTitle(lang('design/banner.list.heading_title'));

        $this->banners = new \Admin\Models\Design\Banners();

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('design/banner.list.heading_title'));

        $this->banners = new \Admin\Models\Design\Banners();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->banners->addBanner($this->request->getPost());
            return redirect()->to(base_url('index.php/design/banner?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('design/banner.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('design/banner.list.heading_title'));

        $this->banners = new \Admin\Models\Design\Banners();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $this->banners->editBanner($this->request->getVar('banner_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/design/banner?user_token=' . $this->session->get('user_token')))
                              ->with('success', lang('design/banner.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = array();

        $this->document->setTitle(lang('design/banner.list.heading_title'));
   
        $this->banners = new \Admin\Models\Design\Banners();

        if ($this->request->getPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $banner_id) {
                $this->banners->deleteBanner($banner_id);
                $json['success'] = lang('design/banner.text_success');
                $json['redirect'] = 'index.php/design/banner?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('design/banner.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('design/banner.list.heading_title'),
            'href' => base_url('design/banner?user_token=' . $this->session->get('user_token'))
        );

        $data['add'] = base_url('index.php/design/banner/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/design/banner/delete?user_token=' . $this->session->get('user_token'));

        $data['banners'] = array();
        $filter_data = array(
            'start' => 0,
            'limit' => $this->registry->get('config_admin_limit'),
        );

        $results = $this->banners->getBanners($filter_data);

        foreach ($results as $result) {
            $data['banners'][] = array(
                'banner_id' => $result['banner_id'],
                'name'      => $result['name'],
                'status'    => ($result['status'] ? lang('en.list.text_enabled') : lang('en.list.text_disabled')),
                'edit'      => base_url('index.php/design/banner/edit?user_token=' . $this->session->get('user_token') . '&banner_id=' . $result['banner_id'])
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
            $data['selected'] = array();
        }

        $data['admin_limit'] = $this->registry->get('config_admin_limit');

        $this->document->output('design/banner_list', $data);
    }

    protected function getForm()
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        );

        $data['breadcrumbs'][] = array(
            'text' => lang('design/banner.list.heading_title'),
            'href' => base_url('index.php/design/banner?user_token=' . $this->session->get('user_token'))
        );

        $data['text_form'] = !$this->request->getGet('banner_id') ? lang('catalog/information.list.text_add') : lang('catalog/information.list.text_edit');

        $data['cancel'] = base_url('index.php/design/banner?user_token=' . $this->session->get('user_token'));

        if (!$this->request->getGet('banner_id')) {
            $data['action'] = base_url('index.php/design/banner/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/design/banner/edit?user_token=' . $this->session->get('user_token') . '&banner_id=' . $this->request->getVar('banner_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }


        if ($this->request->getGet('banner_id') && ($this->request->getMethod() != 'post')) {
            $banner_info = $this->banners->getBanner($this->request->getGet('banner_id'));
        }

        $data['user_token'] = $this->session->get('user_token');

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($banner_info)) {
            $data['name'] = $banner_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($banner_info)) {
            $data['status'] = $banner_info['status'];
        } else {
            $data['status'] = true;
        }

        $languages = new \Admin\Models\Localisation\Languages();
        $data['languages'] = $languages->findAll($this->registry->get('config_admin_limit'));

        if ($this->request->getPost('banner_image')) {
            $banner_images = $this->request->getPost('banner_image');
        } elseif ($this->request->getGet('banner_id')) {
            $banner_images = $this->banners->getBannerImages($this->request->getGet('banner_id'));
        } else {
            $banner_images = array();
        }


        $data['banner_images'] = array();

        foreach ($banner_images as $key => $value) {
            foreach ($value as $banner_image) {
                if (is_file(DIR_IMAGE . $banner_image['image'])) {
                    $image = $banner_image['image'];
                    $thumb = $banner_image['image'];
                } else {
                    $image = '';
                    $thumb = 'no_image.jpg';
                }
                
                $data['banner_images'][$key][] = array(
                    'banner_image_id' => $banner_image['banner_image_id'],
                    'title'           => $banner_image['title'],
                    'link'            => $banner_image['link'],
                    'image'           => $image,
                    'thumb'           => resizeImage($thumb, 100, 100),
                    'sort_order'      => $banner_image['sort_order']
                );
            }
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 100, 100);

        $this->document->output('design/banner_form', $data);
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'design/banner')) {
            $this->session->setFlashdata('error_warning', lang('design/banner.list.error_permission'));
            return false;
        }

        foreach ($this->request->getPost('banner_image') as $language_id => $result) {
            foreach ($result as $key => $value) {
                if (! $this->validate([
                "banner_image.{$language_id}.{$key}.title" => [
                    'label' => 'Title', 'rules' => 'required|min_length[2]|max_length[64]']
                ])) {
                    $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
                    return false;
                }
            }
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', $this->getRoute())) {
            $this->session->setFlashdata('error_warning', lang('design/banner.list.error_permission'));
            return false;
        }
        return true;
    }


    // ----------------------------------------------------------------------------
}
