<?php namespace Catalog\Controllers\Account;

use \Catalog\Models\Catalog\ProjectModel;
use \Catalog\Models\Account\ReviewModel;
use \Catalog\Models\Account\CustomerModel;

class Review extends \Catalog\Controllers\BaseController
{
    public function add()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && $this->request->getVar('project_id')) {
            $reviewModel = new ReviewModel();
            $data = [
                'project_id'    => $this->request->getVar('project_id'),
                'freelancer_id' => $this->request->getVar('freelancer_id'),
                'employer_id'   => $this->request->getVar('employer_id'),
                'ontime'        => $this->request->getPost('ontime'),
                'recommended'   => $this->request->getPost('recommended'),
                'rating'        => $this->request->getPost('rating'),
                'comment'       => $this->request->getPost('comment'),
                'submitted_by'  => $this->session->get('customer_id'),
                'status'        => 1,
            ];

            $reviewModel->insert($data);
            $json['success'] = lang('account/review.text_success');
        }

        return $this->response->setJSON($json);
    }

    public function index()
    {
        if (! $this->session->get('customer_id') && ! $this->customer->isLogged() ) {
             return redirect('account_login');
        }

        $this->template->setTitle(lang('account/review.heading_title'));

        $projectModel = new ProjectModel();
            
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
            'text' => lang('account/review.heading_title'),
            'href' => base_url('account/review'),
        ];

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
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
            'customer_id' => $customer_id,
            'sortBy'      => 'p.date_added',
            'orderBy'     => 'DESC',
            'limit'       => $limit,
            'status'      => $this->registry->get('config_project_completed_status'),
            'start'       => ($page - 1) * $limit,
        ];
    
        $data['projects'] = [];
        
        $results = $projectModel->getProjectAward($filter_data);

        $customerModel = new CustomerModel();
        //$total = $reviewModel->getTotalReviews();

        foreach ($results as $result) {
            $employer = $customerModel->getCustomer($result['employer_id']);
            $freelancer = $customerModel->getCustomer($result['freelancer_id']);
            $data['projects'][] = [
                'project_id'    => $result['project_id'],
                'freelancer_id' => $result['freelancer_id'],
                'employer_id'   => $result['employer_id'],
                'name'          => $result['name'],
                'status'        => $result['status_name'],
                'employer'      => $employer['firstname'] . ' ' . $employer['lastname'],
                'freelancer'    => $freelancer['firstname'] . ' ' . $freelancer['lastname'],
                'edit' => ''
            ];
        }

        $data['heading_title']     = lang('account/review.heading_title');
        $data['column_name']       = lang('account/review.column_name');
        $data['column_employer']   = lang('account/review.column_employer');
        $data['column_status']     = lang('account/review.column_status');
        $data['column_action']     = lang('account/review.column_action');
        $data['column_freelancer'] = lang('account/review.column_freelancer');
        $data['button_edit']       = lang($this->locale . '.button_edit');
        $data['text_no_results']   = lang($this->locale . '.text_no_results');

        $data['customer_id'] = $customer_id;

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/review', $data);
    }
    //--------------------------------------------------------------------
}
