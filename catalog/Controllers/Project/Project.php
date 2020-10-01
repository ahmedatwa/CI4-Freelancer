<?php namespace Catalog\Controllers\Project;

use \Catalog\Models\Catalog\ProjectModel;

class Project extends \Catalog\Controllers\BaseController
{
    public function add()
    {
        $this->template->setTitle(lang('account/dashboard.heading_title'));

        $projectModel = new ProjectModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            if (! $this->customer->isLogged()) {
             return redirect()->route('account/login');
            }  
            $projectModel->addProject($this->request->getPost());
            //return redirect()->to(base_url('projects'))
                            // ->with('success', lang('account/projects.text_success'));
        }

        $this->getForm();
    }

    public function index()
    {
        $projectModel = new ProjectModel();
        $seoUrl = service('seo_url');
        $categoryModel = new \Catalog\Models\Catalog\CategoryModel();


        if ($this->request->uri->getSegment(2)) {
            $keyword = $this->request->uri->getSegment(2);
        } else {
            $keyword = '';
        }

        if ($this->request->getVar('project_id')) {
            $project_id = $this->request->getVar('project_id');
        } else {
            $project_id = 0;
        }

        $this->template->setTitle($keyword .' | '. $this->registry->get('config_name'));

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => lang('project/project.text_projects'),
            'href' => route_to('projects'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $categoryModel->getCategoryByProjectId($project_id),
            'href' => base_url('projects?pid=' . $project_id),
        ];  

        $data['breadcrumbs'][] = [
            'text' => $keyword,
            'href' => route_to('project', $keyword),
        ];

        if ($this->customer->isLogged()) {
            $data['freelancer_id'] = $this->customer->getCustomerId();
        } else {
            $data['freelancer_id'] = 0;
        }

        $data['logged']          = $this->customer->isLogged();
        $data['config_currency'] = $this->registry->get('config_currency');
        $data['register']        = route_to('account/register');
        $data['add_project']  = base_url('project/project/add');
        
        if ($project_id) {
            $project_info = $projectModel->getProject($project_id);
        }
        
        if ($project_info) {
            $reviewModel = new \Catalog\Models\Catalog\ReviewModel();

            $data['project_id']  = $project_info['project_id'];
            $data['name']        = $project_info['name'];
            $data['budget']      = $this->currencyFormat($project_info['budget_min']) . ' - ' . $this->currencyFormat($project_info['budget_max']);
            $data['description'] = $project_info['description'];
            $data['categories']  = $categoryModel->getCategoriesByProjectId($project_id);
            $data['days_left']   = lang('project/project.text_expire', [getDaysLeft($project_info['date_added'])]);
            $data['rating']      = round($reviewModel->getAvgReviewByEmployerId($project_info['employer_id']));
            $data['employer']    = $project_info['employer'];
            $data['employer_id'] = $project_info['employer_id'];
        } else {
            $data['project_id']  = '';
            $data['name']        = '';
            $data['budget']      = '';
            $data['description'] = '';
            $data['categories']      = '';
            $data['days_left']   = '';
            $data['rating']      = '';
            $data['employer']    = '';
            $data['employer_id'] = '';
        }

        $data['text_about']       = lang('project/project.text_about');
        $data['text_budget']      = lang('project/project.text_budget');
        $data['text_description'] = lang('project/project.text_description');
        $data['text_attachments'] = lang('project/project.text_attachments');
        $data['text_skills']      = lang('project/project.text_skills');
        $data['text_bid']         = lang('project/project.text_bid');
        $data['text_rate']        = lang('project/project.text_rate');
        $data['text_delivery']    = lang('project/project.text_delivery');
        $data['text_register']    = lang('common/header.text_register');
        $data['text_facebook']    = lang('en.text_facebook');
        $data['text_twitter']     = lang('en.text_twitter');
        $data['text_gplus']       = lang('en.text_gplus');
        

        $projectModel->updateViewed($project_id);

        $this->template->output('project/project', $data);
    }
    
    public function getForm()
    {
        $projectModel = new ProjectModel();

        $this->template->setTitle($this->registry->get('config_name'));

        $data['text_form'] = !$this->request->getVar('project_id') ? lang('account/projects.button_add') : lang('account/projects.button_edit');

        $data['breadcrumbs'] = [];
        $data['breadcrumbs'][] = [
            'text' => lang($this->locale . '.text_home'),
            'href' => base_url(),
        ];

        $data['breadcrumbs'][] = [
            'text' => $data['text_form'],
            'href' => route_to('add-project'),
        ];

       
        $data['action'] = base_url('project/project/add');
        

        if ($this->session->getFlashdata('error_warning')) {
            $data['error_warning'] = $this->session->getFlashdata('error_warning');
        } else {
            $data['error_warning'] = '';
        }

        $data['heading_title'] = lang('account/projects.heading_title');
        $data['text_tell_us'] = lang('account/projects.text_tell_us');
        $data['text_sub'] = lang('account/projects.text_sub');
        
        $data['text_estimate']        = lang('account/projects.text_estimate');
        $data['text_fixed_price']     = lang('account/projects.text_fixed_price');
        $data['text_per_hour']        = lang('account/projects.text_per_hour');
        $data['entry_description']    = lang('account/projects.entry_description');
        $data['text_type']            = lang('account/projects.text_type');
        $data['text_select']          = lang('en.text_select');
        $data['text_enabled']         = lang('en.text_enabled');
        $data['text_disabled']        = lang('en.text_disabled');
        
        $data['entry_meta_keywords']  = lang('account/projects.entry_meta_keywords');
        $data['entry_days_open']       = lang('account/projects.entry_days_open');
        $data['entry_name']           = lang('account/projects.entry_name');
        $data['entry_category']       = lang('account/projects.entry_category');
        $data['entry_min']            = lang('account/projects.entry_min');
        $data['entry_max']            = lang('account/projects.entry_max');
        $data['entry_status']         = lang('en.entry_status');
        $data['button_add']           = lang('en.button_add');

        $data['button_save']           = !$this->request->getVar('project_id') ? lang('account/projects.button_add') : lang('account/projects.button_edit');
        $data['help_date_end']        = lang('account/projects.help_date_end');
        
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

        if ($this->request->getPost('runtime')) {
            $data['runtime'] = $this->request->getPost('runtime');
        } elseif ($this->request->getVar('project_id')) {
            $data['runtime'] = $project_info['runtime'];
        } else {
            $data['runtime'] = 3;
        }

        $data['language_id'] = $this->registry->get('config_language_id');

        $this->template->output('project/project_form', $data);
    }

    protected function validateForm()
    {

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
                $this->session->setFlashdata('error_warning', lang('account/projects.text_warning'));
                return false;
           }
       }

        return true;
    }
    //--------------------------------------------------------------------
}
