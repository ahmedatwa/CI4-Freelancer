<?php namespace Catalog\Events;

use \Catalog\Models\Account\ActivityModel;
use Catalog\Models\Account\CustomerModel;

class Notification
{
    // Catalog\Models\Project\ProjectModel::addMessage
    public static function newMessage(int $employer_id, int $freelancer_id, int $project_id, string $message)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id'   => 0,
            'employer_id'   => $employer_id,
            'freelancer_id' => $freelancer_id,
            'project_id'    => $project_id,
            'message'       => $message,
        ];

        $activityModel->addActivity('customer_new_message', $activity_data);
    }


    // Catalog\Models\Project\ProjectModel::addWinner
    public static function winnerSelected(array $data)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'freelancer_id'  => $data['freelancer_id'],
            'project_id'    => $data['project_id'],
            'bid_id'        => $data['bid_id'],
        ];

        $activityModel->addActivity('offer_selected', $activity_data);
    }

    // Catalog\Models\Freelancer\FreelanceModel::acceptOffer
    public static function winnerAccepted(int $freelancer_id, int $project_id)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'project_id'    => $project_id,
            'customer_id'   => $freelancer_id,
        ];

        $activityModel->addActivity('offer_accepted', $activity_data);
    }


    // Catalog\Models\Project\ProjectModel::insertMilestone
    public static function createMilestone(int $project_id, float $amount, string $description, int $deadline)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id' => 0,
            'project_id'  => $project_id,
            'amount'      => $amount,
            'description' => $description,
            'deadline'    => $deadline,
        ];

        $activityModel->addActivity('project_milestone_create', $activity_data);
    }


    // --------------------------------------------------
}
