<?php namespace Catalog\Controllers\Extension\Blog;

use \Catalog\Models\Extension\Blog\BlogModel;

class Blog extends \Catalog\Controllers\BaseController
{
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

        $filter_data = [
            'start'   => 0,
            'limit'   => 20
        ];

        $data['posts'] = [];

        $blogMdel = new BlogModel();
        $results = $blogMdel->getPosts($filter_data);

        helper('text');

        foreach ($results as $result) {
            $data['posts'][] = [
                'title' => $result['title'],
                'image' => $result['image'],
                'body'  => word_limiter($result['body'], 80),
                'href'  => route_to('blog/post', getKeywordByQuery('post_id=' . $result['post_id'])),
                'date_added' => $this->dateDifference($result['date_added']),
            ];
        }

        $data['featured'] = [];
        $featured = $blogMdel->getFeaturedPosts(10);
        foreach ($featured as $result) {
            $data['featured'][] = [
                'title' => $result['title'],
                'image' => $result['image'],
                'body'  => word_limiter($result['body'], 20),
                'href'  => route_to('blog/post', getKeywordByQuery('post_id=' . $result['post_id'])),
                'date_added' => $this->dateDifference($result['date_added']),
            ];
        }

        $data['trending'] = [];
        $trending = $blogMdel->getTrendingPosts(3);
        foreach ($trending as $result) {
            $data['trending'][] = [
                'title' => $result['title'],
                'image' => $result['image'],
                'body'  => word_limiter($result['body'], 10),
                'href'  => route_to('blog/post', getKeywordByQuery('post_id=' . $result['post_id'])),
                'date_added' => $this->dateDifference($result['date_added']),
            ];
        }

        $data['heading_title'] = lang('extension/blog/blog.heading_title');
        $data['text_featured'] = lang('extension/blog/blog.text_featured');
        $data['text_recent'] = lang('extension/blog/blog.text_recent');
        $data['text_trending'] = lang('extension/blog/blog.text_trending');
        $data[''] = lang('extension/blog/blog.heading_title');
        $data[''] = lang('extension/blog/blog.heading_title');

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

        $blogMdel = new BlogModel();
        $post_info = $blogMdel->getPost($post_id);

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
