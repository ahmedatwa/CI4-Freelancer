<?php namespace Extensions\Models\Wallet;

class WalletModel extends \CodeIgniter\Model
{
    protected $table          = 'customer_to_balance';
    protected $primaryKey     = 'balance_id';
    protected $returnType     = 'array';
    // User Activity Events
    protected $afterInsert = ['afterInsertEvent'];
    protected $afterUpdate = ['afterUpdateEvent'];
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';
    protected $deletedField = 'date_deleted';

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

    public function getCustomerWallet(array $data =[])
    {
        $builder = $this->db->table('wallet w');
        $builder->select('CONCAT(c.firstname, " ", c.lastname) AS customer, w.total, w.status');
        $builder->join('customer c', 'w.customer_id = c.customer_id', 'left');
        
        if (isset($data['customer_id'])) {
            $builder->where('c.customer_id', $data['customer_id']);
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('w.total', 'DESC');
        } else {
            $builder->orderBy('w.total', 'ASC');
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

    // public function install()
    // {
    //     $forge = \Config\Database::forge();

    //     $fields = [
    //     'bid_id' => [
    //             'type'  => 'INT',
    //             'constraint'     => '11',
    //             'auto_increment' => true
    //     ],
    //     'project_id' => [
    //             'type' => 'INT',
    //             'constraint' => '11',
    //     ],
    //     'freelancer_id' => [
    //             'type' =>'INT',
    //             'constraint' => 11,
    //     ],
    //     'quote' => [
    //             'type' => 'TEXT',
    //             'null' => true,
    //     ],
    //     'text' => [
    //             'type' => 'TEXT',
    //             'null' => true,
    //     ],
    //     'status' => [
    //             'type' => 'TINYINT',
    //             'constraint' => 1,
    //     ],
    //     'date_start' => [
    //             'type'  => 'DATETIME',
    //     ],
    //     'date_end' => [
    //             'type' => 'DATETIME',
    //     ],
    //   ];

    //   $forge->addField($fields);
    //   $forge->addPrimaryKey('bid_id');
    //   $forge->createTable('bids', true);
    // }

    // public function uninstall()
    // {
    //     $forge = \Config\Database::forge();
    //     $forge->dropTable('bids',true);

    // }


    // -----------------------------------------------------------------
}
