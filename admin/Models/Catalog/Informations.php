<?php namespace Admin\Models\Catalog;

class Informations extends \CodeIgniter\Model
{
    protected $table          = 'information';
    protected $primaryKey     = 'information_id';
    protected $returnType     = 'array';
    protected $allowedFields  = ['firstname', 'lastname', 'email', 'password', 'status', 'user_group_id'];
    protected $useTimestamps  = true;
    protected $useSoftDeletes = false;
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


    public function getInformations(array $data = [])
    {
        $builder = $this->db->table('information');
        $builder->select();
        $builder->join('information_description', 'information.information_id = information_description.information_id', 'left');
        $builder->where('information_description.language_id', (int) \Admin\Libraries\Registry::get('config_language_id'));
        
        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('information_description.title', 'DESC');
        } else {
            $builder->orderBy('information_description.title', 'ASC');
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $builder->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getInformation($information_id)
    {
        $builder = $this->db->table('information i');

        $builder->select();
        $builder->join('information_description id', 'i.information_id = id.information_id', 'LEFT');
        $builder->where('i.information_id', (int) $information_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getInformationDescription($information_id)
    {
        $builder = $this->db->table('information_description');

        $information_description_data = [];
        
        $builder->select();
        $builder->where('information_id', $information_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $information_description_data[$result['language_id']] = [
                'title'            => $result['title'],
                'description'      => $result['description'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
            ];
        }
        return $information_description_data;
    }
    
    public function addInformation($data)
    {
        $builder = $this->db->table($this->table);
        $information_data = [
            'sort_order' => $data['sort_order'],
            'status'     => $data['status'],
        ];

        $builder->set('date_added', 'NOW()', false);
        $builder->set('date_modified', 'NOW()', false);
        $builder->insert($information_data);
        // Get Last Inserted ID
        $information_id = $this->db->insertID();
        // information_description Query
        if (isset($data['information_description'])) {
            $information_description_table = $this->db->table('information_description');
            foreach ($data['information_description'] as $language_id => $information_description) {
                $information_description_data = [
                    'information_id'   => $information_id,
                    'language_id'      => $language_id,
                    'title'            => $information_description['title'],
                    'description'      => $information_description['description'],
                    'meta_title'       => $information_description['meta_title'],
                    'meta_description' => $information_description['meta_description'],
                    'meta_keyword'     => $information_description['meta_keyword'],
                ];

                $information_description_table->insert($information_description_data);
                //  Seo Urls
                $seo_url = $this->db->table('seo_url');
                $seo_url_data = [
                        'site_id'     => 0,
                        'language_id' => $language_id,
                        'query'       => 'information_id=' . $information_id,
                        'keyword'     => generateSeoUrl($information_description['title']),
                    ];
                $seo_url->insert($seo_url_data);
            }
        }
    }
    
    public function editInformation($information_id, $data)
    {
        $builder = $this->db->table($this->table);
        $information_data = [
            'sort_order' => $data['sort_order'],
            'status'     => $data['status'],
        ];
        
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('information_id', $information_id);
        $builder->update($information_data);

        // information_description Query
        if (isset($data['information_description'])) {
            $information_description_table = $this->db->table('information_description');
            $information_description_table->delete(['information_id' => $information_id]);
            foreach ($data['information_description'] as $language_id => $information_description) {
                $information_description_data = [
                    'information_id'   => $information_id,
                    'language_id'      => $language_id,
                    'title'            => $information_description['title'],
                    'slug'             => generateSeoUrl($information_description['title']),
                    'description'      => $information_description['description'],
                    'meta_title'       => $information_description['meta_title'],
                    'meta_description' => $information_description['meta_description'],
                    'meta_keyword'     => $information_description['meta_keyword'],
                ];
                $information_description_table->insert($information_description_data);
                //  Seo Urls
                $seo_url = $this->db->table('seo_url');
                $seo_url->delete(['information_id' => $information_id]);
                $seo_url_data = [
                        'site_id'     => 0,
                        'language_id' => $language_id,
                        'query'       => 'information_id=' . $information_id,
                        'keyword'     => generateSeoUrl($information_description['title']),
                    ];
                $seo_url->insert($seo_url_data);
            }
        }
    }

    public function deleteInformation($information_id)
    {
        $builder = $this->db->table($this->table);
        $builder->delete(['information_id' => $information_id]);
        //  information_description
        $builderDescription = $this->db->table('information_description');
        $builderDescription->delete(['information_id' => $information_id]);
        //  seo_url
        $builderDescription = $this->db->table('seo_url');
        $builderDescription->delete(['query' => 'information_id=' . $information_id]);
    }

    // -----------------------------------------------------------------
}
