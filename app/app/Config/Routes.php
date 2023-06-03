<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

// Member Routes.

// Handle the page render routing.
$routes->get('/', 'RenderView\V1\MembersViewController::loginPage');
$routes->get('/signIn', 'RenderView\V1\MembersViewController::loginPage');
$routes->get('/signUp', 'RenderView\V1\MembersViewController::signUpPage');
$routes->get('/todoList', 'RenderView\V1\TodoListViewController::todoListPage', ['filter' => 'ViewAuthFilter']);
$routes->get(
    '/todoList/getDataTable',
    'RenderView\V1\TodoListViewController::getDatatableData',
    ['filter' => 'AuthFilter']
);

$routes->group('api/v1', static function (\CodeIgniter\Router\RouteCollection $routes) {    
    // Create a new user.
    $routes->post('user', 'Api\V1\MembersController::signUp');

    // Read user info.
    $routes->post('user/login', 'Api\V1\MembersController::signIn');
    $routes->get('user/logout', 'Api\V1\MembersController::logout');

    // Use Resource function to define the RESTful API.
    $routes->resource('todo', [
        'controller'  => 'Api\V1\TodoController',
        'only'        => ['index', 'show', 'create', 'update', 'delete'],
        'filter'      => 'AuthFilter',
        'placeholder' => '(:num)',
        'todo'        => 1,
    ]);
});

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
