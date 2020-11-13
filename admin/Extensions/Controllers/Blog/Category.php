<?php namespace Extensions\Controllers\Blog;

use \Extensions\Models\Blog\BlogModel;

class Category extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $blogModel = new BlogModel();

        $this->document->setTitle(lang('blog/category.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('blog/category.list.text_add'));

        $blogModel = new BlogModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $blogModel->addcategory($this->request->getPost());
            return redirect()->to(base_url('index.php/extension/blog/category?user_token=' . $this->session->get('user_token')))
                             ->with('success', lang('blog/category.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('blog/category.list.text_edit'));

        $blogModel = new BlogModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $blogModel->editCategory($this->request->getVar('category_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/extension/blog/category?user_token=' . $this->session->get('user_token')))
                             ->with('success', lang('blog/category.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $blogModel = new BlogModel();
   
        $this->document->setTitle(lang('blog/category.list.heading_title'));

        if ($this->request->getcategory('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $category_id) {
                $blogModel->deleteCategory($category_id);
                $json['success'] = lang('blog/category.text_success');
                $json['redirect'] = 'index.php/extension/blog/category?user_token=' . $this->session->get('user_token');
            }
        } else {
            $json['error_warning'] = lang('blog/category.error_permission');
        }
        return $this->response->setJSON($json);
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
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extensions?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/blog.list.heading_title'),
            'href' => base_url('index.php/setting/extensions/?user_token=' . $this->session->get('user_token') . '&type=blog'),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('blog/category.list.heading_title'),
            'href' => base_url('index.php/extension/blog/category?user_token=' . $this->session->get('user_token')),
        ];

        // Data
        $blogModel = new BlogModel();

        $data['categories'] = [];
        $results =  $blogModel->getCategories($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['categories'][] = [
                'category_id'    => $result['category_id'],
                'name'      => $result['name'],
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'edit'       => base_url('index.php/extension/blog/category/edit?user_token=' . $this->session->get('user_token') . '&category_id=' . $result['category_id']),
                'delete'     => base_url('index.php/extension/blog/category/delete?user_token=' . $this->session->get('user_token') . '&category_id=' . $result['category_id']),
            ];
        }

        $data['add'] = base_url('index.php/extension/blog/category/add?user_token=' . $this->session->get('user_token'));
        $data['delete'] = base_url('index.php/extension/blog/category/delete?user_token=' . $this->session->get('user_token'));
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->session->get('user_token') . '&type=blog');

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

        if ($this->request->getPost('selected')) {
            $data['selected'] = (array) $this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['user_token'] = $this->request->getGet('user_token');

        $this->document->moduleOutput('Extensions', 'blog/category_list', $data);

    }

    protected function getForm()
    {
        
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extensions?user_token=' . $this->session->get('user_token')),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('extension/extensions/blog.list.heading_title'),
            'href' => base_url('index.php/setting/extensions/?user_token=' . $this->session->get('user_token') . '&type=blog'),
        ];
        $data['breadcrumbs'][] = [
            'text' => lang('blog/category.list.heading_title'),
            'href' => base_url('index.php/extension/blog/category/edit?user_token=' . $this->session->get('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('category_id') ? lang('blog/category.list.text_add') : lang('blog/category.list.text_edit');

        $data['cancel'] = base_url('index.php/extension/blog/category?user_token=' . $this->session->get('user_token'));

        if (!$this->request->getVar('category_id')) {
            $data['action'] = base_url('index.php/extension/blog/category/add?user_token=' . $this->session->get('user_token'));
        } else {
            $data['action'] = base_url('index.php/extension/blog/category/edit?user_token=' . $this->session->get('user_token') . '&category_id=' . $this->request->getVar('category_id'));
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

        $blogModel = new BlogModel();
        
        if ($this->request->getVar('category_id') && ($this->request->getMethod() != 'category')) {
             $category_info = $blogModel->getCategory($this->request->getVar('category_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($category_info)) {
            $data['name'] = $category_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($category_info)) {
            $data['status'] = $category_info['status'];
        } else {
            $data['status'] = 0;
        }

        $data['user_token'] = $this->session->get('user_token');

        $this->document->moduleOutput('Extensions', 'blog/category_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                    'name'    => 'required|min_length[3]',
                    ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }
            
        if (! $this->user->hasPermission('modify', 'extensions/blog/category')) {
            $this->session->setFlashdata('error_warning', lang('blog/category.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'extensions/blog/category')) {
            $this->session->setFlashdata('error_warning', lang('blog/category.error_permission'));
            return false;
        }
        return true;
    }

        
    //--------------------------------------------------------------------
}
