<?php

namespace Catalog\Events;

use Catalog\Models\Account\ActivityModel;
use Catalog\Libraries\Customer;
use Catalog\Models\Account\CustomerModel;
use Catalog\Models\Freelancer\MilestoneModel;

class ActivityEvent
{
    public static function projectAdd(array $data = [])
    {
        if ($data) {
            $activityModel = new ActivityModel();
            $activity_data = [
                'customer_id' => $data['employer_id'],
                'name'        => $data['name'],
                'budget'      => $data['budget'],
                'href'        => $data['href']
            ];
            $activityModel->addActivity('project_add', $activity_data);
        }
    }

    // Catalog\Controllers\Account\Login::authLogin
    public static function customerLogin(int $customer_id, string $username)
    {
        $activityModel = new ActivityModel();
        /**
        * @register Admin event.
        * @var data array
        */
        $activity_data = [
            'customer_id' => $customer_id,
            'username'    => $username,
        ];

        $activityModel->addActivity('admin_customer_login', $activity_data);
        /**
        * @register system event for suspecious login from differnt IP.
        * if IP doesn't match send email to customer.
        */
        $activityModel->AddCustomerIP(['customer_id' => $customer_id]);
    }

    // Catalog\Models\Account\CustomerModel::update
    public static function customerUpdate(int $customer_id)
    {
        $activityModel = new ActivityModel();
        $activity_data = [
            'customer_id' => $customer_id,
        ];

        $activityModel->addActivity('customer_update', $activity_data);
    }

    /*
    * For Admin Visibility Only.
    * @trigger Catalog\Model\Account\CustomerModel::addCustomer
    */
    public static function addCustomer(int $customer_id, string $username)
    {
        $activityModel = new ActivityModel();
        $activity_data = [
            'customer_id' => $customer_id,
            'username'    => $username,
        ];

        $activityModel->addActivity('admin_customer_register', $activity_data);
    }

    // Catalog\Models\Freelancer\Withdraw::addRequest
    public static function customerActivityWithdraw(int $customer_id, float $amount)
    {
        $activityModel = new ActivityModel;

        $activity_data = [
            'customer_id' => $customer_id,
            'amount'      => $amount,
        ];

        $activityModel->addActivity('customer_withdraw', $activity_data);
    }

    // Catalog\Models\Freelancer\FreelancerModel::addRequest
    public static function transferFunds(array $data)
    {
        $activityModel = new ActivityModel;

        $activity_data = [
            'employer_id'   => (int) $data['employer_id'],
            'customer_id'   => (int) $data['freelancer_id'],
            'project_id'    => (int) $data['project_id'],
            'amount'        => (float) $data['amount'],
        ];

        $activityModel->addActivity('customer_transfer_funds', $activity_data);
    }

    public static function addBid(array $data)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id'   => (int) $data['employer_id'],
            'project_id'    => (int) $data['project_id'],
            'freelancer_id' => (int) $data['freelancer_id'],
            'url'           => base_url('employer/project/view?pid=' . $data['project_id'] .'&cid=' . $data['employer_id'])
        ];

        $activityModel->addActivity('project_bid_add', $activity_data);
    }

    // Catalog\Models\Project\ProjectModel::addWinner
    public static function addWinner(array $data)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id' => $data['freelancer_id'],
            'project_id'  => $data['project_id'],
            'url'         =>  route_to('account_project') . '#freelancer',
        ];

        $activityModel->addActivity('project_offer_selected', $activity_data);
    }

    // Catalog\Models\Freelancer\FreelanceModel::acceptOffer
    public static function acceptOffer(int $freelancer_id, int $project_id, int $bid_id, int $employer_id)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'freelancer_id' => $freelancer_id,
            'customer_id'   => $employer_id,
            'project_id'    => $project_id,
            'bid_id'        => $bid_id,
            'url'           =>  route_to('account_project') . '#in-progress',
        ];

        $activityModel->addActivity('project_offer_accepted', $activity_data);
    }


    // Catalog\Models\Freelancer\MilestoneModel::insertMilestone
    public static function createMilestone(array $data)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'milestone_id'   => $data['milestone_id'],
            'customer_id'    => $data['created_for'],
            'created_by'     => $data['created_by'],
            'created_for'    => $data['created_for'],
            'project_id'     => $data['project_id'],
            'url'            => base_url('freelancer/project/view?pid=' . $data['project_id'] .'&cid=' . $data['created_for']) . '#milestones'
        ];

        $activityModel->addActivity('project_milestone_create', $activity_data);
    }

    // Catalog\Models\Freelancer\MilestoneModel::update
    public static function milestoneUpdate(int $milestone_id)
    {
        $activityModel = new ActivityModel();
        $milestoneModel = new MilestoneModel();
        
        $milestone_info = $milestoneModel->find($milestone_id);

        $activity_data = [
            'milestone_id'     => $milestone_id,
            'customer_id'      => $milestone_info['created_by'],
            'created_by'       => $milestone_info['created_for'],
            'created_for'      => $milestone_info['created_for'],
            'project_id'       => $milestone_info['project_id'],
            'milestone_status' => $milestone_info['status'],
            'url'              => base_url('freelancer/project/view?pid=' . $milestone_info['project_id']) . '#milestones'
        ];

        $activityModel->addActivity('project_milestone_update', $activity_data);
    }


    // Catalog\Models\Freelancer\BalanceModel::payMilestone
    public static function payMilestone(int $freelancer_id, int $project_id, int $balance_id)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id' => $freelancer_id,
            'balance_id'  => $balance_id,
            'project_id'  => $project_id,
        ];

        $activityModel->addActivity('customer_milestone_payment', $activity_data);
    }

    // Catalog\Model\Freelancer\FreelancerModel::updateProjectStatus
    public static function updateProjectStatus(int $project_id, int $freelancer_id, int $employer_id)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id'   => $employer_id,
            'freelancer_id' => $freelancer_id,
            'project_id'    => $project_id,
            'url'           => route_to('account_project') . '#past-projects'
        ];

        $activityModel->addActivity('project_status_update', $activity_data);
    }

    // Catalog\Model\Account\ReviewModel::insert
    public static function addReview(array $data = [])
    {
        $activityModel = new ActivityModel();

        if ($data['freelancer_id'] == $data['submitted_by']) {
            $customer_id = $data['employer_id'];
        } else {
            $customer_id = $data['freelancer_id'];
        }

        $activity_data = [
            'customer_id'   => $customer_id,
            'submitted_by'  => $data['submitted_by'],
            'freelancer_id' => $data['freelancer_id'],
            'project_id'    => $data['project_id'],
            'url'           => route_to('account_review')
        ];

        $activityModel->addActivity('customer_review', $activity_data);
    }
    

    // --------------------------------------------------
}
