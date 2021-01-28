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
//$routes->add('from', 'to', ['subdomain' => 'admin']);
$routes->addPlaceholder('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

$routes->add('/', 'Common/Login::index');

// Extenstions
$routes->group('extensions', ['namespace' => 'Extensions\Controllers'], function($routes)
{
    $routes->add('bid/bid', 'Bid\Bid::index');

    $routes->add('dashboard/activity', 'Dashboard\Activity::index');
    $routes->add('dashboard/online', 'Dashboard\Online::index');
    
    $routes->add('job/job', 'Job\Job::index');
    $routes->add('job/job/add', 'Job\Job::add');
    $routes->add('job/job/edit', 'Job\Job::edit');
    $routes->add('job/job/delete', 'Job\Job::delete');
    // Wallet
    $routes->add('wallet/wallet', 'Wallet\Wallet::index');
    // Themes
    $routes->add('theme/basic', 'Theme\Basic::index');
    // Blog
    // // Post
    $routes->add('blog/post', 'Blog\Post::index');
    $routes->add('blog/post/add', 'Blog\Post::add');
    $routes->add('blog/post/edit', 'Blog\Post::edit');
    $routes->add('blog/post/delete', 'Blog\Post::delete');
    // // Categiry
    $routes->add('blog/category', 'Blog\Category::index');
    $routes->add('blog/category/add', 'Blog\Category::add');
    $routes->add('blog/category/edit', 'Blog\Category::edit');
    $routes->add('blog/category/delete', 'Blog\Category::delete');
    // Comment
    $routes->add('blog/comment', 'Blog\Comment::index');
    $routes->add('blog/comment/edit', 'Blog\Comment::edit');
    $routes->add('blog/comment/delete', 'Blog\Comment::delete');
    // Reports
    $routes->add('report/user_activity', 'Report\User_activity::index');

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
