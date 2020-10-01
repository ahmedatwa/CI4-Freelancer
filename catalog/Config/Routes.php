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
$routes->get('/', 'Common/Home::index');
// Information
$routes->add('information/(:any)', 'Information\Information::index/$1', ['as' => 'information']);
// Projects
//$routes->add('projects', 'Project\Category::index');
//$routes->add('projects/project/(:any)', 'Project\Project::index/$1', ['as' => 'projects/project']);  
//$routes->add('add-project', 'Project\Project::getForm');  
//$routes->add('category/autocomplete', 'Project\Category::autocomplete');  

// Blog
$routes->group('blog', function ($routes) {
    $routes->add('/', 'Extension\Blog\Blog::index', ['as' => 'blog']);
    $routes->add('post/(:any)', 'Extension\Blog\Blog::getPost/$1', ['as' => 'blog/post']);
});

// $routes->group('account', function ($routes) {
//     $routes->add('login', 'Account\Login::index');
//     $routes->add('logout', 'Account\Logout::index');
    
//     $routes->add('certificates', 'Account\Setting::getCertificates');
//     $routes->add('certificates/add', 'Account\Setting::addCertificate');
//     $routes->add('certificates/delete', 'Account\Setting::deleteCertificate');
//     $routes->add('education', 'Account\Setting::getEducation');
//     $routes->add('education/add', 'Account\Setting::addEducation');
//     $routes->add('education/delete', 'Account\Setting::deleteEducation');
//     $routes->add('education/university', 'Account\Setting::universitiesAutocomplete');
//     $routes->add('education/major', 'Account\Setting::majorsAutocomplete');
//     $routes->add('language', 'Account\Setting::getLanguages');
//     $routes->add('language/add', 'Account\Setting::addLanguage');
//     $routes->add('language/delete', 'Account\Setting::deleteLanguage');
//     $routes->add('language/autocomplete', 'Account\Setting::languagesAutocomplete');
//     $routes->add('skill', 'Account\Setting::getSkills');
//     $routes->add('skill/add', 'Account\Setting::addSkill');
//     $routes->add('skill/delete', 'Account\Setting::deleteSkill');
//     $routes->add('skill/autocomplete', 'Account\Setting::skillsAutocomplete');
    
//     $routes->add('dashboard', 'Account\Dashboard::index');
//     $routes->add('forgotton', 'Account\Forgotton::index');
//     $routes->add('register', 'Account\Register::index');
//     // Dashboard
//     $routes->add('dashboard/setting', 'Account\Setting::index');
    //$routes->add('dashboard/projects', 'Account\Projects::index');
    //$routes->add('dashboard/project/bidders', 'Account\Projects::getBidders');
    //$routes->add('dashboard/bids', '');
    //$routes->add('dashboard/project/add', 'Account\Projects::add');
   // $routes->add('dashboard/project/edit', 'Account\Projects::edit');
    // Manage Dashboard
//     $routes->group('manage', function($routes)
//     {
//         $routes->add('projects', 'Account\Projects::index');
//         $routes->add('project/reviews', 'Account\Review::index');
//         $routes->add('project/messages', 'Account\Review::index');
//         $routes->add('project/bidders', 'Account\Projects::getBidders');
//         $routes->add('project/bids', 'Account\Projects::getActiveBids');
//         $routes->add('project/add', 'Account\Projects::add');
//         $routes->add('project/edit', 'Account\Projects::edit');
//     });
// });
 
// $routes->group('freelancers', function($routes)
// {
//     $routes->add('profile', 'Account\Manage::getList');
// });
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
