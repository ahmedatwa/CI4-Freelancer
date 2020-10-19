<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('Catalog\Controllers');
$routes->setDefaultController('Common/Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->setAutoRoute(true);
// Will display a custom view
$routes->set404Override(function () {
    echo view_cell('\Catalog\Controllers\Error\Not_found::index');
});


/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->add('/', 'Common/Home::index');
// Information
$routes->add('information/(:any)', 'Information\Information::index/$1', ['as' => 'information']);
$routes->add('contact', 'Information\Contact::index');

// Blog
$routes->group('blog', function ($routes) {
    $routes->add('/', 'Extension\Blog\Blog::index', ['as' => 'blog']);
    $routes->add('view/(:any)', 'Extension\Blog\Blog::getPost/$1', ['as' => 'blog/post']);
});

// Freelancers
	$routes->add('freelancers', 'Freelancer\Freelancer::index');
	$routes->add('freelancer/u(:num)/(:any)', 'Freelancer\Freelancer::profile/$1/$2', ['as' => 'freelancer_profile']);

	//$routes->add('freelancer(:num)/(:any)', 'Freelancer\Freelancer::profile/$1/$2', ['as' => 'freelancer_profile']);

// Account
$routes->group('account', function ($routes) {
	$routes->add('dashboard', 'Account\Dashboard::index', ['as' => 'account_dashboard']);
	$routes->add('setting', 'Account\Setting::index', ['as' => 'account_setting']);
	$routes->add('message', 'Account\Message::index', ['as' => 'account_message']);
	$routes->add('review', 'Account\Review::index', ['as' => 'account_review']);
	$routes->add('login', 'Account\Login::index', ['as' => 'account_login']);
	$routes->add('register', 'Account\Register::index', ['as' => 'account_register']);
	$routes->add('forgotten', 'Account\Forgotten::index', ['as' => 'account_forgotten']);
	$routes->add('reset', 'Account\Reset::index', ['as' => 'account_reset']);
	$routes->add('logout', 'Account\Logout::index', ['as' => 'account_logout']);
	$routes->add('project', 'Account\Project::index', ['as' => 'account_project']);

});

// projects
$routes->add('categories', 'Project\Category::index', ['as' => 'categories']);
$routes->add('add-project', 'Project\Project::add');
$routes->add('projects', 'Project\Project::index', ['as' => 'projects']);
$routes->add('project/(:any)', 'Project\Project::project/$1', ['as' => 'single_project']);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
