<?php

namespace Catalog\Models\Catalog;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ProjectModel extends Model
{
    protected $table         = 'project';
    protected $primaryKey    = 'project_id';
    protected $returnType    = 'array';
    protected $allowedFields = ['status_id', 'employer_review_id', 'freelancer_review_id'];
    protected $useTimestamps = true;
    protected $dateFormat    = 'int';
    protected $createdField  = 'date_added';
    protected $updatedField  = 'date_modified';

    protected static function afterInsertEvent(array $eventData)
    {
        if (isset($eventData)) {
            \CodeIgniter\Events\Events::trigger('project_add', $eventData);
            \CodeIgniter\Events\Events::trigger('mail_project_add', $eventData);
            // Pusher
            $options = [
                'cluster' => PUSHER_CLUSTER,
                'useTLS' => PUSHER_USETLS
            ];

            $pusher = new \Pusher\Pusher(
                PUSHER_KEY,
                PUSHER_SECRET,
                PUSHER_APP_ID,
                $options
            );
            $pusher->trigger('global-channel', 'new-project-event', $eventData);
        }
    }

    protected function beforeUpdate(array $data)
    {
    }

    public function addProject(array $data)
    {
        $builder = $this->db->table($this->table);
        $project_data = [
            'type'          => $data['type'],
            'runtime'       => $data['runtime'],
            'employer_id'   => $data['employer_id'],
            'budget_min'    => $data['budget_min'],
            'budget_max'    => $data['budget_max'],
            'delivery_time' => $data['delivery_time'],
            'status_id'     => service('registry')->get('config_project_status_id') ?? 8,
            'date_added'    => Time::now()->getTimestamp(),
            'date_modified' => Time::now()->getTimestamp(),
        ];

        $builder->insert($project_data);
        // Get Last Inserted ID
        $project_id = $this->db->insertID();

        // project_description Query
        if (isset($data['project_description'])) {
            $project_description_table = $this->db->table('project_description');
            foreach ($data['project_description'] as $language_id => $value) {
                $project_description = [
                    'project_id'       => $project_id,
                    'language_id'      => $language_id,
                    'name'             => $value['name'],
                    'keyword'          => url_title(convert_accented_characters($value['name']), '-', true),
                    'description'      => $value['description'],
                    'meta_title'       => $value['meta_title'] ?? '',
                    'meta_description' => $value['meta_description'] ?? '',
                    'meta_keyword'     => $value['meta_keyword'] ?? '',
                ];
                $project_description_table->insert($project_description);
                // Trigger Pusher Notification event
                $pusherData = [
                    'name'        => $value['name'],
                    'employer_id' => $data['employer_id'],
                    'budget'      => $data['budget_min'] . ' - ' . $data['budget_max'],
                    'href'        => route_to('single_project', $project_id, $project_description['keyword'])
                ];
            }
        }
        // project_categories
        if (isset($data['category'])) {
            $project_category_table = $this->db->table('project_to_category');
            $project_category_table->delete(['project_id' => $project_id]);
            foreach ($data['category'] as $category_id) {
                $project_category_data = [
                    'project_id'       => $project_id,
                    'category_id'      => $category_id,
                ];
                $project_category_table->insert($project_category_data);
            }
        }
        // Event Data
        if ($pusherData) {
            static::afterInsertEvent($pusherData);
        }
        
        return $project_id;
    }

