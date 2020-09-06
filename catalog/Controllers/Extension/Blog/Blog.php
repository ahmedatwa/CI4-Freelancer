<?php namespace Catalog\Controllers\Extension\Blog;

class Blog extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        $this->template->setTitle(lang('extension/blog/blog.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/blog/blog.heading_title'),
            'href' => base_url('index.php/extension/blog?user_token=' . $this->session->get('user_token')),
        ];

        $filter_data = [
            'start'   => 0,
            'limit'   => 20
        ];

        $data['posts'] = [];
        $blog_model = new \Catalog\Models\Extension\Blog\Blogs();
        $results = $blog_model->getPosts($filter_data);

        foreach ($results as $result) {
            $data['posts'][] = [
                'title' => $result['title'],
                'image' => $result['image'],
                'body'  => $result['body'],
                'href'  => base_url('blog/post?post_id=' . $result['post_id'])
            ];
        }

        $this->template->output('extension/blog/blog', $data);
    }


    public function post()
    {
        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url('index.php/common/dashboard?user_token=' . $this->session->get('user_token')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/blog/blog.heading_title'),
            'href' => base_url('index.php/extension/blog?user_token=' . $this->session->get('user_token')),
        ];

        if ($this->request->getVar('post_id')) {
            $post_id = $this->request->getVar('post_id');
        } else {
            $post_id = null;
        }

        $blog_model = new \Catalog\Models\Extension\Blog\Blogs();
        $post_info = $blog_model->getPost($post_id);

        if ($post_info) {
            $data['title'] = $post_info['title'];
            $data['category']  = $post_info['category'];
            $data['body']  = $post_info['body'];
            $data['image'] = $post_info['image'];
        } else {
            $data['title'] = '';
            $data['category']  = '';
            $data['body']  = '';
            $data['image'] = '';
        }

        $this->template->output('extension/blog/post', $data);
    }

    // --------------------------------------------------------------
}
