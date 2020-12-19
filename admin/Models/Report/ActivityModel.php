<?php namespace Admin\Models\Report;

use CodeIgniter\Model;

class ActivityModel extends Model
{


    public function getActivities($data = array())
    {
        $builder = $this->db->table($this->db->prefixTable('user_activity'));

        $builder->select();
        //$builder->join($this->db->dbprefix . 'vendors v', 'va.user_id = v.user_id', 'LEFT');

        // if (!empty($this->input->get("filter_name"))) {
        //     $this->db->like('CONCAT(v.firstname," ",v.lastname)', $this->input->get("filter_name"), 'adter');
        // }

        // if (!empty($this->input->get("filter_date_added"))) {
        //     $this->db->like('va.date_added', $this->input->get("filter_date_added"), 'after');
        // }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $this->db->limit($data['limit'], $data['start']);
        }

        $query = $builder->get();

        return $query->getResultArray();
    }

    public function addActivity($key, $data)
    {
        $request = \Config\Services::request();

        $activity_data = array(
            'user_id'    => $data['user_id'],
            'key'        => $key,
            'data'       => json_encode($data),
            'ip'         => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent(),
        );

        $builder = $this->db->table($this->db->prefixTable('user_activity'));
        $builder->set('date_added', 'NOW()', false);
        $builder->insert($activity_data);
    }

    public function deleteActivity($activity_id)
    {
        $this->db->where('activity_id', $activity_id);
        $this->db->delete($this->db->dbprefix . 'vendors_activity');
    }

    public function getTotalActivities()
    {
        $builder = $this->db->table($this->db->prefixTable('user_activity'));

        return $builder->countAllResults();
    }

} // END OF Activities Model FILE
