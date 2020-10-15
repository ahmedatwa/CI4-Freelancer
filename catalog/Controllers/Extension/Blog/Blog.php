<?php namespace Catalog\Controllers\Extension\Blog;

use \Catalog\Models\Extension\Blog\BlogModel;

class Blog extends \Catalog\Controllers\BaseController
{
    public function view()
    {
      $this->template->setTitle(lang('extension/blog/blog.heading_title'));

      $blogMdel = new BlogModel();

      $this->getPost();

    }

    public function index()
    {
        $this->template->setTitle(lang('extension/blog/blog.heading_title'));

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/blog/blog.heading_title'),
            'href' => route_to('blog'),
        ];

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'b.date_added';
        }
       
        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 20;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
            'sort_by'    => $sort_by,
            'order_by'   => $order_by,
            'limit'      => $limit,
            'start'      => ($page - 1) * $limit,
        ];

        $data['posts'] = [];

        $blogMdel = new BlogModel();
        $results = $blogMdel->getPosts($filter_data);
        $total = $blogMdel->getTotalPosts();

        helper('text');
        $seo_url = service('seo_url');

        foreach ($results as $result) {
            $keyword = $seo_url->getKeywordByQuery('post_id=' . $result['post_id']);
            if ($result['image']) {
                $image = $this->resize($result['image'], 260, 270);
            } else {
                $image = $this->resize('catalog/no_image.jpg', 260, 270);
            }

            $data['posts'][] = [
                'title' => $result['title'],
                'image' => $image,
                'body'  => word_limiter($result['body'], 80),
                'href'  => ($keyword) ? route_to('blog/post', $keyword) : base_url('extension/blog/blog/view?post_id=' . $result['post_id']),
                'date_added' => $this->dateDifference($result['date_added']),
            ];
        }

        $data['featured'] = [];
        $featured = $blogMdel->getFeaturedPosts(10);
        foreach ($featured as $result) {
            $keyword = $seo_url->getKeywordByQuery('post_id=' . $result['post_id']);
            $data['featured'][] = [
                'title' => $result['title'],
                'image' => $this->resize($result['image'], 374, 460),
                'body'  => word_limiter($result['body'], 20),
                'href'  => ($keyword) ? route_to('blog/post', $keyword) : base_url('extension/blog/blog/view?post_id=' . $result['post_id']),
                'date_added' => $this->dateDifference($result['date_added']),
            ];
        }

        $data['trending'] = [];
        $trending = $blogMdel->getTrendingPosts(3);
        foreach ($trending as $result) {
            $keyword = $seo_url->getKeywordByQuery('post_id=' . $result['post_id']);
            $data['trending'][] = [
                'title' => $result['title'],
                'image' => $this->resize($result['image'], 358, 142),
                'body'  => word_limiter($result['body'], 10),
                'href'  => ($keyword) ? route_to('blog/post', $keyword) : base_url('extension/blog/blog/view?post_id=' . $result['post_id']),
                'date_added' => $this->dateDifference($result['date_added']),
            ];
        }

        $data['heading_title'] = lang('extension/blog/blog.heading_title');
        $data['text_featured'] = lang('extension/blog/blog.text_featured');
        $data['text_recent']   = lang('extension/blog/blog.text_recent');
        $data['text_trending'] = lang('extension/blog/blog.text_trending');
        $data['text_social']   = lang('extension/blog/blog.text_social');

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        $this->template->output('extension/blog/blog', $data);
    }


    public function getPost()
    {
        if ($this->request->getGet('post_id')) {
            $post_id = $this->request->getGet('post_id');
        } elseif($this->request->getVar('post_id')) {
            $post_id = $this->request->getVar('post_id');
        } else {
            $post_id = 0;
        }

        $blogMdel = new BlogModel();
        $post_info = $blogMdel->getPost($post_id);
        $seo_url = service('seo_url');

        // Breadcrumbs
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang('en.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('extension/blog/blog.heading_title'),
            'href' => route_to('blog'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $post_info['title'],
            'href' => route_to('blog/post', $post_id),
        ];

        if ($post_info) {
            $data['title']      = $post_info['title'];
            $data['category']   = $post_info['category'];
            $data['body']       = $post_info['body'];
            $data['date_added'] = $post_info['date_added'];
            $data['image']      = ($post_info['image']) ? $this->resize($post_info['image'], 777, 380) : $this->resize('catalog/no_image.jpg', 777, 380);
            $data['post_id']    = $post_info['post_id'];
        } else {
            $data['title']      = '';
            $data['category']   = '';
            $data['body']       = '';
            $data['image']      = '';
            $data['date_added'] = '';
        }

        $data['heading_title']    = lang('extension/blog/blog.heading_title');
        $data['text_post']        = lang('extension/blog/blog.text_post');
        $data['text_comments']    = sprintf(lang('extension/blog/blog.text_comments'), $blogMdel->getTotalCommentsByPostId($post_id));
        $data['text_add_comment'] = lang('extension/blog/blog.text_add_comment');
        $data['entry_email']      = lang('extension/blog/blog.entry_email');
        $data['entry_name']       = lang('extension/blog/blog.entry_name');
        $data['text_trending']    = lang('extension/blog/blog.text_trending');
        $data['text_social']      = lang('extension/blog/blog.text_social');
        $data['button_add']      = lang('extension/blog/blog.button_add');

        $data['post_comments'] = [];
        $results = $blogMdel->getCommentsByPostId($post_id, 5);
        foreach ($results as $result) {
            $data['post_comments'][] = [
                'name'       => $result['name'],
                'date_added' => $this->dateDifference($result['date_added']),
                'text'       => $result['comment'],
            ];
        }

        $data['trending'] = [];
        $trending = $blogMdel->getTrendingPosts(3);
        foreach ($trending as $result) {
            $keyword = $seo_url->getKeywordByQuery('post_id=' . $result['post_id']);
            $data['trending'][] = [
                'title'      => $result['title'],
                'image' => $this->resize($result['image'], 358, 142),
                'href'  => ($keyword) ? route_to('blog/post', $keyword) : base_url('extension/blog/blog/view?post_id=' . $result['post_id']),
                'date_added' => $this->dateDifference($result['date_added']),
            ];
        }
        $this->template->output('extension/blog/post', $data);
    }

    public function addComment()
    {
        $json = [];
        if (!$json) {
            if ($this->request->getMethod() == 'post') {
                $blogMdel = new BlogModel();
                $blogMdel->insertComment($this->request->getPost());
                $json['success'] = lang('extension/blog/blog.text_comment_success');
            }
        }

        return $this->response->setJSON($json);
    }
    // --------------------------------------------------------------
}
