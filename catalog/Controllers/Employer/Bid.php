<?php

namespace Catalog\Controllers\Employer;

use Catalog\Controllers\BaseController;
use Catalog\Models\Employer\EmployerModel;
use Catalog\Models\Extension\Bid\BidModel;
use Catalog\Models\Account\ReviewModel;

class Bid extends BaseController
{
    public function index()
    {
        if ($this->request->getVar('pid')) {
            $project_id = $this->request->getVar('pid');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('customer_id')) {
            $customer_id = $this->request->getVar('customer_id');
        } elseif ($this->session->get('customer_id')) {
            $customer_id = $this->session->get('customer_id');
        } else {
            $customer_id = 0;
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
            'text' => lang('project/project.text_manage_bidders'),
            'href' => route_to('account_dashboard'),
        ];

        $filter_data = [
            'orderBy'       => 'p.date_added',
            'sortBy'        => 'DESC',
            'project_id'    => $project_id,
            'limit'         => $limit,
            'start'         => ($page - 1) * $limit,
         ];

        if ($project_id) {
            $employerModel = new EmployerModel();
            $project_info = $employerModel->getEmployerProject($project_id);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['name'] = $project_info['name'];
        $data['href'] = base_url('employer/project&pid=' . $project_id);
         
        $bidModel = new BidModel();

        $data['bidders'] = [];

        $results = $bidModel->getBids($filter_data);
        $total = $bidModel->getTotalBidsByProjectId($project_id);
        $reviewModel = new ReviewModel();

        foreach ($results as $result) {
            $data['bidders'][] = [
                'bid_id'        => $result['bid_id'],
                'freelancer_id' => $result['freelancer_id'],
                'freelancer'    => $result['username'],
                'email'         => $result['email'],
                'description'   => nl2br($result['description']),
                'price'         => $this->currencyFormat($result['quote']),
                'delivery'      => $result['delivery'] . ' ' . lang($this->locale . '.text_days'),
                'status'        => ($result['status']) ? lang('en.list.text_enabled') : lang('en.list.text_disabled'),
                'type'          => ($result['status'] == 1) ? lang('project/project.list.text_fixed_price') : lang('project/project.list.text_per_hour'),
                'image'         => ($result['image']) ? $this->resize($result['image'], 80, 80) : $this->resize('catalog/avatar.jpg', 80, 80),
                'rating'        => $reviewModel->getAvgReviewByFreelancerId($result['freelancer_id']),
                'isSelected'    => $bidModel->isAwarded($result['freelancer_id'], $result['project_id']),
                'profile'       => route_to('freelancer_profile', $result['freelancer_id'], $result['username'])
            ];
        }

        $data['customer_id'] = $customer_id;
        $data['project_id'] = $project_id;

        // Pagination
        $pager = \Config\Services::pager();
        $data['pagination'] = $pager->makeLinks($page, $limit, $total);

        $data['langData'] = lang('employer/bid.list');

        return view('employer/bids_list', $data);
    }

    // Award Freelancer
    public function awardWinner()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && $this->request->getVar('pid')) {
            $employerModel = new EmployerModel();

            $employerModel->addWinner($this->request->getPost());

            $json['success'] = lang('employer/bid.text_success_winner');
        }

        return $this->response->setJSON($json);
    }
    //--------------------------------------------------------------------
}
