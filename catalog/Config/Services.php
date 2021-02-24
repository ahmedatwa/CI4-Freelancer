<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
	// public static function example($getShared = true)
	// {
	//     if ($getShared)
	//     {
	//         return static::getSharedInstance('example');
	//     }
	//
	//     return new \CodeIgniter\Example();
	// }

	public static function registry($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('registry');
        }
        return new \Catalog\Libraries\Registry();
    }
    // SEO
    public static function seo_url($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('seo_url');
        }
        return new \Catalog\Models\Design\SeoUrlModel;
    }

    public static function customer($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('customer');
        }
        return new \Catalog\Libraries\Customer;
    }    

    public static function template($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('template');
        }
        return new \Catalog\Libraries\Template;
    }
}
