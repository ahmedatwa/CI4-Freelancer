<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use Catalog\Filters\SeoUrlFilter;
use Catalog\Filters\LocalizationFilter;
use Catalog\Filters\MaintenanceFilter;
use Catalog\Filters\ThrottleFilter;
use Catalog\Filters\EncryptionFilter;

class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
		'csrf'         => CSRF::class,
		'toolbar'      => DebugToolbar::class,
		'honeypot'     => Honeypot::class,
		//'seo_url'      => SeoUrlFilter::class,
		'localization' => LocalizationFilter::class,
		'maintenance'  => MaintenanceFilter::class,
		'throttle'     => ThrottleFilter::class,
		'encryption'   => EncryptionFilter::class,
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */
	public $globals = [
		'before' => [
            'localization',
            //'seo_url',
            'maintenance',
            'csrf',
		],
		'after'  => [
            'honeypot',
            'toolbar',
            'encryption',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [
	    'post' => ['throttle']
    ];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [];
}
