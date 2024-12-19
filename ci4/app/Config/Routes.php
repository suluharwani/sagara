<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/altlogin', 'Login::altlogin');
$routes->get('/altloginuser', 'Login::altloginuser');

// alt login
$routes->get('/', 'Home::index');
$routes->get('/contact', 'Contact::index');
$routes->get('/blog', 'Blog::index');
$routes->get('/blog/(:any)', 'Blog::content/$1');
$routes->get('/informations', 'Informations::index');
$routes->get('/informations/(:any)', 'Informations::info/$1');
$routes->get('/pages', 'Pages::index');
//product
$routes->get('/admin/product', 'Product::index');
$routes->post('/admin/product/tambah_group', 'Product::tambah_group');
$routes->post('/admin/product/select_group', 'Product::select_group');
$routes->post('/admin/product/deleted_group', 'Product::deleted_group');
$routes->post('/admin/product/purge_group', 'Product::purge_group');
$routes->post('/admin/product/upload', 'Product::upload');
$routes->post('/admin/product/update_cat', 'Product::update_cat');
$routes->post('/admin/product/hapus_cat', 'Product::hapus_cat');
$routes->post('/admin/product/restore_cat', 'Product::restore_cat');
$routes->post('/admin/product/create', 'Product::create');

$routes->post('/admin/product/tambahSize', 'Product::tambahSize');
$routes->post('/admin/product/selectSize', 'Product::selectSize');
$routes->post('/admin/product/purgeSize', 'Product::purgeSize');
$routes->post('/admin/product/updateSize', 'Product::updateSize');
$routes->post('/admin/product/deleteProduct', 'Product::deleteProduct');
$routes->post('/admin/product/getProductDetail', 'Product::getProductDetail');
$routes->post('/admin/product/updateProduct', 'Product::updateProduct');
$routes->post('/admin/product/updateImage', 'Product::updateImage');


//admin
$routes->get('/admin', 'Admin::index' , ['as' => 'admin']);
$routes->get('/admin/manage/pages', 'Pages::manage');
$routes->get('/admin/manage/static_pages', 'StaticPages::manage');
$routes->get('/admin/login', 'Login::index');
$routes->post('/admin/login', 'Login::index');
$routes->get('/admin/register', 'Login::register');
$routes->get('/logout', 'Login::logout');
$routes->get('/admin/user/(:any)', 'User::user/$1');
//datatables post product

$routes->post('/product/listdataProduct', 'Product::listdataProduct');

//datatables post user admin
$routes->post('/admin/listdata_user', 'User::listdata_user');
$routes->post('/admin/user/tambah_admin', 'User::tambah_admin');
$routes->post('/admin/user/hapus_user', 'User::hapus_user');
$routes->post('/admin/user/reset_password', 'User::reset_password');
$routes->post('/admin/user/ubah_status_user', 'User::ubah_status_user');
$routes->post('/admin/user/ubah_level_user', 'User::ubah_level_user');
//datatables post client
$routes->post('/admin/listdata_client', 'User::listdata_client');
$routes->post('/admin/user/tambah_client', 'User::tambah_client');
$routes->post('/admin/user/hapus_client', 'User::hapus_client');
$routes->post('/admin/user/reset_password_client', 'User::reset_password_client');
$routes->post('/admin/user/ubah_status_client', 'User::ubah_status_client');
$routes->post('/admin/user/getClient', 'User::getClient');
//datatables post user pages
$routes->post('/pages/listdata_pages', 'Pages::listdata_pages');
$routes->post('/admin/page/tambah_page', 'Pages::tambah_page');
$routes->post('/admin/page/hapus_page', 'Pages::hapus_page');
$routes->post('/admin/page/detail', 'Pages::detail');
$routes->post('/admin/page/deleted_page', 'Pages::deleted_page');
$routes->post('/admin/page/restore_page', 'Pages::restore_page');
$routes->post('/admin/page/update_page', 'Pages::update_page');
$routes->post('/admin/page/cat_list', 'Pages::cat_list');
$routes->post('/admin/page/subcat_list', 'Pages::subcat_list');
//cat sub cat
$routes->post('/admin/page/tambah_cat', 'Pages::tambah_cat');
$routes->post('/admin/page/update_cat', 'Pages::update_cat');
$routes->post('/admin/page/update_subcat', 'Pages::update_subcat');
$routes->post('/admin/page/hapus_cat', 'Pages::hapus_cat');
$routes->post('/admin/page/hapus_subcat', 'Pages::hapus_subcat');
$routes->post('/admin/page/tambah_subcat', 'Pages::tambah_subcat');

