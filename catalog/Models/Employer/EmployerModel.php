<?php 

namespace Catalog\Models\Employer;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class EmployerModel extends Model
{
    protected $table         = 'project';
    protected $primaryKey    = 'project_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['status_id', 'employer_review_id', 'freelancer_review_id'];
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    public function getEmployerProjects(array $data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.type, p.status_id, p.runtime');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('customer c', 'p.employer_id = c.customer_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));

        if (isset($data['employer_id'])) {
            $builder->where('p.employer_id', $data['employer_id']);
        }

        if (isset($data['status_id'])) {
            $builder->whereIn('p.status_id', explode('_', $data['status_id']));
        }

        if (isset($data['order']) && $data['order'] == 'DESC') {
            $orderBy = 'DESC';
        } else {
            $orderBy = 'ASC';
        }

        $sortData = [
            'p.date_added',
            'pd.name',
            'p.type',
        ];

        if (isset($data['sort']) && in_array($data['sort'], $sortData)) {
            $builder->orderBy($data['sort'], $orderBy);
        } else {
            $builder->orderBy('p.date_added', 'ASC');
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

    public function getTotalEmployerProjects(array $data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.type, p.status, p.runtime');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('customer c', 'p.employer_id = c.customer_id', 'left');
        $builder->where('pd.language_id', service('registry')->get('config_language_id'));

        if (isset($data['employer_id'])) {
            $builder->where('p.employer_id', $data['employer_id']);
        }

        if (isset($data['status_id'])) {
            $builder->whereIn('p.status_id', explode('_', $data['status_id']));
        }

        if (isset($data['orderBy']) && $data['orderBy'] == 'DESC') {
            $data['orderBy'] = 'DESC';
        } else {
            $data['orderBy'] = 'ASC';
        }

        $sortData = ['p.date_added'];

        if (isset($data['sortBy']) && in_array($data['sortBy'], $sortData)) {
            $builder->orderBy($data['sortBy'], 'DESC');
        } else {
            $builder->orderBy('p.date_added', 'ASC');
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

        return $builder->countAllResults();

    }

    public function getEmployerAvgBidsByProjectId(int $project_id)
    {
        $builder = $this->db->table('project_bids');
        $builder->selectAvg('quote', 'total');
        $builder->where('project_id', $project_id);
        $query = $builder->get()->getRowArray();
        return round($query['total']);
    }

    public function getProjectStatusByProjectId(int $project_id)
    {
        $builder = $this->db->table('project p');
        $builder->select('ps.name');
        $builder->join('project_status ps', 'p.status_id = ps.status_id', 'left');
        $builder->where('p.project_id', $project_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        return $row['name'];
    }

    public function addWinner($data)
    {
        $builder = $this->db->table('project_bids');
        $builder->where([
            'freelancer_id' =>  $data['freelancer_id'],
            'project_id'    =>  $data['project_id'],
            'bid_id'        =>  $data['bid_id'],
            'date_modified' => Time::now()->getTimestamp()
        ]);
        $builder->set('selected', 1)->update();
        // Update Project Status
        $projects = $this->db->table('project');
        $projects->where('project_id', $data['project_id']);
        $projects->set('status_id', 6);
        $projects->update();

        // trigget new offer for freelancer
        \CodeIgniter\Events\Events::trigger('project_offer_selected', $data);
    }

    public function getEmployerProject(int $project_id)
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.type, p.runtime, p.date_added, p.employer_id, p.budget_min, p.budget_max, c.username as employer');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('project_status ps', 'p.status_id = ps.status_id', 'left');
        $builder->join('customer c', 'p.employer_id = c.customer_id', 'left');
        $builder->where([
            'p.project_id'   => $project_id,
            'pd.language_id' => service('registry')->get('config_language_id')
        ]);

        $query = $builder->get();
        return $query->getRowArray();
    }

    public function getFilesByProjectId($project_id)
    {
        $image = [];
        $builder = $this->db->table('project_to_upload');
        $builder->select();
        $builder->where('project_id', $project_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $url = $result['filename'];
            $image[] = "<img src=" . $url ." class=\"kv-preview-data file-preview-other\">";
        }
        return json_encode($image);
    }

    public function getFilesPreviewConfig($project_id)
    {
        $config_data = [];
        $builder = $this->db->table('project_to_upload');
        $builder->select();
        $builder->where('project_id', $project_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $value) {
            $config_data[] = [
                'key'         => $value['code'],
                'type'        => $value['type'],
                'caption'     => $value['filename'],
                'downloadUrl' => $this->downloadProjectFiles($project_id),
                'size'        => $value['size'],
           ];
        }
        return json_encode($config_data);
    }
    // ----------END ----- //
    public function getFeedbackProjects($data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.type, p.status_id, p.runtime, p.employer_id, p.freelancer_id, ps.name as status, p.freelancer_review_id, p.employer_review_id');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('project_status ps', 'p.status_id = ps.status_id', 'left');
        $builder->where([
            'pd.language_id' => service('registry')->get('config_language_id'),
            'p.status_id'    => service('registry')->get('config_project_completed_status'),
            'p.freelancer_review_id'    => 0,
        ]);

        $builder->orWhere([
            'p.employer_review_id'    => 0,
        ]);

        if (isset($data['status'])) {
            $builder->where('p.status_id', $data['status']);
        }

        if (isset($data['customer_id'])) {
            $builder->where('p.freelancer_id', $data['customer_id']);
            $builder->orWhere('p.employer_id', $data['customer_id']);
        }

        if (isset($data['orderBy']) && $data['orderBy'] == 'DESC') {
            $data['orderBy'] = 'DESC';
        } else {
            $data['orderBy'] = 'ASC';
        }

        $sortData = ['pa.date_added'];

        if (isset($data['sortBy']) && in_array($data['sortBy'], $sortData)) {
            $builder->orderBy($data['sortBy'], 'DESC');
        } else {
            $builder->orderBy('p.date_added', 'ASC');
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

    public function getTotalAwardsByFreelancerId($freelancer_id)
    {
        $builder = $this->db->table('project_award');
        $builder->where(['freelancer_id' => $freelancer_id, 'status_id' => service('registry')->get('config_project_completed_status')]);
        return $builder->countAllResults();
    }

    public function updateViewed(int $project_id)
    {
        $builder = $this->db->table('project');
        $builder->where('project_id', $project_id);
        $builder->set('viewed', 'viewed+1', false);
        $builder->update();
    }

    public function getTotalBidsByProjectId($project_id)
    {
        $builder = $this->db->table('project_bids');
        $builder->where('project_id', $project_id);
        return $builder->countAllResults();
    }

    // Bootstrap FileInput
    public function downloadProjectFiles($project_id)
    {
        $builder = $this->db->table('project_to_upload');
        $builder->select();
        $builder->where('project_id', $project_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        if ($row) {
            $response = \Config\Services::response();
            $file = WRITEPATH . 'uploads/' . $row['code'];
            if (file_exists($file)) {
                return $response->download($file, null);
            } else {
                return;
            }
        } 
    }

    public function deleteProjectFiles(int $project_id, int $freelancer_id)
    {
        $builder = $this->db->table('project_to_upload');
        $builder->delete([
            'project_id' => $project_id,
            'freelancer_id' => $freelancer_id
        ]);
    }

    public function getProjectUploadedFile(int $project_id, int $freelancer_id)
    {
        $builder = $this->db->table('project_to_upload');
        $builder->select();
        $builder->where([
            'project_id' => $project_id,
            'freelancer_id' => $freelancer_id,
            ]);
        $query = $builder->get();
        return $query->getRowArray();
    }
    // -----------------------------------------------------------------
}
