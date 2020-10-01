<?php namespace Catalog\Controllers\Account;

use Catalog\Models\Catalog\ProjectModel;

class Review extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        
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
            'sortBy'      => 'p.date_added',
            'orderBy'     => 'DESC',
            'limit'       => $limit,
            'status'      => $this->registry->get('config_project_completed_status'),
            'start'       => ($page - 1) * $limit,
        ];
    
        $data['projects'] = [];
        
        $results = $projectModel->getProjectAward($filter_data);
        //$total = $reviewModel->getTotalReviews();

        foreach ($results as $result) {
            $data['projects'][] = [
                'project_id'  => $result['project_id'],
                'name'        => $result['name'],
                'status'      => $result['status'],
                'employer'    => $result['employer_id'],
                'freelancer'  => $result['freelancer_id'],
                'edit' => ''
            ];
        }

        //var_dump($data['reviews']);


        $data['heading_title']     = lang('account/review.heading_title');
        $data['column_name']       = lang('account/review.column_name');
        $data['column_employer']   = lang('account/review.column_employer');
        $data['column_status']     = lang('account/review.column_status');
        $data['column_action']     = lang('account/review.column_action');
        $data['column_freelancer'] = lang('account/review.column_freelancer');
        $data['button_edit']                  = lang('account/review.button_edit');
        $data['']                  = lang('account/review.heading_title');
        $data['']                  = lang('account/review.heading_title');
        $data['']                  = lang('account/review.heading_title');

        $data['dashboard_menu'] = view_cell('Catalog\Controllers\Account\Menu::index');

        $this->template->output('account/review', $data);
    }
    //--------------------------------------------------------------------
}
