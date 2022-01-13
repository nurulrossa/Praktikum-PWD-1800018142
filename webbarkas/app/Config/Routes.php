<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'User::index');
$routes->get('/daftarbarkas', 'User::daftarbarkas');

$routes->get('/login', 'Home::login');
$routes->get('/logout', 'Home::logout');

$routes->get('/admin', 'Admin::barkas_pending', ['filter' => 'level']);
$routes->get('/profil-admin', 'Admin::profil', ['filter' => 'level']);
$routes->get('/password-admin', 'Admin::password', ['filter' => 'level']);
$routes->get('/barkas-pending', 'Admin::barkas_pending', ['filter' => 'level']);
$routes->get('/barkas-ada', 'Admin::barkas_ada', ['filter' => 'level']);
$routes->get('/barkas-sold', 'Admin::barkas_sold', ['filter' => 'level']);
$routes->get('/edit-barkas/(:any)', 'Admin::edit/$1', ['filter' => 'level']);
$routes->get('/aktivasi/(:any)', 'Admin::aktivasi/$1', ['filter' => 'level']);
$routes->get('/soldout/(:any)', 'Admin::sold/$1', ['filter' => 'level']);
$routes->get('/batal-barkas/(:any)', 'Admin::batal/$1', ['filter' => 'level']);
$routes->get('/hapus-barkas/(:any)', 'Admin::hapus/$1', ['filter' => 'level']);
$routes->get('/laporan', 'Admin::cetak_laporan', ['filter' => 'level']);


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
