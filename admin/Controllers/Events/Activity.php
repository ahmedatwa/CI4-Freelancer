<?php namespace Admin\Controllers\Events;

class Activity
{
	// Admin\Controllers\user\user::index
    public static function login()
    {
        $activity_model = new \Admin\Models\Report\Activity();

        $user = new \Admin\Libraries\User();

        $data = array(
            'user_id'     => $user->getUserId(),
            'name'        => $user->getUserName(),
            );

        $activity_model->addActivity('activity_user_login', $data);
    }

	// Admin\Controllers\user\user::Rules
    public static function loginAttempts(string $email)
    {
        $User = new \Admin\Models\User\Users();

        $User->addLoginAttempts($email);
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
        $activity_model = new \Admin\Models\Report\Activity();

        $user = new \Admin\Libraries\User();

        $data = array(
            'user_id' => (int) $user->getUserId(),
            'name'    => (string) $user->getUserName(),
            'id'      => $id,
            'name'    => $name
            );

        $activity_model->addActivity('activity_user_add', $data);
    }
   
     // Admin\Models\*\::Update
     public static function afterUpdate(int $id = 0, string $name = '')
     {
         $activity_model = new \Admin\Models\Report\Activity();
 
         $user = new \Admin\Libraries\User();
 
         $data = array(
             'user_id' => (int) $user->getUserId(),
             'name'    => (string) $user->getUserName(),
             'id'      => $id,
             'name'    => $name
             );
 
         $activity_model->addActivity('activity_user_edit', $data);
     }

     // Admin\Models\*\::delete
     public static function afterDelete($id, $name)
     {
         $activity_model = new \Admin\Models\Report\Activity();
 
         $user = new \Admin\Libraries\User();
 
         $data = array(
             'user_id' => $user->getUserId(),
             'name'    => $user->getUserName(),
             'id'      => $id,
             'name'    => $name
             );
 
         $activity_model->addActivity('activity_user_delete', $data);
     }
 







    // -----------------------------
}
