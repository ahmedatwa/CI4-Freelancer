<?php namespace Catalog\Controllers\Project;

use \Catalog\Models\Catalog\ProjectModel;

class Project extends \Catalog\Controllers\BaseController
{
    public function add()
    {
        $this->template->setTitle(lang('account/dashboard.heading_title'));

        $projectModel = new ProjectModel();

        if (($this->request->getMethod() == 'post') && $this->validateForm()) {
            $projectModel->addProject($this->request->getPost());
            $this->session->setFlashdata('new_project_add', lang('project/project.text_success'));
            return redirect()->to(base_url('project/project/add'))->with('success', lang('project/project.text_success'));
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

        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } elseif ($this->request->getGet('project_id')) {
            $project_id = $this->request->getGet('project_id');
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
            'href' => route_to('projects') ? route_to('projects') : base_url('project/category'),
        ];

        $data['breadcrumbs'][] = [
            'text' => $categoryModel->getCategoryByProjectId($project_id),
            'href' => route_to('categories') ?? base_url('projects?pid=' . $project_id),
        ];

        $data['breadcrumbs'][] = [
            'text' => $keyword,
            'href' => route_to('project', $keyword) ?? base_url('project/project?pid=' . $project_id),
        ];

        if ($this->customer->isLogged()) {
            $data['freelancer_id'] = $this->customer->getCustomerId();
        } else {
            $data['freelancer_id'] = 0;
        }

        $data['logged']          = $this->customer->isLogged();
        $data['config_currency'] = $this->session->get('currency') ?? $this->registry->get('config_currency');
        $data['register']        = route_to('register') ?? base_url('acocunt/register');
        $data['add_project']     = base_url('project/project/add');
        
        if ($project_id) {
            $project_info = $projectModel->getProject($project_id);
        } else {
            $project_info = [];
        }


        if ($project_info) {
            $reviewModel = new \Catalog\Models\Catalog\ReviewModel();

            $data['project_id']  = $project_info['project_id'];
            $data['name']        = $project_info['name'];
            $data['budget']      = $this->currencyFormat($project_info['budget_min']) . ' - ' . $this->currencyFormat($project_info['budget_max']);
            $data['description'] = $project_info['description'];
            $data['categories']  = $categoryModel->getCategoriesByProjectId($project_id);
            $data['viewed']      = $project_info['viewed'];
            $data['days_left']   = lang('project/project.text_expire', [$this->dateDifference($project_info['date_added'], $project_info['runtime'])]);
            $data['rating']      = round($reviewModel->getAvgReviewByEmployerId($project_info['employer_id']));
            $data['employer']    = $project_info['employer'];
            $data['employer_id'] = $project_info['employer_id'];
            $data['status'] = $projectModel->getStatusByProjectId($project_info['project_id']);
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

       
        $data['action'] = base_url('project/project/add');

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
        $data['text_select']           = lang('en.text_select');
        $data['text_enabled']          = lang('en.text_enabled');
        $data['text_disabled']         = lang('en.text_disabled');
        
        $data['entry_meta_keywords']   = lang('project/project.entry_meta_keywords');
        $data['entry_days_open']       = lang('project/project.entry_days_open');
        $data['entry_name']            = lang('project/project.entry_name');
        $data['entry_category']        = lang('project/project.entry_category');
        $data['entry_min']             = lang('project/project.entry_min');
        $data['entry_max']             = lang('project/project.entry_max');
        $data['entry_status']          = lang('en.entry_status');
        $data['entry_delivery_time']   = lang('project/project.entry_delivery_time');
        $data['entry_run_time']        = lang('project/project.entry_run_time');
        $data['entry_upload']          = lang('project/project.entry_upload');
        $data['help_budget']           = lang('project/project.help_budget');
        $data['help_delivery']         = lang('project/project.help_delivery');
        $data['help_bidding_duration'] = lang('project/project.help_bidding_duration');
        $data['help_upload']           = lang('project/project.help_upload');
        $data['button_add']            = lang('en.button_add');
        
        $data['button_save']         = !$this->request->getVar('project_id') ? lang('project/project.button_add') : lang('project/project.button_edit');
        
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
        } elseif ($this->request->getVar('pid')) {
            $data['budget_min'] = round($project_info['budget_min']);
        } else {
            $data['budget_min'] = 0;
        }

        if ($this->request->getPost('budget_max')) {
            $data['budget_max'] = $this->request->getPost('budget_max');
        } elseif ($this->request->getVar('pid')) {
            $data['budget_max'] = round($project_info['budget_max']);
        } else {
            $data['budget_max'] = 0;
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
            $data['delivery_time'] = 0;
        }

        if ($this->request->getPost('runtime')) {
            $data['runtime'] = $this->request->getPost('runtime');
        } elseif ($this->request->getVar('pid')) {
            $data['delivery_time'] = $project_info['runtime'];
        } else {
            $data['runtime'] = 3;
        }

        if ($this->request->getFile('file_upload')) {
            $data['file_upload'] = $this->request->getFile('file_upload');
        } else {
            $data['file_upload'] = '';
        }


        $data['language_id'] = $this->registry->get('config_language_id');
        $data['config_currency'] = $this->session->get('currency') ?? $this->registry->get('config_currency');

        $this->template->output('project/project_form', $data);
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
                "runtime" => [
                    'label' => 'Bidding Duration',
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
