<?php namespace Admin\Models\Customer;

use CodeIgniter\Model;

class CustomerGroupModel extends Model
{
    protected $table          = 'customer_group';
    protected $primaryKey     = 'customer_group_id';
    protected $returnType     = 'array';
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
        if (isset($data['data'])) {
            $data['id'] = [
                'key'   => 'customer_group_id',
                'value' => $data['id'][0]
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'customer_group_add', $data['id'], $data['data']);
        }
        return $data;
    }

    protected function afterUpdateEvent(array $data)
    {
        if (isset($data['data'])) {
            $data['id'] = [
                'key'   => 'customer_group_id',
                'value' => $data['id'][0]
            ];

            \CodeIgniter\Events\Events::trigger('user_activity_add', 'customer_group_edit', $data['id'], $data['data']);
        }
        return $data;
    }


    public function addCustomerGroup(array $data)
    {
        $builder = $this->db->table('customer_group');
        $builder->set('sort_order', $data['sort_order']);
        $builder->insert();

        $customer_group_id = $this->db->insertID();

        $description = $this->db->table('customer_group_description');
        foreach ($data['customer_group_description'] as $language_id => $value) {
            $customer_group_description_data = [
                'customer_group_id'  => $customer_group_id,
                'language_id'        => $language_id,
                'name'               => $value['name'],
                'description'        => $value['description'],
            ];
            $description->insert($customer_group_description_data);
        }
        // Event Call 
        $eventData = [
            'id' => [
                '0' => $customer_group_id
            ],
            'data' => [
                'name' => $value['name']
            ]
        ];
        $this->afterInsertEvent($eventData);

        return $customer_group_id;
    }

    public function editCustomerGroup(int $customer_group_id, array $data)
    {
        $builder = $this->db->table('customer_group');
        $builder->set('sort_order', $data['sort_order']);
        $builder->where('customer_group_id', $customer_group_id);
        $builder->update();

        $description = $this->db->table('customer_group_description');
        $description->delete(['customer_group_id' => $customer_group_id]);

        foreach ($data['customer_group_description'] as $language_id => $value) {
            $customer_group_description_data = [
                'customer_group_id'  => $customer_group_id,
                'language_id'        => $language_id,
                'name'               => $value['name'],
                'description'        => $value['description'],
            ];
            $description->insert($customer_group_description_data);
        }
        // Event Call 
        $eventData = [
            'id' => [
                '0' => $customer_group_id
            ],
            'data' => [
                'name' => $value['name']
            ]
        ];
        $this->afterUpdateEvent($eventData);

    }

    public function deleteCustomerGroup($customer_group_id)
    {
        $customer_group = $this->db->table('customer_group');
        $customer_group->delete(['customer_group_id' => $customer_group_id]);
        $customer_group_description = $this->db->table('customer_group_description');
        $customer_group_description->delete(['customer_group_id' => $customer_group_id]);
    }

    public function getCustomerGroups(array $data = [])
    {
        $builder = $this->db->table('customer_group cg');
        $builder->select();
        $builder->join('customer_group_description cgd', 'cg.customer_group_id = cgd.customer_group_id', 'left');
        $builder->where('cgd.language_id', \Admin\Libraries\Registry::get('config_language_id'));

        // if (!empty($data['filter_name'])) {
        //     $builder->like('cd.name', $data['filter_name'], 'both');
        // }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('cg.sort_order', 'DESC');
        } else {
            $builder->orderBy('cg.sort_order', 'ASC');
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

    public function getCustomerGroup(int $customer_group_id)
    {
        $builder = $this->db->table('customer_group cg');
        $builder->select();
        $builder->join('customer_group_description cgd', 'cgd.customer_group_id = cg.customer_group_id', 'left');
        $builder->where('cg.customer_group_id', $customer_group_id);
        $builder->where('cgd.language_id', \Admin\Libraries\Registry::get('config_language_id'));
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getCustomerGroupDescriptions(int $customer_group_id)
    {
        $customer_group_data = [];
        
        $builder = $this->db->table('customer_group_description');
        $builder->select();
        $builder->where('customer_group_id', $customer_group_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $customer_group_data[$result['language_id']] = [
                'name'        => $result['name'],
                'description' => $result['description']
            ];
        }

        return $customer_group_data;
    }


    // -----------------------------------------------------------------
}
