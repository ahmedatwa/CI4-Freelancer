<?php 

namespace Admin\Events;

use \Extensions\Models\Report\ActivityModel;
use \Admin\Libraries\User;
use \Admin\Models\User\UserModel;
use CodeIgniter\I18n\Time;

class ActivityEvent
{
    // Admin\Controllers\user\user::index
    public static function login()
    {
        $activityModel = new ActivityModel();
        $user = new User();

        $data = [
            'user_id' => $user->getUserId(),
            'name'    => $user->getUserName(),
            ];

        $activityModel->addActivity('activity_login', $data);
    }

    // Admin\Controllers\user\user::Rules
    public static function loginAttempts(string $email)
    {
        $userModel = new UserModel();
        $userModel->addLoginAttempts($email);
    }

    // Admin\Controllers\Common\Forgotten::index
    public static function mailForgotten($email)
    {
        $email = \Config\Services::email();

        $email->setFrom('your@example.com', 'Your Name');
        $email->setTo($email);
    
        $email->setSubject('Reset Your Password');
        $email->setMessage(view('Mail/forgotten'));
    
        $email->send();
    }

    // Admin\Models\*\::insert
    public static function afterInsert(...$args)
    {
        $activityModel = new ActivityModel();
        $user = new User();
        if (isset($args)) {
            if (isset($args[2])) {
                foreach ($args[2] as $key => $value) {
                    $user_data = [
                        "user_id"           => $user->getUserId(),
                        "name"              => $user->getUserName(),
                        "{$args[1]["key"]}" => $args[1]['value'],
                        "{$key}"            => $value,
                    ];
                }
            }
        }
        $activityModel->addActivity('activity_' . $args[0], $user_data);
    }
   
    // Admin\Models\*\::Update
    public static function afterUpdate(...$args)
    {
        $activityModel = new ActivityModel();
        $user = new User();
        if (isset($args)) {
            foreach ($args[2] as $key => $value) {
                $user_data = [
                    "user_id"           => $user->getUserId(),
                    "name"              => $user->getUserName(),
                    "{$args[1]["key"]}" => $args[1]['value'],
                    "{$key}"            => $value,
                ];
            }
        }
        $activityModel->addActivity('activity_' . $args[0], $user_data);
    }

    // Admin\Models\*\::delete
    public static function afterDelete($id, $name)
    {
        $activityModel = new ActivityModel();
        $user = new User();
 
        $data = [
             'user_id' => $user->getUserId(),
             'name'    => $user->getUserName(),
             'id'      => $id,
             'name'    => $name
        ];
 
        $activityModel->addActivity('activity_user_delete', $data);
    }
    
    // --------------------------------------------
}
