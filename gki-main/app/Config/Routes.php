<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/admin/dashboard', 'Admin::index');

$routes->post('/auth/register', 'AuthController::register');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/auth/logout', 'AuthController::logout');
$routes->get('/login', 'Admin::login');
$routes->get('/register', 'Admin::register');

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('informasi', 'Admin::informasi');
    $routes->get('sejarah', 'Admin::sejarah');
    $routes->get('visimisi', 'Admin::visimisi');
    $routes->get('kegiatan', 'Admin::kegiatan');
    $routes->get('jadwalacara', 'Admin::jadwal');
    $routes->get('keuangan', 'Admin::keuangan');
    $routes->get('pengisiacara', 'Admin::pengisiacara');
    $routes->get('struktur', 'Admin::struktur');
    $routes->get('content', 'Admin::content');
    $routes->get('user', 'Admin::user');

});
$routes->group('user',['filter' => 'auth'], function($routes) {
    $routes->post('get_list', 'UserController::get_list');
    $routes->post('add', 'UserController::add');
    $routes->get('get/(:num)', 'UserController::get/$1');
    $routes->post('update', 'UserController::update');
    $routes->post('delete/(:num)', 'UserController::delete/$1');

});

$routes->group('content',['filter' => 'auth'], function($routes) {
    $routes->post('get_list', 'ContentController::get_list');
    $routes->post('add_konten', 'ContentController::add_konten');
    $routes->get('get_konten/(:num)', 'ContentController::get_konten/$1');
    $routes->post('update_konten', 'ContentController::update_konten');
    $routes->post('delete_konten/(:num)', 'ContentController::delete_konten/$1');
    $routes->post('upload_image', 'ContentController::upload_image');

});
$routes->group('informasi',['filter' => 'auth'], function($routes) {
    $routes->post('get_list', 'informasiController::get_list');
    $routes->post('add', 'informasiController::add');
    $routes->get('get/(:num)', 'informasiController::get/$1');
    $routes->post('update', 'informasiController::update');
    $routes->post('delete/(:num)', 'informasiController::delete/$1');
    $routes->post('upload_image', 'informasiController::upload_image');

});
$routes->group('sejarah',['filter' => 'auth'], function($routes) {
    $routes->post('get_list', 'SejarahController::get_list');
    $routes->post('add', 'SejarahController::add');
    $routes->get('get/(:num)', 'SejarahController::get/$1');
    $routes->post('update', 'SejarahController::update');
    $routes->post('delete/(:num)', 'SejarahController::delete/$1');
    $routes->post('upload_image', 'SejarahController::upload_image');

});

$routes->group('visimisi',['filter' => 'auth'], function($routes) {
    $routes->post('get_list', 'VisiMisiController::get_list');
    $routes->post('add', 'VisiMisiController::add');
    $routes->get('get/(:num)', 'VisiMisiController::get/$1');
    $routes->post('update', 'VisiMisiController::update');
    $routes->post('delete/(:num)', 'VisiMisiController::delete/$1');
    $routes->post('upload_image', 'VisiMisiController::upload_image');
});

$routes->group('kegiatan',['filter' => 'auth'], function($routes) {
     $routes->post('get_list', 'KegiatanController::get_list');
    $routes->post('add', 'KegiatanController::add');
    $routes->get('get/(:num)', 'KegiatanController::get/$1');
    $routes->post('update', 'KegiatanController::update');
    $routes->post('delete/(:num)', 'KegiatanController::delete/$1');
    $routes->post('upload_image', 'KegiatanController::upload_image');

});

$routes->group('pengisi_acara',['filter' => 'auth'], function($routes) {
    $routes->post('get_list', 'PengisiAcaraController::get_list');
    $routes->post('add', 'PengisiAcaraController::add');
    $routes->get('get/(:num)', 'PengisiAcaraController::get/$1');
    $routes->post('update', 'PengisiAcaraController::update');
    $routes->post('delete/(:num)', 'PengisiAcaraController::delete/$1');
});

$routes->group('jadwal',['filter' => 'auth'], function($routes) {
$routes->post('get_list', 'JadwalController::get_list');      
$routes->post('add', 'JadwalController::add');                
$routes->get('get/(:num)', 'JadwalController::get/$1');       
$routes->post('update', 'JadwalController::update');          
$routes->post('delete/(:num)', 'JadwalController::delete/$1');

});

$routes->group('keuangan',['filter' => 'auth'], function($routes) {
    $routes->post('get_list', 'KeuanganController::get_list');
    $routes->post('add', 'KeuanganController::add');
    $routes->get('get/(:num)', 'KeuanganController::get/$1');
    $routes->post('update', 'KeuanganController::update');
    $routes->post('delete/(:num)', 'KeuanganController::delete/$1');
    $routes->get('getAll', 'KeuanganController::getAll');
});

$routes->group('struktur',['filter' => 'auth'], function($routes) {
   $routes->post('get_list', 'StrukturOrganisasiController::get_list');
    $routes->post('add', 'StrukturOrganisasiController::add');
    $routes->post('get/(:num)', 'StrukturOrganisasiController::get/$1');
    $routes->post('update/(:num)', 'StrukturOrganisasiController::update/$1');
    $routes->post('delete/(:num)', 'StrukturOrganisasiController::delete/$1');
    $routes->post('upload_image', 'StrukturOrganisasiController::upload_image');
});
