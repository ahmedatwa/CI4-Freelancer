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
    echo view('errors/not_found.php');
});


/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Common/Home::index');
// Information
$routes->add('information/(:any)', 'Information\Information::index', ['as' => 'information']);
// Project
// $routes->group('project', function ($routes) {
//     $routes->add('categories', 'Project\Category::index', ['as' => 'categories']);
//     $routes->add('category/(:any)', 'Project\Category::index/$1', ['as' => 'category']);
// });
$routes->add('projects', 'Project\Project::index');
$routes->add('project/(:any)', 'Project\Project::getProject/$1', ['as' => 'project']);


// $routes->add('jobs', 'Extension\Job\Job::index', ['as' => 'jobs']);
// $routes->add('job/(:any)', 'Extension\Job\Job::getJob/$1', ['as' => 'job']);

// Blog
$routes->add('blog', 'Extension\Blog\Blog::index', ['as' => 'blog']);
$routes->add('blog/post', 'Extension\Blog\Blog::post', ['as' => 'blog/post']);

$routes->group('account', function ($routes) {
    $routes->add('login', 'Account\Login::index');
    $routes->add('forgotton', 'Account\forgotton::index', ['as' => 'forgotton']);
    $routes->add('register', 'Account\register::index');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
