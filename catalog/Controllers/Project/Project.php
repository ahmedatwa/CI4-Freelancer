<?php

namespace Catalog\Controllers\Project;

use Catalog\Controllers\BaseController;
use Catalog\Models\Catalog\ProjectModel;
use Catalog\Models\Catalog\CategoryModel;
use Catalog\Models\Account\ReviewModel;
use Catalog\Models\Extension\Bid\BidModel;
use Catalog\Models\Tool\UploadModel;

class Project extends BaseController
{
    /**
    * fallback function to override reversed routes for project list.
    * in case not found by SEO_URL service from DB
    */
    public function all()
    {
        $this->index();
    }
    // ----------------------
    public function index(string $keyword = '')
    {
        $projectModel = new ProjectModel();
        $categoryModel = new CategoryModel();

        $this->template->setTitle(lang('project/project.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/project.list.text_projects'),
            'href' => route_to('projects_all'),
        ];

        if ($this->request->getVar('skills')) {
            $filter_skills = explode('_', $this->request->getVar('skills'));
        } elseif($keyword) {
            $category_id = $categoryModel->findID($keyword);
            $filter_skills = explode('_', $category_id);
        } else {
            $filter_skills = null;
        }

        // for child Category lead info
        if ($keyword) {
            $data['breadcrumbs'][] = [
                'text' => $keyword,
                'href' => route_to('category', $keyword),
            ];
            $category = $categoryModel->getCategory($category_id);
            $data['lead']          = $category['description'];
            $data['heading_title'] = $category['name'];
            $data['icon']          = $category['icon'];
            $data['category_name'] = $category['name'];
        } else {
            $data['heading_title'] = lang('project/project.list.text_projects');
            $data['lead']          = '';
            $data['icon']          = '';
        }

        if ($this->request->getVar('type')) {
            $filter_type = explode('_', $this->request->getVar('type'));
        } else {
            $filter_type = [];
        }

        if ($this->request->getVar('state')) {
            $filter_state = $this->request->getVar('state');
        } else {
            $filter_state = null;
        }

        if ($this->request->getVar('budget')) {
            $filter_budget = $this->request->getVar('budget');
        } else {
            $filter_budget = '0_5500';
        }

        if ($this->request->getVar('keyword')) {
            $filter_keyword = $this->request->getVar('keyword');
        } else {
            $filter_keyword = null;
        }

        if ($this->request->getVar('sort_by')) {
            $sort_by = $this->request->getVar('sort_by');
        } else {
            $sort_by = 'p.date_added';
        }

        if ($this->request->getVar('order_by')) {
            $order_by = $this->request->getVar('order_by');
        } else {
            $order_by = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = $this->registry->get('theme_default_projects_limit') ?? 15;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $filter_data = [
            'filter_type'        => $filter_type,
            'filter_state'       => $filter_state,
            'filter_budget'      => $filter_budget,
            'filter_skills'      => $filter_skills,
            'filter_keyword'     => $filter_keyword,
            'sort_by'            => $sort_by,
            'order_by'           => $order_by,
            'limit'              => $limit,
            'start'              => ($page - 1) * $limit,
        ];

        $data['projects'] = [];
        
        $results = $projectModel->getProjects($filter_data);

        $total = $projectModel->getTotalProjects($filter_data);
        $reviewModel = new ReviewModel();

        foreach ($results as $result) {
            $days_left = $this->dateDifference($result['date_added'], $result['runtime']);
            $skills = $categoryModel->getCategoriesByProjectId($result['project_id']);

            if ($days_left) {
                $status = lang('project/project.list.text_expire', [$days_left]);
            } elseif ($days_left[0] <= 0 && ($days_left[1] <= 0)) {
                $status = lang('project/project.list.text_expired');
            } else {
                $status = $result['status'];
            }

            if ($result['categoryKeyword'] && $result['keyword']) {
                $href = route_to('single_project', $result['categoryKeyword'], $result['keyword']);
            } else {
                $href = base_url('project/project/view?pid=' . $result['project_id']);
            }

            $data['projects'][] = [
                'project_id'  => $result['project_id'],
                'name'        => ucfirst($result['name']),
                'description' => word_limiter($result['description'], 50),
                'meta_keyword'=> ($result['meta_keyword']) ? explode(',', $result['meta_keyword']) : '',
                'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'        => ($result['type'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_hourly_rate'),
                'date_added'  => $status,
                'skills'      => $skills,
                'final_date'  => getDateTimeString($result['date_added'], $result['runtime']),
                'href'        => $href,
            ];
        }
        

        $uri = $this->request->uri;

        $data['sorts'] = [];

        $data['sorts'][] = [
            'text'  => lang('common/search.list.text_newest'),
            'value' => 'date_added',
            'href'  => $uri->addQuery('sort_by', 'date_added')->addQuery('order_by', 'ASC')
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.list.text_lowest'),
            'value' => 'budget_min',
            'href'  => $uri->addQuery('sort_by', 'budget_min')->addQuery('order_by', 'ASC')
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.list.text_highest'),
            'value' => 'budget_max',
            'href'  => $uri->addQuery('sort_by', 'budget_max')->addQuery('order_by', 'DESC')
        ];

        $data['states'] = [];

        $data['states'][] = [
            'id'    => 'open',
            'value' => '8',
            'text'  => lang('project/project.list.text_all_open'),
        ];
        $data['states'][] = [
            'id'    => 'open_closed',
            'value' => 'all',
            'text'  => lang('project/project.list.text_all_open_closed'),
        ];

        $data['types'] = [];

        $data['types'][] = [
            'id'    => 'fixed_price',
            'value' => '1',
            'text'  => lang('project/project.list.text_fixed_price'),
        ];
        $data['types'][] = [
            'id'    => 'per_hour',
            'value' => '2',
            'text'  => lang('project/project.list.text_hourly_rate'),
        ];

        $data['categories'] = [];
        $categories = $categoryModel->getCategories();
        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name']
            ];
        }

        $data['total_projects']   = $total;

        $data['add_project'] = route_to('add-project') ? route_to('add-project') : base_url('project/project/add');
        $data['login']       = route_to('account_login') ? route_to('account_login') : base_url('account/login');
        $data['logged'] = $this->customer->isLogged();

        // set the redirect url
        $this->session->set('redirect_url', current_url());

        $data['filter_type']   = $filter_type;
        $data['filter_state']  = $filter_state;
        $data['filter_budget'] = $filter_budget;
        $data['filter_skills'] = $filter_skills;
        $data['sort_by']       = $sort_by;
        $data['order_by']      = $order_by;
        $data['limit']         = $limit;
        $data['page']          = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = ($total <= $limit) ? '' : $pager->makeLinks($page, $limit, $total);

        $data['langData'] = lang('project/project.list');

        $this->template->output('project/project_list', $data);
    }

    /**
    * fallback function to override reversed routes for single project info.
    * in case not found by SEO_URL service from DB
    */
    public function view()
    {
        $this->info();
    }

    public function info(string $category = '', string $keyword = '')
    {
        $projectModel = new ProjectModel();
        $categoryModel = new CategoryModel();

        if ($keyword) {
            $queryID = $projectModel->findID($keyword);
        }

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } elseif ($queryID) {
            $project_id = $queryID;
        } else {
            $project_id = 0;
        }

        if ($this->session->getFlashdata('project_success')) {
            $data['success'] = $this->session->getFlashdata('project_success');
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/project.list.text_projects'),
            'href' => route_to('projects_all') ? route_to('projects_all') : base_url('project/category'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $categoryModel->getCategoryByProjectId($project_id),
            'href' => route_to('projects', $category) ?? base_url('project/project?pid=' . $project_id),
        ];

        // for pre-defined routes
        if ($keyword) { 
            $this->template->setTitle($category . '|' . $keyword);
            $data['breadcrumbs'][] = [
                'text' => $keyword ?? lang('project/project.list.text_project'),
                'href' => '',
            ];
        } else {
            $this->template->setTitle(lang('project/project.list.text_project'));
        }

        if ($this->customer->isLogged()) {
            $data['freelancer_id'] = $this->customer->getID();
        } else {
            $data['freelancer_id'] = 0;
        }

        $data['logged'] = $this->customer->isLogged();
        // currency
        if ($this->request->getCookie(config('App')->cookiePrefix . 'currency')) {
            $data['config_currency'] = \Config\Services::encrypter()->decrypt(base64_decode($this->request->getCookie(config('App')->cookiePrefix . 'currency', FILTER_SANITIZE_STRING)));
        } else {
            $data['config_currency'] = $this->registry->get('config_currency');
        }

        $data['login']           = base_url('account/login');

        if ($project_id) {
            $project_info = $projectModel->getProject($project_id);
        } 

        if ($project_info) {
            $reviewModel = new ReviewModel();
            
            $data['bidAVG']       = round(($project_info['budget_min'] + $project_info['budget_max']) / 2);
            $data['deliveryTime'] = $project_info['delivery_time'];
            $data['project_id']   = $project_info['project_id'];
            $data['name']         = $project_info['name'] ?? '';
            $data['budget']       = $this->currencyFormat($project_info['budget_min']) . ' - ' . $this->currencyFormat($project_info['budget_max']);
            $data['description']  = $project_info['description'];
            $data['categories']   = $categoryModel->getCategoriesByProjectId($project_id);
            $data['viewed']       = $project_info['viewed'];

            // attachments
            $uploadModel = new UploadModel();
            $attachments = $uploadModel->where('project_id', $project_info['project_id'])->findAll();

            if ($attachments) {
                foreach ($attachments as $attachment) {
                   $data['attachments'][] = [
                        'code' => substr($attachment['code'], 0, strpos($attachment['code'], '.')),
                        'ext'  => $attachment['ext'],
                        'size' => $attachment['size'] / 1000,
                        'href' => route_to('get_upload', $attachment['upload_id'], $attachment['project_id']),
                   ];
                }
            }

            // Calculate the Bidding Time
            $days_left = $this->dateDifference($project_info['date_added'], $project_info['runtime']);
            // update the project status if expired
            if (($days_left[0] <= 0) && ($days_left[1] <= 0)) {
                $project_status = [
                    'status_id' => $this->registry->get('config_project_expired_status')
                ];
                $projectModel->update($project_info['project_id'], $project_status);
            }
            // Bidding Days Left
            if (($days_left[0] <= 0) && ($days_left[1] <= 0)) {
                $data['days_left'] = 0;
            } else {
                $data['days_left'] = $days_left[0];
            }

            $data['final_date']  = getDateTimeString($project_info['date_added'], $project_info['runtime']);
            $data['runtime']     = $project_info['runtime'];
            $data['rating']      = round($reviewModel->getAvgReviewByEmployerId($project_info['employer_id']));
            $data['employer']    = ($project_info['employer'] == '') ? $project_info['employer'] : '@' . $project_info['username'];
            $data['employer_id'] = $project_info['employer_id'];
            $data['status']      = $projectModel->getStatusByProjectId($project_info['project_id']);

            // more Employer projects
            $data['other_projects'] = [];
            
            $filter_data = [
                'start' => 0,
                'limit' => 5,
                'current_project' => $project_info['project_id']
            ];

            $other_projects = $projectModel->getProjects($filter_data);

            foreach ($other_projects as $result) {
                    $data['other_projects'][] = [
                        'project_id'  => $result['project_id'],
                        'name'        => $result['name'],
                        'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                        'href'        => ($result['keyword']) ? route_to('single_project', $result['project_id'], $result['keyword']) : base_url('project/project/view?pid=' . $result['project_id']),
                    ];
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // optional upgrades
        $data['config_upgrade_sponser'] = $this->registry->get('config_upgrade_sponser');
        $data['config_upgrade_highlight'] = $this->registry->get('config_upgrade_highlight');

        $data['isLogged'] = $this->customer->isLogged();
        // Bids Total
        $bidModel = new BidModel();
        $data['total_bids'] = $bidModel->getTotalBids($filter_data);
        // save refereal Url in session
        $url_query = $this->request->uri->getQuery();
        $url = '';
        if ($url_query) {
            $url = '?' . $url_query;
        }

        $this->session->set('redirect_url', base_url(current_url() . $url));

        $projectModel->updateViewed($project_id);

        $data['langData'] = lang('project/project.list');

        $this->template->output('project/project_info', $data);
    }
    
    public function add()
    {
        $json = [];

        if ($this->request->isAJAX() && $this->request->getMethod() == 'post') {
            foreach ($this->request->getPost('project_description') as $language_id => $value) {
                if (! $this->validate([
                    "project_description.{$language_id}.name" => [
                        'label' => 'Project Name',
                        'rules' => 'required|min_length[10]|max_length[64]'
                    ],
                    "project_description.{$language_id}.description" => [
                        'label' => 'Project Description',
                        'rules' => 'required|min_length[30]'
                    ],
                    "delivery_time" => [
                        'label' => 'Delivery Time',
                        'rules' => 'required|less_than_equal_to[30]'
                    ],
                    "category" => [
                        'label' => 'Skills',
                        'rules' => 'required'
                    ],
                    "budget_min" => [
                        'label' => 'Minimum Budget',
                        'rules' => 'required|greater_than_equal_to[5]'
                    ],
                    "budget_max" => [
                        'label' => 'Maximum Budget',
                        'rules' => "required|greater_than[{$this->request->getPost('budget_min')}]"
                    ],
                    "runtime" => [
                        'label' => 'Bidding Duration',
                        'rules' => 'required|less_than_equal_to[30]'
                    ],
                    ])) {
                    $json['error_warning'] = lang('project/project.text_warning');
                    $json['error'] = $this->validator->getErrors();
                }
            }
            
            if (! $json) {
                $projectModel = new ProjectModel();                
                $project_id = $projectModel->addProject($this->request->getPost());
                // Process uploaded attachments
                if ($project_id) {
                    $uploadModel = new UploadModel();
                    if ($imagefile = $this->request->getFiles()) {
                        foreach ($imagefile['projectfiles'] as $file) {
                            if ($file->isValid() && ! $file->hasMoved()) {
                                $newName = $file->getRandomName();
                                $uploadPath = WRITEPATH . 'uploads/project' . $project_id;
                                if (is_dir($uploadPath)) {
                                    $file->move($uploadPath, $newName);
                                } else {
                                    mkdir(WRITEPATH . 'uploads/project' . $project_id, 0777);
                                    $file->move($uploadPath, $newName);
                                }

                                $data = [
                                    'project_id'    => $project_id,
                                    'customer_id'   => $this->customer->getID(),
                                    'filename'      => $file->getClientName(),
                                    'code'          => $newName,
                                    'type'          => $file->getClientMimeType(),
                                    'ext'           => $file->getClientExtension(),
                                    'size'          => $file->getSize()
                                ];
                                $uploadModel->insert($data);
                            } else {
                                $json['error_file'] = $file->getError() . ' ' . $file->getErrorString();

                            }
                        }
                    }
                }

                $this->session->setFlashdata('project_success', lang('project/project.success_new_project'));
                $project_info = $projectModel->getProject($project_id);

                if ($project_info) {
                    $json['redirect'] = route_to('single_project', $project_info['keyword']);
                } else {
                    $json['redirect'] = base_url('project/project/view?pid=' . $project_info['keyword']);
                }
            }
        }

        return $this->response->setJSON($json);
    }

    public function getForm()
    {
        if (! $this->customer->isLogged()) {
            // Set the previous url in session
            $this->session->set('redirect_url', current_url());
            return redirect()->to(route_to('account_login') ? route_to('account_login') : base_url('account/login'));
        }

        $projectModel = new ProjectModel();

        $this->template->setTitle($this->registry->get('config_name'));

        $data['text_form'] = lang($this->locale . '.list.button_add');

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => $data['text_form'],
            'href' => route_to('add-project'),
        ];

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }
    
        $data['button_save'] = lang($this->locale . '.list.button_add');
        
        // upload extensions allowed
        $file_ext_allowed = preg_replace('~\r?\n~', "\n", $this->registry->get('config_file_ext_allowed'));

        $filetypes = explode("\n", $file_ext_allowed);
        
        foreach ($filetypes as $filetype) {
            $data['allowedFileExtensions'][] = trim($filetype);
        }

        $data['language_id'] = $this->registry->get('config_language_id');
        $data['employer_id'] = $this->customer->getID();

        // currency
        $data['config_currency'] = $this->registry->get('config_currency');

        $data['langData'] = lang('project/project.list');

        $this->template->output('project/project_form', $data);
    }

    public function filter()
    {
        $json = [];

        if ($this->request->getVar('url')) {
            $uri = new \CodeIgniter\HTTP\URI($this->request->getVar('url'));

            if ($this->request->getPost('skills')) {
                $uri->addQuery('skills', $this->request->getPost('skills'));
            }

            if ($this->request->getPost('budget')) {
                $uri->addQuery('budget', $this->request->getPost('budget'));
            }

            if ($this->request->getPost('type')) {
                $uri->addQuery('type', $this->request->getPost('type'));
            }

            if ($this->request->getPost('clear')) {
                $uri->stripQuery($this->request->getPost('clear'));
            }

            if ($this->request->getPost('state')) {
                $uri->addQuery('state', $this->request->getPost('state'));
            }

            $json['uri'] = (string) $uri;
        }
        
        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        foreach ($this->request->getPost('project_description') as $language_id => $value) {
            if (! $this->validate([
                    "project_description.{$language_id}.name" => [
                    'label' => 'Project Name',
                    'rules' => 'required|min_length[10]|max_length[64]'
                ],
                "project_description.{$language_id}.description" => [
                    'label' => 'Project Description',
                    'rules' => 'required|min_length[30]'
                ],
                "delivery_time" => [
                    'label' => 'Delivery Time',
                    'rules' => 'required|numeric'
                ],
                "filter_category" => [
                    'label' => 'Skills',
                    'rules' => 'required'
                ],
                "budget_min" => [
                    'label' => 'Minimum Budget',
                    'rules' => 'required|numeric'
                ],
                "budget_max" => [
                    'label' => 'Maximum Budget',
                    'rules' => 'required|numeric'
                ],
                ])) {
                return false;
            }
        }

        return true;
    }

    //--------------------------------------------------------------------
}
