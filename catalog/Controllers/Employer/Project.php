<?php namespace Catalog\Controllers\Employer;

use \Catalog\Models\Catalog\ProjectModel;

class Project extends \Catalog\Controllers\BaseController
{
    public function add()
    {
        $this->template->setTitle(lang('employer/project.heading_title'));

        $projectModel = new ProjectModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $projectModel->addProject($this->request->getPost());
            return redirect()->to(base_url('account/project?customer_id' . $this->customer->getCustomerId()))
                             ->with('success', lang('employer/project.text_success'));
        }
        $this->getForm();
    }

    public function edit()
    {
        $this->template->setTitle(lang('employer/project.heading_title'));

        $projectModel = new ProjectModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $projectModel->editProject($this->request->getVar('project_id'), $this->request->getPost());
            return redirect()->to(base_url('account/project?customer_id' . $this->customer->getCustomerId()))
                             ->with('success', lang('employer/project.text_success'));
        }
        $this->getForm();
    }

    public function index()
    {
        $projectModel = new ProjectModel();

        $this->template->setTitle(lang('employer/project.heading_title'));
            
        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('account/dashboard.heading_title'),
            'href' => base_url('account/dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('employer/project.heading_title'),
            'href' => base_url('account/project'),
        ];

        if ($this->customer->getCustomerId()) {
            $employer_id = $this->customer->getCustomerId();
        } else {
            $employer_id = 0;
        }
        
        if ($this->request->getVar('sort_by')) {
            $sortBy = $this->request->getVar('sort_by');
        } else {
            $sortBy = 'p.date_added';
        }

        if ($this->request->getVar('order_by')) {
            $orderBy = $this->request->getVar('order_by');
        } else {
            $orderBy = 'DESC';
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 20;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $url = '';

        if ($this->request->getVar('limit')) {
            $url .= '&limit=' . $this->request->getVar('limit');
        }

        if ($this->request->getVar('sort_by')) {
            $url .= '&sort_by=' . $this->request->getVar('sort_by');
        }

        if ($this->request->getVar('order_by')) {
            $url .= '&order_by=' . $this->request->getVar('order_by');
        }

        $filter_data = [
            'sortBy'  => 'p.date_added',
            'orderBy' => 'DESC',
            'limit'   => $limit,
            'employer_id'   => $employer_id,
            'start'   => ($page - 1) * $limit,
        ];
    
        $data['projects'] = [];
        
        $results = $projectModel->getEmployerProjects($filter_data);
        $projects_total = $projectModel->getTotalProjects();

        foreach ($results as $result) {
            if ($result['type'] == 1) {
                $type = lang('employer/project.text_fixed_price');
            } else {
                 $type = lang('employer/project.text_per_hour');
            }

            $data['projects'][] = [
                'project_id' => $result['project_id'],
                'name'       => $result['name'],
                'budget'     => sprintf(lang('employer/project.text_budget'), $this->currencyFormat($result['budget_min']) . '-' . $this->currencyFormat($result['budget_max']), $type),
                'date_added' => $this->dateDifference($result['date_added']),
                'total_bids' => sprintf(lang('employer/project.text_total_bids'), $projectModel->getTotalBidsByProjectId($result['project_id'])),
                'days_left'  => $result['runtime'],
                'avgBids'    => sprintf(lang('employer/project.text_average_bids'), $projectModel->getAverageBidsByPorjectId($result['project_id'])),
                'status'     => $result['status'],
                'expired'    => ($result['runtime']) ? lang('en.text_expired') : '',
                'disable'    => $projectModel->disableProject($result['project_id']),
                'enable'     => $projectModel->enableProject($result['project_id']),
                'edit'       => base_url('employer/project/edit?project_id=' . $result['project_id'] . '&customer_id=' . $this->customer->getCustomerId()),
                'bidders'    => base_url('employer/project/bidders?project_id=' . $result['project_id'] . '&customer_id=' . $this->customer->getCustomerId()),
            ];
        }

        $data['sorts'] = [];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_newest'),
            'value' => 'p.date_added-ASC',
            'href'  => base_url('account/project') . '?sort_by=p.date_added&order_by=desc'
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_lowest'),
            'value' => 's.price-DESC',
            'href'  => base_url('account/project?category_id=' . $this->request->getVar('category_id') . '&sort_by=s.price&order_by=DESC' .$url)
        ];

        $data['sorts'][] = [
            'text'  => lang('common/search.text_highest'),
            'value' => 's.price-DESC',
            'href'  => base_url('account/project?category_id=' . $this->request->getVar('category_id') . '&sort_by=s.price&order_by=DESC' .$url)
        ];

        $data['categories'] = [];
        $categoryModel = new \Catalog\Models\Catalog\CategoryModel;
        $categories = $categoryModel->getCategories();
        foreach ($categories as $category) {
            $data['categories'][] = [
                'category_id'   => $category['category_id'],
                'name' => $category['name']
            ];
        }

        $data['heading_title'] = lang('employer/project.heading_title');
        $data['text_projects'] = lang('employer/project.text_projects');
        $data['button_add']    = lang('employer/project.button_add');
        $data['text_manage_bidders']    = lang('employer/project.text_manage_bidders');

        $data['add_project']    = base_url('account/manage/project/add?customer_id=' . $this->customer->getCustomerId());

        $data['sort_by']  = $sortBy;
        $data['order_by'] = $orderBy;
        $data['limit']    = $limit;
        $data['page']     = $page;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $projects_total);

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');


        $this->template->output('employer/project_list', $data);
    }

    public function getForm()
    {
        $projectModel = new ProjectModel();

        $this->template->setTitle($this->registry->get('config_name'));

        $data['text_form'] = !$this->request->getVar('project_id') ? lang('employer/project.button_add') : lang('employer/project.button_edit');

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('employer/project.heading_title'),
            'href' => base_url('account/dashboard'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $data['text_form'],
            'href' => base_url('account/project?project_id=' . $this->request->getVar('project_id')),
        ];

        if (!$this->request->getVar('project_id')) {
            $data['action'] = base_url('account/dashboard/project/add');
        } else {
            $data['action'] = base_url('account/dashboard/project/edit?project_id=' . $this->request->getVar('project_id'));
        }

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $data['heading_title'] = lang('employer/project.heading_title');
        
        $data['text_tell_us']      = lang('employer/project.text_tell_us');
        $data['text_sub']      = lang('employer/project.text_sub');
        $data['text_estimate']        = lang('employer/project.text_estimate');
        $data['text_fixed_price']     = lang('employer/project.text_fixed_price');
        $data['text_per_hour']        = lang('employer/project.text_per_hour');
        $data['text_required_skills'] = lang('employer/project.text_required_skills');
        $data['text_describe']        = lang('employer/project.text_describe');
        $data['text_type']            = lang('employer/project.text_type');
        $data['text_select']          = lang('en.text_select');
        $data['text_enabled']         = lang('en.text_enabled');
        $data['text_disabled']        = lang('en.text_disabled');
        
        $data['entry_description']  = lang('employer/project.entry_description');
        $data['entry_days_open']       = lang('employer/project.entry_days_open');
        $data['entry_name']           = lang('employer/project.entry_name');
        $data['entry_category']       = lang('employer/project.entry_category');
        $data['entry_min']            = lang('employer/project.entry_min');
        $data['entry_max']            = lang('employer/project.entry_max');
        $data['entry_status']         = lang('en.entry_status');
        $data['button_add']           = lang('en.button_add');

        $data['button_save']           = !$this->request->getVar('project_id') ? lang('employer/project.button_add') : lang('employer/project.button_edit');
        $data['help_date_end']        = lang('employer/project.help_date_end');
        
        if ($this->request->getVar('project_id') && ($this->request->getMethod() != 'post')) {
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
        $categoryModel = new \Catalog\Models\Catalog\CategoryModel;
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
        } elseif ($this->request->getVar('project_id')) {
            $data['budget_min'] = round($project_info['budget_min']);
        } else {
            $data['budget_min'] = 0;
        }

        if ($this->request->getPost('budget_max')) {
            $data['budget_max'] = $this->request->getPost('budget_max');
        } elseif ($this->request->getVar('project_id')) {
            $data['budget_max'] = round($project_info['budget_max']);
        } else {
            $data['budget_max'] = 0;
        }

        if ($this->request->getPost('type')) {
            $data['type'] = $this->request->getPost('type');
        } elseif ($this->request->getVar('project_id')) {
            $data['type'] = $project_info['type'];
        } else {
            $data['type'] = 0;
        }

        if ($this->request->getPost('employer_id')) {
            $data['employer_id'] = $this->request->getPost('employer_id');
        } elseif ($this->request->getVar('project_id')) {
            $data['employer_id'] = $project_info['employer_id'];
        } else {
            $data['employer_id'] = 0;
        }

        if ($this->request->getPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif ($this->request->getVar('project_id')) {
            $data['status'] = $project_info['status'];
        } else {
            $data['status'] = 1;
        }
        $data['employer_id'] = $this->customer->getCustomerId();
        $data['language_id'] = $this->registry->get('config_language_id');

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('employer/project_form', $data);
    }

    public function getBidders()
    {
        if ($this->request->getVar('project_id')) {
            $project_id = $this->request->getVar('project_id');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('limit')) {
            $limit = $this->request->getVar('limit');
        } else {
            $limit = 20;
        }

        if ($this->request->getVar('page')) {
            $page = $this->request->getVar('page');
        } else {
            $page = 1;
        }

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('employer/project.heading_title'),
            'href' => base_url('account/dashboard?customer_id=' . $this->request->getVar('customer_id')),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('employer/project.text_manage_bidders'),
            'href' => base_url('account/dashboard/project?project_id=' . $this->request->getVar('project_id') . '&customer_id=' . $this->request->getVar('customer_id')),
        ];

        $filter_data = [
            'orderBy'    => 'p.date_added',
            'sortBy'     => 'DESC',
            'project_id' => $project_id,
            'limit'      => $limit,
            'start'      => ($page - 1) * $limit,
         ];

        if ($project_id) {
            $projectModel = new ProjectModel();
            $project_info = $projectModel->getProject($project_id);
        }

        $data['name'] = $project_info['name'];
        $data['href'] = route_to('project', getKeywordByQuery('project_id=' . $project_id));
         
        $bidModel = new \Catalog\Models\Extension\Bid\BidModel();

        $data['bidders'] = [];

        $results = $bidModel->getBids($filter_data);
        $total = $bidModel->getTotalBidsByProjectId($project_id);
        $reviewModel = new \Catalog\Models\Catalog\ReviewModel();
        foreach ($results as $result) {
            $data['bidders'][] = [
                'bid_id'     => $result['bid_id'],
                'freelancer' => $result['freelancer'],
                'email'      => $result['email'],
                'price'      => $this->currencyFormat($result['price']),
                'delivery'   => $result['delivery'] . ' ' . lang($this->locale . '.text_days'),
                'status'     => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'profile'    => route_to('freelancers/profile', $result['customer_id']),
                'type'        => ($result['status'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'image'      => ($result['image']) ? $this->resize($result['image'], 80, 80) : $this->resize('catalog/avatar.jpg', 80, 80),
                'rating'     => $reviewModel->getAvgReviewByFreelancerId($result['freelancer_id'])
            ];
        }

        $data['heading_title'] = lang('employer/project.text_manage_bidders');
        $data['text_total_bidders'] = sprintf(lang('employer/project.text_total_bidders'), $total);

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $total);

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/project_bidders', $data);

    }    
    public function autocomplete()
    {
        $json = [];

        if ($this->request->getVar('filter_skill')) {

            if ($this->request->getVar('filter_skill')) {
                $filter_skill = $this->request->getVar('filter_skill');
            } else {
                $filter_skill = '';
            }

            $filter_data = [
              'filter_skill' => $filter_skill,
              'start'        => 0,
              'limit'        => 5
            ];

            $projectModel = new ProjectModel();
            $results = $projectModel->getSkills($filter_data);
            foreach ($results as $result) {
                $json[] = [
                    'skill_id' => $result['skill_id'],
                    'text'     => $result['text']
                ];
            }

       }
        return $this->response->setJSON($json);
    }

    protected function validateForm()
    {
        if (! $this->customer->isLogged()) {
            return redirect()->to(route_to('common/login'));
            return false;
        }

       foreach ($this->request->getPost('project_description') as $language_id => $value) {
            if (! $this->validate([
                    "project_description.{$language_id}.name" => [
                    'label' => 'Project Name',
                    'rules' => 'required|min_length[3]|max_length[64]'
                ],
                "project_description.{$language_id}.description" => [
                    'label' => 'Project Description',
                    'rules' => 'required|min_length[3]'
                ],
                ])) {
                $this->session->setFlashdata('error_warning', lang('employer/project.text_warning'));
                return false;
           }
       }

        return true;
    }
    //--------------------------------------------------------------------
}