    public function getProjects(array $data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, pd.description, p.status_id, p.budget_min, p.budget_max, p.type, p.date_added, pd.meta_keyword, p.delivery_time, p.runtime, ps.name AS status, p.employer_id, p.freelancer_id, pd.keyword, cd.keyword AS categoryKeyword')
                ->join('project_description pd', 'p.project_id = pd.project_id', 'left')
                ->join('project_status ps', 'p.status_id = ps.status_id', 'left')
                ->join('project_to_category p2c', 'p.project_id = p2c.project_id', 'left')
                ->join('category_description cd', 'cd.category_id = p2c.category_id', 'left')
                ->groupBy('p.project_id');

        $builder->where([
            'pd.language_id' => service('registry')->get('config_language_id'),
            'p.draft'        => 0,
        ]);

        if (isset($data['filter_skills'])) {
            if (is_array($data['filter_skills'])) {
                $builder->whereIn('p2c.category_id', $data['filter_skills']);
            } else {
                $builder->where('p2c.category_id', $data['filter_skills']);
            }
        }

        if (isset($data['employer_id'])) {
            $builder->where('p.employer_id', $data['employer_id']);
        }

        if (isset($data['filter_type']) && !empty($data['filter_type'])) {
            $builder->whereIn('p.type', $data['filter_type']);
        }

        if (isset($data['filter_state'])) {
            $filter_state = explode(',', $data['filter_state']);
           
            if (in_array('all', $filter_state)) {
                $builder->where('p.status_id > ', 0);
            } else {
                $builder->whereIn('p.status_id', $filter_state);
            }
        }

        if (isset($data['current_project'])) {
            $builder->where('p.project_id !=', $data['current_project']);
        }

        if (isset($data['filter_keyword']) && !empty($data['filter_keyword'])) {
            $builder->like('pd.name', $data['filter_keyword'], 'after');
        }

        if (isset($data['filter_date_added'])) {
            $builder->where('DATE("p.date_added")', 'DATE("' . $data['filter_date_added'] .'")');
        }

        // Dshboard Projects
        if (isset($data['status_id']) && !empty($data['status_id'])) {
            $status_id = explode(',', $data['status_id']);
            $builder->whereIn('p.status_id', $status_id);
        }

        // Budget Filter
        if (isset($data['filter_budget']) && !empty($data['filter_budget'])) {
            $parts  = explode('_', $data['filter_budget']);

            $builder->where('p.budget_min >= ', $parts[0])
                    ->where('p.budget_min <= ', $parts[1]);
        }
        
        // Filter
        if (isset($data['filter']) && !empty($data['filter'])) {
            $builder->whereIn('p.type', (array) $data['filter']);
            $builder->orWhereIn('p.status', str_replace('_', ',', $data['filter']));
        }

        $sortData = [
            'p.budget_min',
            'p.budget_max',
            'p.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
        }

        if (isset($data['sort_by']) && in_array('p.' . $data['sort_by'], $sortData)) {
            $builder->orderBy($data['sort_by'], $data['order_by']);
        } else {
            $builder->orderBy('p.date_added', 'DESC');
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

    public function getTotalProjects(array $data = [])
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, pd.description, p.status_id, p.budget_min, p.budget_max, p.type, p.date_added, pd.meta_keyword, p.delivery_time, p.runtime, ps.name AS status, p.employer_id, p.freelancer_id');
        $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
        $builder->join('project_status ps', 'p.status_id = ps.status_id', 'left');
       
        if (isset($data['filter_skills']) && !empty($data['filter_skills'])) {
            $builder->join('project_to_category p2c', 'p.project_id = p2c.project_id', 'left');
            $builder->where('p2c.category_id', $data['filter_skills']);
        }

        if (isset($data['employer_id'])) {
            $builder->where('p.employer_id', $data['employer_id']);
        }

        if (isset($data['filter_type']) && !empty($data['filter_type'])) {
            $builder->whereIn('p.type', $data['filter_type']);
        }

        if (isset($data['filter_state'])) {
            $filter_state = explode(',', $data['filter_state']);
           
            if (in_array('all', $filter_state)) {
                $builder->where('p.status_id > ', 0);
            } else {
                $builder->whereIn('p.status_id', $filter_state);
            }
        }

        if (isset($data['current_project'])) {
            $builder->where('p.project_id !=', $data['current_project']);
        }

        if (isset($data['filter_keyword']) && !empty($data['filter_keyword'])) {
            $builder->like('pd.name', $data['filter_keyword'], 'after');
        }

        if (isset($data['filter_date_added'])) {
            $builder->where('DATE("p.date_added")', 'DATE("' . $data['filter_date_added'] .'")');
        }

        // Budget Filter
        if (isset($data['filter_budget']) && !empty($data['filter_budget'])) {
            $parts  = explode('_', $data['filter_budget']);

            $builder->where('p.budget_min >= ', $parts[0])
                    ->where('p.budget_min <= ', $parts[1]);
        }
        
        // Filter
        if (isset($data['filter']) && !empty($data['filter'])) {
            $builder->whereIn('p.type', (array) $data['filter']);
            $builder->orWhereIn('p.status', str_replace('_', ',', $data['filter']));
        }

        $builder->groupBy('p.project_id');

        $sortData = [
            'p.budget_min',
            'p.budget_max',
            'p.date_added',
        ];

        if (isset($data['order_by']) && $data['order_by'] == 'DESC') {
            $data['order_by'] = 'DESC';
        } else {
            $data['order_by'] = 'ASC';
        }

        if (isset($data['sort_by']) && in_array('p.' . $data['sort_by'], $sortData)) {
            $builder->orderBy($data['sort_by'], $data['order_by']);
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

    public function getProjectDescription(int $project_id)
    {
        $builder = $this->db->table('project_description');

        $project_description_data = [];
        
        $builder->select();
        $builder->where('project_id', $project_id);
        $query = $builder->get();
        foreach ($query->getResultArray() as $result) {
            $project_description_data[$result['language_id']] = [
                'name'             => $result['name'],
                'description'      => $result['description'],
                'meta_title'       => $result['meta_title'],
                'meta_description' => $result['meta_description'],
                'meta_keyword'     => $result['meta_keyword'],
            ];
        }
        return $project_description_data;
    }

    public function getProject(int $project_id)
    {
        $builder = $this->db->table('project p');
        $builder->select('p.project_id, pd.name, p.budget_min, p.budget_max, pd.description, p.date_added, p.runtime, CONCAT(c.firstname, " ", c.lastname) AS employer, p.employer_id, p.type, ps.name AS status, p.viewed, c.username, p.delivery_time, pd.keyword');
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

    public function getStatusByProjectId(int $project_id)
    {
        $builder = $this->db->table('project p');
        $builder->select('ps.name');
        $builder->join('project_status ps', 'p.status_id = ps.status_id', 'left');
        $builder->where('p.project_id', $project_id);
        $query = $builder->get();
        $row = $query->getRowArray();
        return $row['name'];
    }

    public function updateViewed(int $project_id)
    {
        $builder = $this->db->table('project');
        $builder->where('project_id', $project_id);
        $builder->set('viewed', 'viewed+1', false);
        $builder->update();
    }

    public function findID(string $keyword)
    {
        $builder = $this->db->table('project_description');
        $builder->where('keyword', $keyword);
        $row = $builder->get()->getRowArray();
        if ($row) {
            return  $row[$this->primaryKey];
        } else {
            return 0;
        }
    }

    // public function getTotalBidsByProjectId($project_id)
    // {
    //     $builder = $this->db->table('project_bids');
    //     $builder->where('project_id', $project_id);
    //     return $builder->countAllResults();
    // }

    // Bootstrap FileInput
    // public function getFilesByProjectId($project_id)
    // {
    //     $image = [];
    //     $builder = $this->db->table('project_to_upload');
    //     $builder->select();
    //     $builder->where('project_id', $project_id);
    //     $query = $builder->get();
    //     foreach ($query->getResultArray() as $result) {
    //         $url = $result['filename'];
    //         $image[] = "<img src=" . $url ." class=\"kv-preview-data file-preview-other\">";
    //     }
    //     return json_encode($image);
    // }

    // public function getFilesPreviewConfig($project_id)
    // {
    //     $config_data = [];
    //     $builder = $this->db->table('project_to_upload');
    //     $builder->select();
    //     $builder->where('project_id', $project_id);
    //     $query = $builder->get();
    //     foreach ($query->getResultArray() as $value) {
    //         $config_data[] = [
    //             'key'         => $value['code'],
    //             'type'        => $value['type'],
    //             'caption'     => $value['filename'],
    //             'downloadUrl' => $this->downloadProjectFiles($project_id),
    //             'size'        => $value['size'],
    //        ];
    //     }
    //     return json_encode($config_data);
    // }

    // public function downloadProjectFiles($project_id)
    // {
    //     $builder = $this->db->table('project_to_upload');
    //     $builder->select();
    //     $builder->where('project_id', $project_id);
    //     $query = $builder->get();
    //     $row = $query->getRowArray();
    //     if ($row) {
    //         $response = \Config\Services::response();
    //         $file = WRITEPATH . 'uploads/' . $row['code'];
    //         if (file_exists($file)) {
    //             return $response->download($file, null);
    //         } else {
    //             return;
    //         }
    //     }
    // }

    // public function deleteProjectFiles(int $project_id, int $freelancer_id)
    // {
    //     $builder = $this->db->table('project_to_upload');
    //     $builder->delete([
    //         'project_id' => $project_id,
    //         'freelancer_id' => $freelancer_id
    //     ]);
    // }

    // public function getProjectUploadedFile(int $project_id, int $freelancer_id)
    // {
    //     $builder = $this->db->table('project_to_upload');
    //     $builder->select();
    //     $builder->where([
    //         'project_id' => $project_id,
    //         'freelancer_id' => $freelancer_id,
    //         ]);
    //     $query = $builder->get();
    //     return $query->getRowArray();
    // }
    // Freelancer In-progress Projects
    // public function getfreelancerProjects(int $freelancer_id)
    // {
    //     $builder = $this->db->table('project p');
    //     $builder->select('p.project_id, pd.name, pd.description, p.status_id, p.date_added, p.budget_min, p.budget_max, p.type, p.date_added, pd.meta_keyword, p.delivery_time, p.runtime, ps.name AS status');
    //     $builder->join('project_description pd', 'p.project_id = pd.project_id', 'left');
    //     $builder->join('project_status ps', 'p.status_id = ps.status_id', 'left');
    //     $builder->join('project_bids pb', 'pb.project_id = p.project_id', 'left');
    //     $builder->where([
    //         'pd.language_id' => service('registry')->get('config_language_id'),
    //         'pb.freelancer_id' => $freelancer_id,
    //         'pb.accepted' => 1,
    //     ]);

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    
    // -----------------------------------------------------------------
}
