<?php namespace Extensions\Models\Bid;

class BidModel extends \CodeIgniter\Model
{
    protected $table          = 'project_bids';
    protected $primaryKey     = 'bid_id';
    protected $returnType     = 'array';
    // should use for keep data record create timestamp
    protected $createdField = 'date_added';
    protected $updatedField = 'date_modified';

    public function getBids(array $data =[])
    {
        $builder = $this->db->table('project_bids pb');
        $builder->select('CONCAT(c.firstname, " ", c.lastname) AS freelancer, pb.quote, pb.date_added, pb.bid_id, pb.status, pd.name, pb.delivery');
        $builder->join('customer c', 'pb.freelancer_id = c.customer_id', 'left');
        $builder->join('project_description pd', 'pb.project_id = pd.project_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));
       
        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $builder->orderBy('pb.date_added', 'DESC');
        } else {
            $builder->orderBy('pb.date_added', 'ASC');
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

    public function install()
    {
        $forge = \Config\Database::forge();

        $fields = [
        'bid_id' => [
                'type'  => 'INT',
                'constraint'     => '11',
                'auto_increment' => true
        ],
        'project_id' => [
                'type' => 'INT',
                'constraint' => '11',
        ],
        'freelancer_id' => [
                'type' =>'INT',
                'constraint' => 11,
        ],
        'quote' => [
                'type' => 'DECIMAL',
                'constraint' => 15,4,
        ],
        'delivery' => [
                'type' => 'TINYINT',
                'constraint' => 1,
        ],
        'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
        ],
        'date_added' => [
                'type'  => 'DATETIME',
        ],
      ];

        $forge->addField($fields);
        $forge->addPrimaryKey('bid_id');
        $forge->createTable('project_bids', true);
    }

    public function uninstall()
    {
        $forge = \Config\Database::forge();
        $forge->dropTable('project_bids', true);
    }


    // -----------------------------------------------------------------
}
