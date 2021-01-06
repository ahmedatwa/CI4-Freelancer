<?php namespace Extensions\Models\Blog;

class BlogModel extends \CodeIgniter\Model
{
    protected $table          = 'blog_post';
    protected $primaryKey     = 'post_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['user_id', 'title', 'slug', 'body', 'image', 'status', 'published_at'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
    // Password Hashing Events
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    protected function afterInsertEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_add', $this->db->insertID(), $data['data']['name']);
        }
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data']['firstname'])) {
            $data['data']['name'] = $data['data']['firstname'] . ' ' . $data['data']['lastname'];
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        } else {
            \CodeIgniter\Events\Events::trigger('user_activity_update', $data['id'], $data['data']['name']);
        }
    }

    public function getTags()
    {
        $builder = $this->db->Table('blog_tags');
        $builder->select();
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function addPost($data)
    {
        $builder = $this->db->Table($this->table);
        $data = [
            'user_id'     => $data['user_id'],
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'body'        => $data['body'],
            'tags'        => $data['tags'],
            'image'       => $data['image'],
            'status'      => $data['status'],
            'featured'    => $data['featured'],
            'trending'    => $data['trending'],
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($data);

        $post_id = $this->db->insertID();

        // SEO URLS
        $seo_url = $this->db->table('seo_url');
        $seo_url_data = [
            'site_id'     => 0,
            'language_id' => 1,
            'query'       => 'post_id=' . $post_id,
            'keyword'     => generateSeoUrl($data['title']),
        ];
        $seo_url->insert($seo_url_data);
    }

    public function editPost($post_id, $data)
    {
        $builder = $this->db->Table($this->table);
        $data = [
            'user_id'     => $data['user_id'],
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'body'        => $data['body'],
            'tags'        => $data['tags'],
            'image'       => $data['image'],
            'status'      => $data['status'],
            'featured'    => $data['featured'],
            'trending'    => $data['trending'],
        ];
        // SEO URLS
        $seo_url = $this->db->table('seo_url');
        $seo_url_data = [
            'site_id'     => 0,
            'language_id' => 1,
            'query'       => 'post_id=' . $post_id,
            'keyword'     => generateSeoUrl($data['title']),
        ];
        $seo_url->insert($seo_url_data);

        $builder->where('post_id', $post_id);
        $builder->set('date_modified', 'NOW()', false);
        $builder->update($data);
    }

    // Categories
    public function getCategories()
    {
        $builder = $this->db->table('blog_category');
        $builder->select();
        $builder->where('status', 1);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getCategory($category_id)
    {
        $builder = $this->db->table('blog_category');
        $builder->select();
        $builder->where(['status' => 1, 'category_id' => $category_id]);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addCategory($data)
    {
        $builder = $this->db->Table('blog_category');
        $data = [
            'name'        => $data['name'],
            'status'      => 1,
    ];
        $builder->insert($data);
    }

    public function editCategory($category_id, $data)
    {
        $builder = $this->db->Table('blog_category');
        $data = [
            'name'        => $data['name'],
            'status'      => 1,
    ];
        $builder->where('category_id', $category_id);
        $builder->update($data);
    }

    public function deleteCategory($category_id)
    {
        $builder = $this->db->Table('blog_category');
        $builder->delete(['category_id' => $category_id]);
    }

    // Comments
    public function getComments()
    {
        $builder = $this->db->Table('blog_post_to_comment');
        $builder->select();
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getComment($comment_id)
    {
        $builder = $this->db->table('blog_post_to_comment');
        $builder->select();
        $builder->where('comment_id', $comment_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function editComment($comment_id, $data)
    {
        $builder = $this->db->Table('blog_post_to_comment');
        $builder->set('status', 1);
        $builder->where('comment_id', $comment_id);
        $builder->update();
    }

    public function install()
    {
        $forge = \Config\Database::forge();

        $blog_post = [
        'post_id' => [
                'type'  => 'INT',
                'constraint'     => '11',
                'auto_increment' => true
        ],
        'user_id' => [
                'type' => 'INT',
                'constraint' => '11',
        ],
        'category_id' => [
                'type' =>'INT',
                'constraint' => 11,
        ],
        'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
        ],
        'body' => [
                'type' => 'TEXT',
        ],
        'tags' => [
                'type'  => 'TEXT',
        ],
        'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
        ],
        'featured' => [
                'type' => 'TINYINT',
                'constraint' => 1,
        ],
        'trending' => [
                'type' => 'TINYINT',
                'constraint' => 1,
        ],
        'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
        ],
        'date_added' => [
                'type' => 'DATETIME',
        ],
        'date_modified' => [
                'type' => 'DATETIME',
        ],
      ];

        $forge->addField($blog_post);
        $forge->addPrimaryKey('post_id');
        $forge->createTable('blog_post', true);

        $blog_category = [
        'category_id' => [
                'type'  => 'INT',
                'constraint'     => '11',
                'auto_increment' => true
        ],
        'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
        ],
        'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
        ],
      ];

        $forge->addField($blog_category);
        $forge->addPrimaryKey('category_id');
        $forge->createTable('blog_category', true);

        $blog_post_to_commet = [
        'comment_id' => [
                'type'  => 'INT',
                'constraint'     => '11',
                'auto_increment' => true
        ],
        'post_id' => [
                'type' => 'INT',
                'constraint' => '11',
        ],
        'name' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
        ],
        'email' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
        ],
        'website' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
        ],
        'comment' => [
                'type' => 'TEXT',
        ],
        'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
        ],
        'date_added' => [
                'type' => 'DATETIME',
        ],
      ];

        $forge->addField($blog_post_to_commet);
        $forge->addPrimaryKey('comment_id');
        $forge->createTable('blog_post_to_commet', true);
    }

    public function uninstall()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('blog_post', true);
        $forge->dropTable('blog_post_to_commet', true);
        $forge->dropTable('blog_category', true);
    }

    // -----------------------------------------------------------------
}
