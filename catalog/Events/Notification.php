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
    public static function winnerSelected(int $freelancer_id, int $project_id, int $bid_id)
    {
        $activityModel = new ActivityModel();

        $activity_data = [
            'customer_id'   => 0,
            'freelancer_id' => $freelancer_id,
            'project_id'    => $project_id,
            'bid_id'       => $bid_id,
        ];

        $activityModel->addActivity('project_winner_selected', $activity_data);
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
