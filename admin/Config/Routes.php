<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('Admin\Controllers');
$routes->setDefaultController('Common/Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Common/Login::index');
// Modules
$routes->group('blog', ['namespace' => 'Modules\Controllers'], function($routes)
{
    $routes->add('post', 'Blog\Post::index');
    $routes->add('post/add', 'Blog\Post::add');
    $routes->add('post/edit', 'Blog\Post::edit');
    $routes->add('post/delete', 'Blog\Post::delete');
});
$routes->group('job', ['namespace' => 'Modules\Controllers'], function($routes)
{
    $routes->add('job', 'Job\Job::index');
    $routes->add('job/add', 'Job\Job::add');
    $routes->add('job/edit', 'Job\Job::edit');
    $routes->add('job/delete', 'Job\Job::delete');
});


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