$routes->get('/admin/test/(:any)', 'Admin::test/$1');
//menu
$routes->post('/home/menu', 'Home::menu');
$routes->post('/home/menu_cat', 'Home::menu_cat');
$routes->post('/home/menu_sub_cat', 'Home::menu_sub_cat');

//page
$routes->get('/page/(:any)/(:any)/(:any)(:any)', 'Home::page/$1/$2/$3/$4');
$routes->get('/page/(:any)/(:any)/(:any)', 'Home::page/$1/$2/$3');
$routes->get('/page/(:any)/(:any)', 'Home::page/$1/$2');
$routes->get('/page/(:any)', 'Home::page/$1');
$routes->get('/page', 'Home::page');

$routes->post('/home/get_menu_array', 'Home::get_menu_array');

//static pages
$routes->get('/admin/static_page', 'StaticPages::crud');
$routes->get('/admin/manage/static_pages/(:any)', 'StaticPages::manage_static_page/$1');
$routes->post('/admin/static_page/(:any)', 'StaticPages::crud/$1');
$routes->post('/admin/static/ubah_status', 'StaticPages::ubah_status');
//tinymce
$routes->post('/admin/upload/tinymce', 'StaticPages::tinymceUpload');
$routes->get('/admin/static_page/listGambar', 'StaticPages::listGambar');
$routes->post('/admin/static/deleteGambar', 'StaticPages::deleteGambar');
$routes->post('/admin/static/select_client', 'StaticPages::select_client');
$routes->post('/admin/static/select_produk', 'StaticPages::select_produk');


// client area
$routes->get('/client', 'Client::index');
$routes->post('/client', 'Client::index');
$routes->get('/client/sendmail', 'Client::sendEmail');
$routes->get('/clientlogout', 'Client::clientlogout');
$routes->get('/client/verify/(:any)', 'Client::verify/$1');
$routes->get('/client/verifikasi/(:any)', 'Client::verifikasi/$1');
$routes->get('/client/getOrder', 'Client::getOrder');

//homepage
$routes->post('/home/getContactUs', 'Home::getContactUs');
$routes->post('/home/getSlider', 'Home::getSlider');
$routes->post('/home/getService', 'Home::getService');
$routes->post('/home/getPortfolio', 'Home::getPortfolio');
$routes->post('/home/getTestimonial', 'Home::getTestimonial');
$routes->post('/home/getPartner', 'Home::getPartner');
$routes->post('/home/getOffer', 'Home::getOffer');
$routes->post('/home/getGroupProduct', 'Home::getGroupProduct');

$routes->post('/admin/order/getOrder', 'Order::getOrder');
$routes->post('/admin/order/getOrderSelesai', 'Order::getOrderSelesai');
$routes->get('/admin/order', 'Order::index');
$routes->get('/admin/orderSelesai', 'Order::orderSelesai');
$routes->post('/admin/order/tambahOrder', 'Order::tambahOrder');
$routes->post('/admin/order/ubahStatus', 'Order::ubahStatus');
$routes->post('/admin/order/deleteOrder', 'Order::deleteOrder');
$routes->post('/admin/order/addPayment', 'Order::addPayment');
$routes->get('/admin/order/paymentHistory', 'Order::paymentHistory');
$routes->post('/admin/order/deletePayment', 'Order::deletePayment');


$routes->get('/admin/order/getProducts', 'Order::getProducts');        // Rute untuk mendapatkan daftar produk
$routes->post('/admin/order/saveOrderProducts', 'Order::saveOrderProducts'); // Rute untuk menyimpan produk dalam order
$routes->get('/admin/order/detail/(:num)', 'Order::orderDetail/$1'); // Rute untuk menampilkan detail order berdasarkan ID order
$routes->post('admin/order/deleteProduct', 'Order::deleteProduct'); // Rute untuk menghapus produk dari order

$routes->get('/order/(:any)', 'Home::client/$1'); // Rute untuk menampilkan detail order berdasarkan ID order
$routes->post('/order/save', 'Home::save'); // Rute untuk menampilkan detail order berdasarkan ID order
$routes->get('order/showLogo/(:any)', 'Order::showLogo/$1');
$routes->post('order/deleteListOrder', 'Home::deleteListOrder');
$routes->get('/home/print/(:any)', 'Home::print/$1');

$routes->get('/exportExcel/(:any)', 'Home::exportExcel/$1');
$routes->post('updateAddress', 'Order::updateAddress');

$routes->get('/shipment/(:any)', 'Order::shipment/$1');
