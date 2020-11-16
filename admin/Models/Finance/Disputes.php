<?php namespace Admin\Models\Finance;

use CodeIgniter\Model;

class Disputes extends Model
{
    protected $table      = 'dispute';
    protected $primaryKey = 'dispute_id';
    protected $returnType = 'array';

    protected $allowedFields = ['dispute_id', 'project_id', 'freelancer_id', 'employer_id', 'comment', 'dispute_status_id', 'dispute_reason_id', 'dispute_action_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    public function getDisputes()
    {
        $builder = $this->db->table('dispute d');
        $builder->select('*, ds.name as status');
        $builder->join('dispute_status ds', 'd.dispute_status_id = d.dispute_status_id', 'left');
        $builder->groupBy('d.dispute_status_id');
        $query = $builder->get();
        return $query->getResultArray();
    }
    // status
    public function getDisputeStatuses()
    {
        $builder = $this->db->table('dispute_status');
        $builder->select();
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDisputeStatusName($dispute_status_id)
    {
      $builder = $this->db->table('dispute_status');
      $builder->select('name');
      $builder->where('dispute_status_id', $dispute_status_id);
      $row = $builder->get()
                     ->getRow();
      return $row->name;
    }

    public function getDisputeStatus()
    {
        $builder = $this->db->table('dispute_status');
        $builder->select();
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addDisputeStatus($data)
    {
        $builder = $this->db->table('dispute_status');
        $rowData = [
        'name' => $data['name'],
        'language_id' => 1,
    ];
        $builder->insert($rowData);
    }

    public function editDisputeStatus($dispute_status_id, $data)
    {
        $builder = $this->db->table('dispute_status');
        $builder->where('dispute_status_id', $dispute_status_id);
        $rowData = [
        'name' => $data['name'],
        'language_id' => 1,
    ];
        $builder->update($rowData);
    }

    public function deleteDisputeStatus($dispute_status_id)
    {
        $builder = $this->db->table('dispute_status');
        $builder->delete(['dispute_status_id' => $dispute_status_id]);
    }


    // reason
    public function getDisputeReasons()
    {
        $builder = $this->db->table('dispute_reason');
        $builder->select();
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDisputeReason()
    {
        $builder = $this->db->table('dispute_reason');
        $builder->select();
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addDisputeReason($data)
    {
        $builder = $this->db->table('dispute_reason');
        $rowData = [
        'name' => $data['name'],
        'language_id' => 1,
    ];
        $builder->insert($rowData);
    }

    public function editDisputeReason($dispute_reason_id, $data)
    {
        $builder = $this->db->table('dispute_reason');
        $builder->where('dispute_reason_id', $dispute_reason_id);
        $rowData = [
        'name' => $data['name'],
        'language_id' => 1,
    ];
        $builder->update($rowData);
    }

    public function deleteDisputeReason($dispute_reason_id)
    {
        $builder = $this->db->table('dispute_reason');
        $builder->delete(['dispute_reason_id' => $dispute_reason_id]);
    }

    
    // action
    public function getDisputeActions()
    {
        $builder = $this->db->table('dispute_action');
        $builder->select();
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDisputeAction()
    {
        $builder = $this->db->table('dispute_action');
        $builder->select();
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function addDisputeAction($data)
    {
        $builder = $this->db->table('dispute_action');
        $rowData = [
        'name' => $data['name'],
        'language_id' => 1,
    ];
        $builder->insert($rowData);
    }

    public function editDisputeAction($dispute_action_id, $data)
    {
        $builder = $this->db->table('dispute_action');
        $builder->where('dispute_action_id', $dispute_action_id);
        $rowData = [
        'name' => $data['name'],
        'language_id' => 1,
    ];
        $builder->update($rowData);
    }

    // delete
    public function deleteDisputeAction($dispute_action_id)
    {
        $builder = $this->db->table('dispute_action');
        $builder->delete(['dispute_action_id' => $dispute_action_id]);
    }

    // History
    public function getDisputeHistories($dispute_id)
    {
        $builder = $this->db->table('dispute_history dh');
        $builder->select('dh.date_added, ds.name AS status, dh.comment, dh.notify');
        $builder->join('dispute_status ds', 'dh.dispute_status_id = ds.dispute_status_id', 'left');
        $builder->where([
      'dispute_id'      => $dispute_id,
    ]);
        $builder->orderBy('dh.date_added', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function addDisputeHistory($dispute_id, $dispute_status_id, $comment, $notify)
    {
        $builder = $this->db->table('dispute');
        $builder->set('dispute_status_id', $dispute_status_id);
        $builder->set('date_modified', 'NOW()', false);
        $builder->where('dispute_id', $dispute_id);
        $builder->update();

        $history = $this->db->table('dispute_history');
        $history->set('dispute_id', $dispute_id);
        $history->set('dispute_status_id', $dispute_status_id);
        $history->set('notify', $notify);
        $history->set('comment', $comment);
        $history->set('date_added', 'NOW()', false);
        $history->insert();

        if ($notify) {
            \CodeIgniter\Events\Events::trigger('customer_dispute_notify', $dispute_status_id, $dispute_id, $notify);
        }
    }

   
   
    // -----------------------------------------------------------------
}
