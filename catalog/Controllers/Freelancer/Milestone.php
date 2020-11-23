<?php namespace Catalog\Controllers\Freelancer;

use \Catalog\Models\Freelancer\MilestoneModel;
use \Catalog\Models\Freelancer\BalanceModel;
use \Catalog\Models\Extension\Bid\BidModel;
use \Catalog\Models\Catalog\ProjectModel;

class Milestone extends \Catalog\Controllers\BaseController
{
    public function index()
    {
        if ($this->request->getVar('project_id')) {
            $project_id = $this->request->getVar('project_id');
        } else {
            $project_id = 0;
        }

        if ($this->request->getVar('cid')) {
            $customer_id = $this->request->getVar('cid');
        } elseif ($this->customer->getCustomerId()) {
            $customer_id = $this->customer->getCustomerId();
        } else {
            $customer_id = 0;
        }

        $milestoneModel = new MilestoneModel();
         
        $data['project_milestones'] = [];

        $results = $milestoneModel->where('project_id', $project_id)->findAll();

        foreach ($results as $result) {
            switch ($result['status']) {
                case 0: $status = 'Pending'; break;
                case 1: $status = 'Approved'; break;
                case 2: $status = 'Paid'; break;
                case 3: $status = 'Canceled'; break;
                default: $status = 'Pending'; break;
            }

            $data['project_milestones'][] = [
                'milestone_id' => $result['milestone_id'],
                'created_by'   => $result['created_by'],
                'project_id'   => $result['project_id'],
                'amount'       => number_format($result['amount'], 2),
                'description'  => $result['description'],
                'status'       => $status,
                'date_added'   => lang('en.longDate', [strtotime($result['date_added'])]),
                'deadline'     => lang('en.longDate', [strtotime($this->addDays($result['date_added'], $result['deadline']))]),
            ];
        }

        $bidModel = new BidModel();
        $projectModel = new ProjectModel();

        $bid_info = $bidModel->getBidByProjectId($project_id);

        $data['bid_quote']     = $bid_info['quote'];
        $data['employer_id']   = $bid_info['employer_id'];
        $data['freelancer_id'] = $bid_info['freelancer_id'];
        $data['project_id']    = $bid_info['project_id'];
        
        if ($project_id) {
            $project_info = $projectModel->getProject($project_id);
        }

        if ($bid_info['freelancer_id'] == $customer_id) {
            $data['created_for'] = $project_info['employer_id'];
        } else {
            $data['created_for'] = $bid_info['freelancer_id'];
        }

        $data['customer_id'] = $this->customer->getCustomerId();

        $data['heading_title'] = lang('project/project.text_manage_bidders');

        return view('freelancer/milestone', $data);
    }

    public function addMilestone()
    {
        $json = [];

        if ($this->request->getMethod() == 'post' && $this->request->getVar('pid')) {
            $milestoneModel = new MilestoneModel();

            $milestoneModel->insert($this->request->getPost());

            $json['success'] = lang('freelancer/project.text_success_milestone');
        }

        return $this->response->setJSON($json);
    }

    public function approveMilestone()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $milestoneModel = new MilestoneModel();

            $data = [
            'status' => 1
            ];

            $milestoneModel->update($this->request->getPost('milestone_id'), $data);

            $json['success'] = 'Milestone has been approved!';
        }

        return $this->response->setJSON($json);
    }

    public function cancelMilestone()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            $milestoneModel = new MilestoneModel();
            
            $data = [
             'status' => 3
            ];

            $milestoneModel->update($this->request->getPost('milestone_id'), $data);

            $json['success'] = 'Milestone has been canceled!';
        }

        return $this->response->setJSON($json);
    }

    public function payMilestone()
    {
        $json = [];

        if ($this->request->getMethod() == 'post') {
            if ($this->request->getPost('milestone_id')) {
                $milestone_id = $this->request->getPost('milestone_id');
            } else {
                $milestone_id = 0;
            }

            $milestoneModel = new MilestoneModel();

            $milestone_info = $milestoneModel->find($milestone_id);

            $data = [
             'status' => 2
            ];

            $milestoneModel->update($milestone_id, $data);
            // update customer balance
            $balanceModel = new BalanceModel();

            if ($this->request->getPost('freelancer_id') && $this->request->getPost('employer_id')) {
                $balanceModel->payMilestone($this->request->getPost(), $milestone_info['project_id']);
            }
            
            $json['success'] = 'Milestone has been been paid!';
        }

        return $this->response->setJSON($json);
    }

    //--------------------------------------------------------------------
}
