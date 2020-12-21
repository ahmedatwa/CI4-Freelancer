<?php namespace Admin\Events;

use \Admin\Models\Report\ActivityModel;
use \Admin\Libraries\User;
use \Admin\Models\User\UserModel;
use CodeIgniter\I18n\Time;

class Activity
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

        $activityModel->addActivity('activity_user_login', $data);
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
    public static function afterInsert(int $id = 0, string $name = '')
    {
        $activityModel = new ActivityModel();
        $user = new User();

        $data = [
            'user_id' => $user->getUserId(),
            'name'    => $user->getUserName(),
            'id'      => $id,
            'name'    => $name
            ];

        $activityModel->addActivity('activity_user_add', $data);
    }
   
    // Admin\Models\*\::Update
    public static function afterUpdate(int $id = 0, string $name = '')
    {
        $activityModel = new ActivityModel();
        $user = new User();
 
        $data = [
             'user_id' => $user->getUserId(),
             'name'    => $user->getUserName(),
             'id'      => $id,
             'name'    => $name
             ];
 
        $activityModel->addActivity('activity_user_edit', $data);
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
    
    public static function purgeLogFiles()
    {
        if (service('registry')->get('config_purge_logs')) {
            $myTime = new Time('now');

            $time = Time::parse('August 12, 2016 4:15:23pm');
            $time = $time->addDays(30);




            helper('filesystem');
            delete_files('./path/to/directory/', true, false);
        }
    }







    // --------------------------------------------
}
