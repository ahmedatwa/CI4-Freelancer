<?php

namespace Config;

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
    echo view_cell('\Catalog\Controllers\Error\NotFound::index');
});

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Common/Home::index');
// Blog
$routes->group('blog', function ($routes) {
    $routes->get('/', 'Extension\Blog\Blog::index', ['as' => 'blog']);
    $routes->get('p(:num)/(:any)', 'Extension\Blog\Blog::getPost/$1/$2', ['as' => 'blog_post']);
});
// Local Jobs
$routes->group('local', function ($routes) {
    $routes->add('jobs/', 'Extension\Job\Job::index', ['as' => 'local_jobs']);
    $routes->add('jobs/j(:num)/(:any)', 'Extension\Job\Job::info/$1/$2', ['as' => 'local_job']);
});
// Freelancers
$routes->get('freelancers', 'Freelancer\Freelancer::index', ['as' => 'freelancers']);
$routes->get('f/(:segment)', 'Freelancer\Freelancer::profile/$1', ['as' => 'freelancer_profile']);
// Freelancer Profile
$routes->group('certificate', function ($routes) {
    //$routes->add('delete/(:num)', 'Freelancer\Freelancer::deleteCertificate/$1', ['as' => 'certificate_delete']);
    $routes->post('add', 'Freelancer\Freelancer::addCertificate', ['as' => 'certificate_add']);
});
// Account
$routes->group('account/(:segment)', function ($routes) {
    $routes->add('dashboard', 'Account\Dashboard::index/$1', ['as' => 'account_dashboard']);
    $routes->add('setting', 'Account\Setting::index/$1', ['as' => 'account_setting']);
    $routes->add('inbox', 'Account\Inbox::index/$1', ['as' => 'account_inbox']);
    $routes->add('review', 'Account\Review::index/$1', ['as' => 'account_review']);
    $routes->add('projects', 'Account\Projects::index/$1', ['as' => 'account_project']);
    $routes->add('dispute', 'Account\Dispute::index/$1', ['as' => 'account_dispute']);
    $routes->add('jobs', 'Account\Jobs::index/$1', ['as' => 'account_jobs']);
    $routes->add('deposit', 'Account\Deposit::index', ['as' => 'freelancer_deposit']);
    $routes->add('withdraw', 'Account\Withdraw::index', ['as' => 'freelancer_withdraw']);
});
// 2-Step verification
$routes->get('verify', 'Account\Verify::index', ['as' => 'account_verify']);
$routes->get('login', 'Account\Login::index', ['as' => 'account_login']);
$routes->get('reset', 'Account\Reset::index', ['as' => 'account_reset']);
$routes->get('logout', 'Account\Logout::index', ['as' => 'account_logout']);
$routes->get('register', 'Account\Register::index', ['as' => 'account_register']);
$routes->get('forgotten', 'Account\Forgotten::index', ['as' => 'account_forgotten']);
// Category
$routes->get('categories', 'Project\Category::index', ['as' => 'categories']);
// Add Project
$routes->get('add-project', 'Project\Project::getForm', ['as' => 'add-project']);
// Project List
$routes->get('projects', 'Project\Project::index', ['as' => 'projects']);
// Single Project View
$routes->get('service/(:any)', 'Project\Project::info/$1', ['as' => 'single_project']);
// Information
$routes->get('(:segment)', 'Information\Information::index/$1', ['as' => 'information']);
$routes->get('contact', 'Information\Contact::index');
// Hide the upload url
$routes->get('upload/(:num)/(:num)', 'Tool\Upload::getUpload/$1/$2', ['as' => 'get_upload']);
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}