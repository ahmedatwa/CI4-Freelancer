<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Config extends BaseConfig
{
    /*
     * --------------------------------------------------------------------------
     * Template Engine
     * --------------------------------------------------------------------------
     *
    */
    public $templateEngine = 'twig';
    public $ImagePath      = FCPATH . 'images/';
    
    // Pusher
    public $PusherAppID    = '1047280';
    public $PusherKey      = 'b4093000fa8e8cab989a';
    public $PusherSecret   = 'fb4bfd2d78aac168d918';
    public $PusherCluster  = 'eu';
    public $PusherUseTLS   = true;
    // Facebook
    public $facebookAppID = '244043297126105';
    public $facebookAppSecret = 'af2c14c8d33d8d995c36a2fd072a526c';
	public $facebookVer = 'v2.10';
}
