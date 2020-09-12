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
$routes->add('{locale}/information/(:any)', 'Information\Information::index', ['as' => 'information']);
// Project
$routes->group('{locale}/project', function ($routes) {
    $routes->add('categories', 'Project\Category::index', ['as' => 'project/category']);
    $routes->add('category/(:num)', 'Project\Category::index/$1', ['as' => 'project/category']);
});
// Blog
$routes->add('{locale}/blog', 'Extension\Blog\Blog::index', ['as' => 'blog']);
$routes->get('{locale}/blog/post', 'Extension\Blog\Blog::post', ['as' => 'blog/post']);
     
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
