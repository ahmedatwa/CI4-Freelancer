<?php namespace Catalog\Events;

use \Catalog\Models\Account\ActivityModel;
use Catalog\Models\Account\CustomerModel;

class Notification
{
    // Catalog\Models\Project\ProjectModel::addMessage
    // public static function addMessage(array $data)
    // {
    //     $activityModel = new ActivityModel();

    //     $activity_data = [
    //         'sender_id'   => $data['sender_id'],
    //         'customer_id' => $data['receiver_id'],
    //         'project_id'  => $data['project_id'],
    //         'message'     => $data['message'],
    //         'url'         => route_to('account_message')
    //     ];

    //     $activityModel->addActivity('project_new_message', $activity_data);
    // }

    // Catalog\Models\Extensions\Bid\BidModel::addBid
    public static function addBid(array $data)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id'   => $data['employer_id'],
            'project_id'    => $data['project_id'],
            'freelancer_id' => $data['freelancer_id'],
            'url'           => base_url('freelancer/project/view?pid=' . $data['project_id'] .'&cid=' . $data['employer_id'])
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
            'url'         =>  route_to('freelancer_project') . '#freelancer',
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
            'url'           =>  route_to('freelancer_project') . '#in-progress',
        ];

        $activityModel->addActivity('project_offer_accepted', $activity_data);
    }


    // Catalog\Models\Catalog\MilestoneModel::insertMilestone
    public static function createMilestone(int $milestone_id, int $created_by, int $created_for, int $project_id)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'milestone_id'   => $milestone_id,
            'customer_id'    => $created_for,
            'created_by'     => $created_by,
            'created_for'    => $created_for,
            'project_id'     => $project_id,
            'url'            => base_url('freelancer/project/view?pid=' . $project_id .'&cid=' . $created_for ) . '#milestones'
        ];

        $activityModel->addActivity('project_milestone_create', $activity_data);
    }

    // Catalog\Models\Catalog\MilestoneModel::update
    public static function milestoneUpdate(int $milestone_id)
    {
        $activityModel = new ActivityModel();
        $milestoneModel = new \Catalog\Models\Catalog\MilestoneModel();
        $milestone_info = $milestoneModel->find($milestone_id);

        $activity_data = [
            'milestone_id' => $milestone_id,
            'customer_id'  => $milestone_info['created_for'],
            'created_by'   => $milestone_info['created_by'],
            'created_for'  => $milestone_info['created_for'],
            'milestone_status' => $milestone_info['status'],
            'url'          => base_url('freelancer/project/view?pid=' . $milestone_info['project_id']) . '#milestones'
        ];

        $activityModel->addActivity('project_milestone_update', $activity_data);
    }


    // Catalog\Models\Freelancer\BalanceModel::insert
    public static function balanceUpdate(int $customer_id, int $project_id, int $balance_id)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id' => $customer_id,
            'balance_id'  => $balance_id,
            'project_id'  => $project_id,
        ];

        $activityModel->addActivity('customer_balance_update', $activity_data);
    }


    


    // --------------------------------------------------
}
