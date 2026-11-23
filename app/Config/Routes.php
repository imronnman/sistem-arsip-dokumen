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

// Route Publik (Autentikasi)
$routes->get('/', 'Auth::login');
$routes->get('login', 'Auth::login');
$routes->post('loginProcess', 'Auth::loginProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('auth/googleLogin', 'Auth::googleLogin');

// Route Terproteksi (Wajib Login via Filter 'auth')
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Manajemen Kategori
$routes->group('kategori', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'Categories::index');
    $routes->post('store', 'Categories::store');
    $routes->post('update/(:num)', 'Categories::update/$1');
    $routes->post('delete/(:num)', 'Categories::delete/$1');
});

// Manajemen Arsip Dokumen
$routes->group('arsip', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'Archives::index');
    $routes->get('create', 'Archives::create');
    $routes->post('store', 'Archives::store');
    $routes->get('edit/(:num)', 'Archives::edit/$1');
    $routes->post('update/(:num)', 'Archives::update/$1');
    $routes->post('delete/(:num)', 'Archives::delete/$1');
    $routes->get('preview/(:num)', 'Archives::preview/$1');
    $routes->get('download/(:num)', 'Archives::download/$1');
});

// Manajemen Pengguna & Petugas
$routes->group('pengguna', ['filter' => 'auth'], function($routes) {
    $routes->get('', 'Users::index');
    $routes->post('store', 'Users::store');
    $routes->post('update/(:num)', 'Users::update/$1');
    $routes->post('delete/(:num)', 'Users::delete/$1');
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
