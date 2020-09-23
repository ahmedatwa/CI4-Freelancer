<?php namespace Catalog\Models\Extension\blog;

class BlogModel extends \CodeIgniter\Model
{
    protected $table          = 'blog_post';
    protected $primaryKey     = 'post_id';

    // Categories
    public function getCategories()
    {
        $builder = $this->db->table('blog_category');
        $builder->select();
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getPosts(array $data = [])
    {
        $builder = $this->db->table('blog_post');
        $builder->select('*, blog_category.name AS category');
        $builder->join('blog_category', 'blog_category.category_id = blog_post.category_id', 'left');

        if (isset($data['post_id'])) {
            $builder->where('post_id', $data['post_id']);
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('blog_post.title', 'DESC');
        } else {
            $builder->orderBy('blog_post.title', 'ASC');
        }

        if (isset($data['start']) && isset($data['limit'])) {
             if ($data['start'] < 0 ) {
                 $data['start'] = 0;
             }
             if ($data['limit'] < 1 ) {
                 $data['start'] = 20;
             }

            $builder->limit($data['limit'], $data['start']);
        }
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getPost($post_id)
    {
        $builder = $this->db->table('blog_post');
        $builder->select('*, blog_category.name AS category');
        $builder->join('blog_category', 'blog_category.category_id = blog_post.category_id', 'left');
        $builder->where('blog_post.post_id', $post_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getFeaturedPosts(int $limit,  int $start = 0)
    {
        $builder = $this->db->table('blog_post');
        $builder->select('*, blog_category.name AS category');
        $builder->join('blog_category', 'blog_category.category_id = blog_post.category_id', 'left');
        $builder->where('featured', 1);
        $builder->orderBy('blog_post.title', 'DESC');
        $builder->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }
    public function getTrendingPosts(int $limit, int $start = 0)
    {
        $builder = $this->db->table('blog_post');
        $builder->select('*, blog_category.name AS category');
        $builder->join('blog_category', 'blog_category.category_id = blog_post.category_id', 'left');
        $builder->where('trending', 1);
        $builder->orderBy('blog_post.title', 'DESC');
        $builder->limit($limit, $start);
        $query = $builder->get();
        return $query->getResultArray();
    }
    // ----------------------------------------------------
}
