<?php namespace Extensions\Controllers\Blog;

use \Extensions\Models\Blog\BlogModel;

class Post extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $blogModel = new BlogModel();

        $this->document->setTitle(lang('blog/post.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('blog/post.list.text_add'));

        $blogModel = new BlogModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $blogModel->addPost($this->request->getPost());
            return redirect()->to(base_url('index.php/extensions/blog/post?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('blog/post.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('blog/post.list.text_edit'));

        $blogModel = new BlogModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $blogModel->editPost($this->request->getVar('post_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/extensions/blog/post?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('blog/post.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $blogModel = new BlogModel();
   
        $this->document->setTitle(lang('blog/post.list.heading_title'));

        if ($this->request->getPost('selected') ) {
            foreach ($this->request->getPost('selected') as $post_id) {
                $blogModel->delete($post_id);
                $json['success'] = lang('blog/post.text_success');
                $json['redirect'] = 'index.php/extensions/blog/post?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('blog/post.error_permission');
        }
        return $this->response->setJSON($json);
    }

    protected function getList()
    {

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extensions?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('blog/post.list.heading_title'),
            'href' => base_url('index.php/extensions/blog/post?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $blogModel = new BlogModel();

        $data['posts'] = [];

        $results = $blogModel->findAll($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['posts'][] = [
                'post_id'    => $result['post_id'],
                'title'      => $result['title'],
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'date_added' => DateShortFormat($result['date_added']),
                'edit'       => base_url('index.php/extensions/blog/post/edit?user_token=' . $this->request->getVar('user_token') . '&post_id=' . $result['post_id']),
                'delete'     => base_url('index.php/extensions/blog/post/delete?user_token=' . $this->request->getVar('user_token') . '&post_id=' . $result['post_id']),
            ];
        }

        $data['add']    = base_url('index.php/extensions/blog/post/add?user_token=' . $this->request->getVar('user_token'));
        $data['cancel'] = base_url('index.php/setting/extension?user_token=' . $this->request->getVar('user_token') . '&type=blog');

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

        $this->document->moduleOutput('Extensions', 'blog/post_list', $data);
    }

    protected function getForm()
    {
        
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('setting/extension.list.heading_title'),
            'href' => base_url('index.php/setting/extensions?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('blog/post.list.heading_title'),
            'href' => base_url('index.php/extensions/blog/post/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = !$this->request->getVar('post_id') ? lang('blog/post.list.text_add') : lang('blog/post.list.text_edit');

        $data['cancel'] = base_url('index.php/extensions/blog/post?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('post_id')) {
            $data['action'] = base_url('index.php/extensions/blog/post/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/extensions/blog/post/edit?user_token=' . $this->request->getVar('user_token') . '&post_id=' . $this->request->getVar('post_id'));
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
        
        if ($this->request->getVar('post_id') && ($this->request->getMethod() != 'post')) {
            $post_info = $blogModel->find($this->request->getVar('post_id'));
        }

        if ($this->request->getPost('user_id')) {
            $data['user_id'] = $this->user->getUserId();
        } else {
            $data['user_id'] = 0;
        }

        if ($this->request->getPost('title')) {
            $data['title'] = $this->request->getPost('title');
        } elseif (!empty($post_info)) {
            $data['title'] = $post_info['title'];
        } else {
            $data['title'] = '';
        }

        if ($this->request->getPost('body')) {
            $data['body'] = $this->request->getPost('body');
        } elseif (!empty($post_info)) {
            $data['body'] = $post_info['body'];
        } else {
            $data['body'] = '';
        }

        $data['categories'] = $blogModel->getCategories();

        if ($this->request->getPost('category_id')) {
            $data['category_id'] = $this->request->getPost('category_id');
        } elseif (!empty($post_info)) {
            $data['category_id'] = $post_info['category_id'];
        } else {
            $data['category_id'] = [];
        }

        if ($this->request->getPost('tags')) {
            $data['tags'] = $this->request->getPost('tags');
        } elseif (!empty($post_info)) {
            $data['tags'] = $post_info['tags'];
        } else {
            $data['tags'] = '';
        }

        if ($this->request->getPost('image')) {
            $data['image'] = $this->request->getPost('image');
        } elseif (!empty($post_info)) {
            $data['image'] = $post_info['image'];
        } else {
            $data['image'] = '';
        }

        if ($this->request->getPost('featured')) {
            $data['featured'] = $this->request->getPost('featured');
        } elseif (!empty($post_info)) {
            $data['featured'] = $post_info['featured'];
        } else {
            $data['featured'] = 0;
        }
        
        if ($this->request->getPost('trending')) {
            $data['trending'] = $this->request->getPost('trending');
        } elseif (!empty($post_info)) {
            $data['trending'] = $post_info['trending'];
        } else {
            $data['trending'] = 0;
        }

        if ($this->request->getPost('image') && is_file(DIR_IMAGE . $this->request->getPost('image'))) {
            $data['thumb'] = resizeImage($this->request->getPost('image'), 950, 450);
        } elseif (!empty($post_info) && is_file($post_info['image'])) {
            $data['thumb'] = resizeImage($post_info['image'], 950, 450);
        } else {
            $data['thumb'] = resizeImage('no_image.jpg', 950, 450);
        }

        $data['placeholder'] = resizeImage('no_image.jpg', 950, 450);

        
        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($post_info)) {
            $data['status'] = $post_info['status'];
        } else {
            $data['status'] = 1;
        }

        $this->document->moduleOutput('Extensions', 'blog/post_form', $data);
    }

    protected function validateForm()
    {
        if (! $this->validate([
                    'title'       => 'required',
                    'body'        => 'required',
                    'category_id' => 'required',
                    ])) {
            $this->session->setFlashdata('error_warning', lang('en.error.error_form'));
            return false;
        }
            
        if (! $this->user->hasPermission('modify', 'extensions/blog/post')) {
            $this->session->setFlashdata('error_warning', lang('blog/post.error_permission'));
            return false;
        } 

        return true;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'extensions/blog/post')) {
            $this->session->setFlashdata('error_warning', lang('blog/post.error_permission'));
            return false;
        } 
        return true;
    }

        
    //--------------------------------------------------------------------
}
