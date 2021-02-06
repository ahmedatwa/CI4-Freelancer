<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use Catalog\Filters\SeoUrl;
use Catalog\Filters\Localization;
use Catalog\Filters\Maintenance;
use Catalog\Filters\Throttle;

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
		'seo_url'      => SeoUrl::class,
		'localization' => Localization::class,
		'maintenance'  => Maintenance::class,
		'throttle'     => Throttle::class,

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
            'seo_url',
            //'honeypot',
            'maintenance',
            'csrf',
		],
		'after'  => [
            'honeypot',
            'toolbar',
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
