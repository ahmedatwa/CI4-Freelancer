<?php 

namespace Catalog\Models\Freelancer;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class DisputeModel extends Model
{
    protected $table         = 'dispute';
    protected $primaryKey    = 'dispute_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['project_id', 'freelancer_id', 'employer_id', 'created_by', 'comment', 'dispute_status_id', 'dispute_reason_id'];
    // should use for keep data record create timestamp
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    public function getDisputeReasons()
    {
        $builder = $this->db->table('dispute_reason');
        $builder->select();
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function inDispute(int $project_id)
    {
      $builder = $this->db->table($this->table);  
      $builder->where('project_id', $project_id);
      if ($builder->countAllResults() > 0 ) {
          return true;
      } else {
        return false;
      }
    }

    public function getDisputeAction($dispute_action_id)
    {
        $builder = $this->db->table('dispute_action');
        $builder->select('name');
        $builder->where('dispute_action_id', $dispute_action_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getDisputes(array $data = [])
    {
        $builder = $this->db->table('dispute d');
        $builder->select('*, ds.name as status');
        $builder->join('dispute_status ds', 'd.dispute_status_id = d.dispute_status_id', 'left');
        $builder->groupBy('d.dispute_status_id');

        if (isset($data['created_by']) && !empty($data['created_by'])) {
            $builder->where('created_by', $data['created_by']);
        }

        if (isset($data['freelancer_id']) && !empty($data['freelancer_id'])) {
            $builder->where('freelancer_id', $data['freelancer_id']);
        }

        if (isset($data['employer_id']) && !empty($data['employer_id'])) {
            $builder->where('employer_id', $data['employer_id']);
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
        }

        $sortData = [
            'd.date_added',
        ];

        if (isset($data['sort_by']) && in_array('p.' . $data['sort_by'], $sortData)) {
            $builder->orderBy($data['sort_by'], $data['order_by']);
        } else {
            $builder->orderBy('d.date_added', 'DESC');
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

    public function getTotalDisputes(array $data = [])
    {
        $builder = $this->db->table('dispute d');
        $builder->select('*, ds.name as status');
        $builder->join('dispute_status ds', 'd.dispute_status_id = d.dispute_status_id', 'left');
        $builder->groupBy('d.dispute_status_id');

        if (isset($data['created_by'])) {
            $builder->where('created_by', $data['created_by']);
        }

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
        }

        $sortData = [
            'd.date_added',
        ];

        if (isset($data['sort_by']) && in_array('p.' . $data['sort_by'], $sortData)) {
            $builder->orderBy($data['sort_by'], $data['order_by']);
        } else {
            $builder->orderBy('d.date_added', 'DESC');
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
        return $builder->countallResults();  
    }
    // -----------------------------------------------------------------
}
