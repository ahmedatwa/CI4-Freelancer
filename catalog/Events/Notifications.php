<?php namespace Catalog\Events;

use \Catalog\Models\Account\ActivityModel;
use Catalog\Libraries\Customer;

class Notifications
{
    // Catalog\Controllers\user\user::index
    public static function newMessage()
    {
        
        return view ('alerts/new_project');
    }



    // --------------------------------------------------
}
