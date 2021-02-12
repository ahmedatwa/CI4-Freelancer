<?php namespace Catalog\Controllers\Project;

use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Catalog\CategoryModel;
use \Catalog\Models\Account\ReviewModel;
use \Catalog\Models\Tool\DownloadModel;

class Project extends \Catalog\Controllers\BaseController
{
    // ---------------------
    // child function for index, if failed route
    public function category()
    {
        $this->index();
    }
    // ----------------------
    public function index()
    {
        $projectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $seoUrl = service('seo_url');

        $this->template->setTitle(lang('project/project.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/project.text_projects'),
            'href' => route_to('projects'),
        ];

        if ($this->request->getVar('gid')) {
            $filter_category_id = $this->request->getVar('gid');
        } elseif ($this->request->uri->getSegment(2)) {
            $filter_category_id = substr($this->request->uri->getSegment(2), 1);
        } else {
            $filter_category_id = null;
        }

        // for child Category lead info
        if ($filter_category_id) {
            $category_info = $categoryModel->getCategory($filter_category_id);
            $data['breadcrumbs'][] = [
                'text' => $category_info['name'],
                'href' => route_to('category', $filter_category_id, $seoUrl->getKeywordByQuery('category_id=' . $filter_category_id)),
            ];

            $data['lead']          = $category_info['description'];
            $data['heading_title'] = $category_info['name'];
            $data['icon']          = $category_info['icon'];
            $data['button_hire']   = lang('Hire For ' . $category_info['name']);
        } else {
            $data['heading_title'] = lang('project/project.text_projects');
            $data['lead']          = '';
            $data['button_hire']   = lang($this->locale . '.button_hire');
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
        
        if ($this->request->getVar('skills')) {
            $filter_skills = explode('_', $this->request->getVar('skills'));
        } else {
            $filter_skills = [];
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
             'filter_category_id' => $filter_category_id,
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
            // SEO Query
            $keyword = $seoUrl->getKeywordByQuery('project_id=' . $result['project_id']);
            $days_left = $this->dateDifference($result['date_added'], $result['runtime']);

            if (! is_int($days_left)) {
                $status = $result['status'];
            } elseif($days_left <= 0) {
                $status = lang('project/project.text_expired');
            } else {    
                $status = lang('project/project.text_expire', [$days_left]);
            }

            $data['projects'][] = [
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'description' => word_limiter($result['description'], 50),
                'meta_keyword'=> ($result['meta_keyword']) ? explode(',', $result['meta_keyword']) : '',
                'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'type'        => ($result['type'] == 1) ? lang($this->locale . '.text_fixed_price') : lang($this->locale . '.text_per_hour'),
                'date_added'  => $status,
                'href'        => ($keyword) ? route_to('single_project', $result['project_id'], $keyword) : base_url('project/project/view?pid=' . $result['project_id']),
            ];
        }
        
        $uri = $this->request->uri;
 
        $data['sorts'] = [];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_newest'),
            'value' => 'date_added',
            'href'  => $uri->addQuery('sort_by', 'date_added')->addQuery('order_by', 'ASC')
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_lowest'),
            'value' => 'budget_min',
            'href'  => $uri->addQuery('sort_by', 'budget_min')->addQuery('order_by', 'ASC')
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_highest'),
            'value' => 'budget_max',
            'href'  => $uri->addQuery('sort_by', 'budget_max')->addQuery('order_by', 'DESC')
        ];

        $data['states'] = [];

        $data['states'][] = [
            'id'    => 'open',
            'value' => '8',
            'text'  => lang('project/project.text_all_open'),
        ];
        $data['states'][] = [
            'id'    => 'open_closed',
            'value' => 'all',
            'text'  => lang('project/project.text_all_open_closed'),
        ];

        $data['types'] = [];

        $data['types'][] = [
            'id'    => 'fixed_price',
            'value' => '1',
            'text'  => lang($this->locale . '.text_fixed_price'),
        ];
        $data['types'][] = [
            'id'    => 'per_hour',
            'value' => '2',
            'text'  => lang($this->locale . '.text_per_hour'),
        ];

        $data['categories'] = [];
        $categories = $categoryModel->getCategories();
        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id' => $category['category_id'],
                'name'        => $category['name']
            ];
        }

        $data['text_search_keyword'] = lang('project/project.text_search_keyword');
        $data['button_search']       = lang('project/project.button_search');
        $data['text_found']          = lang('project/project.text_found', [$total]);
        $data['text_sidebar']        = lang('project/project.text_sidebar');
        $data['text_type']           = lang('project/project.text_type');
        $data['text_skills']         = lang('project/project.text_skills');
        $data['text_languages']      = lang('project/project.text_languages');
        $data['text_state']          = lang('project/project.text_state');
        $data['text_budget']         = lang('project/project.text_budget');
        
        $data['text_projects']       = lang('project/project.text_projects');
        $data['button_work']         = lang($this->locale . '.button_work');
        $data['button_bid_now']      = lang('project/project.button_bid_now');
        $data['text_select']         = lang($this->locale . '.text_select');

        $data['add_project'] = route_to('add-project') ? route_to('add-project') : base_url('project/project/add');
        $data['login']       = route_to('account_login') ? route_to('account_login') : base_url('account/login');
        $data['logged'] = $this->customer->isLogged();

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

        $this->template->output('project/project_list', $data);
    }

    // Single Project View
    // function in case of failed route for info, therefore 404 error won't be excuted
    public function view()
    {
        $this->info();
    }

    public function info()
    {
        if ($this->request->uri->getSegment(3) && $this->request->uri->getSegment(3) != 'view') {
            $keyword = $this->request->uri->getSegment(3);
        } else {
            $keyword = '';
        }

        $projectModel = new ProjectModel();

        $seoUrl = service('seo_url');

        $categoryModel = new CategoryModel();

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } elseif ($this->request->getGet('project_id')) {
            $project_id = $this->request->getGet('project_id');
        } elseif ($this->request->uri->getSegment(3)) {
            $project_id = (int) substr($this->request->uri->getSegment(3), 1);
        } else {
            $project_id = 0;
        }

        if ($this->session->getFlashdata('success')) {
            $data['success'] = $this->session->getFlashdata('success');
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/project.text_projects'),
            'href' => route_to('projects') ? route_to('projects') : base_url('project/category'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $categoryModel->getCategoryByProjectId($project_id),
            'href' => route_to('projects') ? route_to('projects') : base_url('project/project?pid=' . $project_id),
        ];
        // for pre-defined routes
        if ($keyword) {
            $this->template->setTitle($keyword);
            $data['breadcrumbs'][] = [
                'text' => $keyword ?? lang('project/project.text_project'),
                'href' => '',
            ];
        } else {
            $this->template->setTitle('Project');
        }

        if ($this->customer->isLogged()) {
            $data['freelancer_id'] = $this->customer->getCustomerId();
        } else {
            $data['freelancer_id'] = 0;
        }

        $data['logged']          = $this->customer->isLogged();
        $data['config_currency'] = $this->session->get('currency') ?? $this->registry->get('config_currency');
        $data['register']        = route_to('register') ? route_to('register') : base_url('acocunt/register');
        $data['add_project']     = route_to('add-project') ? route_to('add-project') : base_url('project/project/add');
        
        $project_info = [];

        if ($project_id) {
            $project_info = $projectModel->getProject($project_id);
        } 

        if ($project_info) {
            $reviewModel = new ReviewModel();

            $data['project_id']  = $project_info['project_id'];
            $data['name']        = $project_info['name'] ?? '';
            $data['budget']      = $this->currencyFormat($project_info['budget_min']) . ' - ' . $this->currencyFormat($project_info['budget_max']);
            $data['description'] = $project_info['description'];
            $data['categories']  = $categoryModel->getCategoriesByProjectId($project_id);
            $data['viewed']      = $project_info['viewed'];

            // attachments
            $downloadModel = new DownloadModel();
            $data['download']        = base_url('tool/download?download_id=' . $project_info['download_id']);
            $data['attachment']      = $downloadModel->where('download_id', $project_info['download_id'])->findColumn('filename')[0];
            $data['attachment_ext']  =  strtoupper($downloadModel->where('download_id', $project_info['download_id'])->findColumn('ext')[0]);

            // Calculate the Bidding Time
            $days_left = $this->dateDifference($project_info['date_added'], $project_info['runtime']);

            if ($project_info['runtime'] != 0) {
                $project_status = ['status_id' => $this->registry->get('config_project_expired_status')];
                $projectModel->update($project_info['project_id'], $project_status);
            }

            if (! is_int($days_left)) {
                $data['days_left'] = $project_info['status'];
            } elseif($days_left <= 0) {
            	$data['days_left'] = lang('project/project.text_expired');
            } else {	
                $data['days_left'] = lang('project/project.text_expire', [$days_left]);
            }
            

            $data['runtime'] = $project_info['runtime'];
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
                $keyword = $seoUrl->getKeywordByQuery('project_id=' . $result['project_id']);
                $data['other_projects'][] = [
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'budget'      => $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']),
                'href'        => ($keyword) ? route_to('single_project', $result['project_id'], $keyword) : base_url('project/project/project?pid=' . $result['project_id']),
            ];
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['text_about']          = lang('project/project.text_about');
        $data['text_budget']         = lang('project/project.text_budget');
        $data['text_description']    = lang('project/project.text_description');
        $data['text_attachments']    = lang('project/project.text_attachments');
        $data['text_skills']         = lang('project/project.text_skills');
        $data['text_bid']            = lang('project/project.text_bid');
        $data['text_rate']           = lang('project/project.text_rate');
        $data['text_bid_detail']     = lang('project/project.text_bid_detail');
        $data['text_describe']       = lang('project/project.text_describe');
        $data['text_delivery']       = lang('project/project.text_delivery');
        $data['text_register']       = lang('common/header.text_register');
        $data['text_facebook']       = lang($this->locale . '.text_facebook');
        $data['text_twitter']        = lang($this->locale . '.text_twitter');
        $data['text_gplus']          = lang($this->locale . '.text_gplus');
        $data['button_bid']          = lang('project/project.button_bid');
        $data['text_expired']        = lang('project/project.text_expired');
        $data['text_similar']        = lang('project/project.text_similar');
        $data['button_post_project'] = lang('project/project.button_post_project');

        // optional upgrades
        $data['config_upgrade_sponser'] = $this->registry->get('config_upgrade_sponser');
        $data['config_upgrade_highlight'] = $this->registry->get('config_upgrade_highlight');

        $data['isLogged'] = $this->customer->isLogged();
        $data['login'] = route_to('account_login');
        // save refereal Url in session
        $url_query = $this->request->uri->getQuery();
        $url = '';
        if ($url_query) {
            $url = '?' . $url_query;
        } 
        $this->session->set('redirect_url', base_url(current_url() . $url));

        $projectModel->updateViewed($project_id);

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
                        'rules' => 'required|numeric'
                    ],
                    "category" => [
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
                    "runtime" => [
                        'label' => 'Bidding Duration',
                        'rules' => 'required|numeric'
                    ],
                    ])) {
                    $error_warning = ['error_warning' => lang('project/project.text_warning')];
                    $json['error'] = array_merge($this->validator->getErrors(), $error_warning);
                }
            }
            
            if (! $json) {
                $projectModel = new ProjectModel();

                $seoUrl = service('seo_url');

                $project_id = $projectModel->addProject($this->request->getPost());

                $keyword = $seoUrl->getKeywordByQuery('project_id=' . $project_id);

                $this->session->setFlashdata('success', lang('project/project.success_new_project'));
                $json['redirect'] = route_to('single_project', $project_id, $keyword);
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

        $data['text_form'] = !$this->request->getVar('project_id') ? lang('project/project.button_add') : lang('project/project.button_edit');

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => $data['text_form'],
            'href' => route_to('add-project'),
        ];

       
        $data['action'] = route_to('add-project') ? route_to('add-project') : base_url('project/project/add');

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

        $data['heading_title']         = lang('project/project.heading_title');
        $data['text_tell_us']          = lang('project/project.text_tell_us');
        $data['text_sub']              = lang('project/project.text_sub');
        
        $data['text_estimate']         = lang('project/project.text_estimate');
        $data['text_fixed_price']      = lang('project/project.text_fixed_price');
        $data['text_per_hour']         = lang('project/project.text_per_hour');
        $data['entry_description']     = lang('project/project.entry_description');
        $data['text_type']             = lang('project/project.text_type');
        $data['text_budget']           = lang('project/project.text_budget');
        $data['text_select']           = lang($this->locale . '.text_select');
        $data['text_enabled']          = lang($this->locale . '.text_enabled');
        $data['text_disabled']         = lang($this->locale . '.text_disabled');
        
        $data['entry_meta_keywords']   = lang('project/project.entry_meta_keywords');
        $data['entry_days_open']       = lang('project/project.entry_days_open');
        $data['entry_name']            = lang('project/project.entry_name');
        $data['entry_skills']          = lang('project/project.entry_skills');
        $data['entry_min']             = lang('project/project.entry_min');
        $data['entry_max']             = lang('project/project.entry_max');
        $data['entry_status']          = lang($this->locale . '.entry_status');
        $data['entry_delivery_time']   = lang('project/project.entry_delivery_time');
        $data['entry_run_time']        = lang('project/project.entry_run_time');
        $data['entry_upload']          = lang('project/project.entry_upload');
        $data['help_budget']           = lang('project/project.help_budget');
        $data['help_delivery']         = lang('project/project.help_delivery');
        $data['help_bidding_duration'] = lang('project/project.help_bidding_duration');
        $data['help_upload']           = lang('project/project.help_upload');
        $data['button_add']            = lang($this->locale . '.button_add');
        
        $data['button_save'] = !$this->request->getVar('project_id') ? lang('project/project.button_add') : lang('project/project.button_edit');
        
        if ($this->request->getVar('pid') && ($this->request->getMethod() != 'post')) {
            $project_info = $projectModel->getProject($this->request->getVar('project_id'));
        }

        if ($this->request->getPost('project_description')) {
            $data['project_description'] = $this->request->getPost('project_description');
        } elseif ($this->request->getVar('project_id')) {
            $data['project_description'] = $projectModel->getProjectDescription($this->request->getVar('project_id'));
        } else {
            $data['project_description'] = [];
        }

        // Employer
        $categoryModel = new CategoryModel;
        $data['categories'] = $categoryModel->getCategories();

        if ($this->request->getPost('category_id')) {
            $data['category_id'] = $this->request->getPost('category_id');
        } elseif (!empty($project_info['category_id'])) {
            $data['category_id'] = $projectModel->getCategoriesByProjectId($project_info['project_id']);
        } else {
            $data['category_id'] = [];
        }

        if ($this->request->getPost('budget_min')) {
            $data['budget_min'] = $this->request->getPost('budget_min');
        } elseif ($this->request->getVar('pid')) {
            $data['budget_min'] = round($project_info['budget_min']);
        } else {
            $data['budget_min'] = '';
        }

        if ($this->request->getPost('budget_max')) {
            $data['budget_max'] = $this->request->getPost('budget_max');
        } elseif ($this->request->getVar('pid')) {
            $data['budget_max'] = round($project_info['budget_max']);
        } else {
            $data['budget_max'] = '';
        }

        if ($this->request->getPost('type')) {
            $data['type'] = $this->request->getPost('type');
        } elseif ($this->request->getVar('pid')) {
            $data['type'] = $project_info['type'];
        } else {
            $data['type'] = 1;
        }

        if ($this->request->getPost('employer_id')) {
            $data['employer_id'] = $this->request->getPost('employer_id');
        } elseif ($this->request->getVar('pid')) {
            $data['employer_id'] = $project_info['employer_id'];
        } else {
            $data['employer_id'] = $this->customer->getCustomerId();
        }

        if ($this->request->getPost('delivery_time')) {
            $data['delivery_time'] = $this->request->getPost('delivery_time');
        } elseif ($this->request->getVar('pid')) {
            $data['delivery_time'] = $project_info['delivery_time'];
        } else {
            $data['delivery_time'] = '';
        }

        if ($this->request->getPost('runtime')) {
            $data['runtime'] = $this->request->getPost('runtime');
        } elseif ($this->request->getVar('pid')) {
            $data['runtime'] = $project_info['runtime'];
        } else {
            $data['runtime'] = 8;
        }

        if ($this->request->getPost('download_id')) {
            $data['download_id'] = $this->request->getPost('download_id');
        } else {
            $data['download_id'] = 0;
        }

        // upload extensions allowed
        $file_ext_allowed = preg_replace('~\r?\n~', "\n", $this->registry->get('config_file_ext_allowed'));

        $filetypes = explode("\n", $file_ext_allowed);
        
        foreach ($filetypes as $filetype) {
            $data['allowedFileExtensions'][] = trim($filetype);
        }

        $data['language_id'] = $this->registry->get('config_language_id');
        $data['config_currency'] = $this->session->get('currency') ?? $this->registry->get('config_currency');

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
                    'rules' => 'required'
                ],
                "budget_max" => [
                    'label' => 'Maximum Budget',
                    'rules' => 'required'
                ],
                ])) {
                return false;
            }
        }

        return true;
    }

    //--------------------------------------------------------------------
}
