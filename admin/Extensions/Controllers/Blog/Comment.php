<?php namespace Extensions\Controllers\Blog;

use \Extensions\Models\Blog\BlogModel;

class Comment extends \Admin\Controllers\BaseController
{
    public function index()
    {
        $blogModel = new BlogModel();

        $this->document->setTitle(lang('blog/comment.list.heading_title'));

        $this->getList();
    }

    public function add()
    {
        $this->document->setTitle(lang('blog/comment.list.text_add'));

        $blogModel = new BlogModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $blogModel->addComment($this->request->getPost());
            return redirect()->to(base_url('index.php/extensions/blog/comment?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('blog/comment.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->document->setTitle(lang('blog/comment.list.text_edit'));

        $blogModel = new BlogModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $blogModel->editComment($this->request->getVar('comment_id'), $this->request->getPost());
            return redirect()->to(base_url('index.php/extensions/blog/comment?user_token=' . $this->request->getVar('user_token')))
                              ->with('success', lang('blog/comment.text_success'));
        }
        $this->getForm();
    }

    public function delete()
    {
        $json = [];

        $blogModel = new BlogModel();
   
        $this->document->setTitle(lang('blog/comment.list.heading_title'));

        if ($this->request->getcomment('selected')) {
            foreach ($this->request->getPost('selected') as $comment_id) {
                $blogModel->delete($comment_id);
                $json['success'] = lang('blog/comment.text_success');
                $json['redirect'] = 'index.php/extensions/blog/comment?user_token=' . $this->request->getVar('user_token');
            }
        } else {
            $json['error_warning'] = lang('blog/comment.error_permission');
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
            'text' => lang('blog/comment.list.heading_title'),
            'href' => base_url('index.php/extensions/blog/comment?user_token=' . $this->request->getVar('user_token')),
        ];

        // Data
        $blogModel = new BlogModel();

        $data['comments'] = [];

        $results = $blogModel->getComments($this->registry->get('config_admin_limit'));

        foreach ($results as $result) {
            $data['comments'][] = [
                'comment_id' => $result['comment_id'],
                'name'       => $result['name'],
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'date_added' => DateShortFormat($result['date_added']),
                'edit'       => base_url('index.php/extensions/blog/comment/edit?user_token=' . $this->request->getVar('user_token') . '&comment_id=' . $result['comment_id']),
                'delete'     => base_url('index.php/extensions/blog/comment/delete?user_token=' . $this->request->getVar('user_token') . '&comment_id=' . $result['comment_id']),
            ];
        }

        $data['add']    = base_url('index.php/extensions/blog/comment/add?user_token=' . $this->request->getVar('user_token'));
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

        $this->document->moduleOutput('Extensions', 'blog/comment_list', $data);
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
            'text' => lang('blog/comment.list.heading_title'),
            'href' => base_url('index.php/extensions/blog/comment/edit?user_token=' . $this->request->getVar('user_token')),
        ];

        $data['text_form'] = ! $this->request->getVar('comment_id') ? lang('blog/comment.list.text_add') : lang('blog/comment.list.text_edit');

        $data['cancel'] = base_url('index.php/extensions/blog/comment?user_token=' . $this->request->getVar('user_token'));

        if (!$this->request->getVar('comment_id')) {
            $data['action'] = base_url('index.php/extensions/blog/comment/add?user_token=' . $this->request->getVar('user_token'));
        } else {
            $data['action'] = base_url('index.php/extensions/blog/comment/edit?user_token=' . $this->request->getVar('user_token') . '&comment_id=' . $this->request->getVar('comment_id'));
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
        
        if ($this->request->getVar('comment_id') && ($this->request->getMethod() != 'comment')) {
            $comment_info = $blogModel->getComment($this->request->getVar('comment_id'));
        }

        if ($this->request->getPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($comment_info)) {
            $data['name'] = $comment_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->getPost('email')) {
            $data['email'] = $this->request->getPost('email');
        } elseif (!empty($comment_info)) {
            $data['email'] = $comment_info['email'];
        } else {
            $data['email'] = '';
        }

        if ($this->request->getPost('comment')) {
            $data['comment'] = $this->request->getPost('comment');
        } elseif (!empty($comment_info)) {
            $data['comment'] = $comment_info['comment'];
        } else {
            $data['comment'] = '';
        }
        
        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($comment_info)) {
            $data['status'] = $comment_info['status'];
        } else {
            $data['status'] = 1;
        }

        $this->document->moduleOutput('Extensions', 'blog/comment_form', $data);
    }

    protected function validateForm()
    {            
        if (! $this->user->hasPermission('modify', 'extensions/blog/comment')) {
            $this->session->setFlashdata('error_warning', lang('blog/comment.error_permission'));
            return false;
        }

        return true;
    }

    protected function validateDelete()
    {
        if (! $this->user->hasPermission('modify', 'extensions/blog/comment')) {
            $this->session->setFlashdata('error_warning', lang('blog/comment.error_permission'));
            return false;
        }
        return true;
    }

        
    //--------------------------------------------------------------------
}
