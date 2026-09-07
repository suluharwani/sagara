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

// PUBLIC PRODUCT & E-COMMERCE
$routes->get('product', 'Product::catalog');
$routes->get('product/(:any)', 'Product::detail/$1');
$routes->get('portfolio', 'Portfolio::index');

// RESELLER PUBLIC & DASHBOARD
$routes->get('reseller', 'Reseller::index');
$routes->get('reseller/register', 'Reseller::register');
$routes->post('reseller/register', 'Reseller::registerStore', ['filter' => 'csrf']);
$routes->get('reseller/dashboard', 'Reseller::dashboard', ['filter' => 'authCustomer']);
$routes->get('reseller/products', 'Reseller::products', ['filter' => 'authCustomer']);
$routes->get('reseller/quotes', 'Reseller::quotes', ['filter' => 'authCustomer']);
$routes->get('reseller/quotes/create', 'Reseller::quoteCreate', ['filter' => 'authCustomer']);
$routes->post('reseller/quotes', 'Reseller::quoteStore', ['filter' => 'authCustomer,csrf']);
$routes->get('reseller/quotes/(:num)', 'Reseller::quoteDetail/$1', ['filter' => 'authCustomer']);
$routes->post('reseller/quotes/(:num)/status', 'Reseller::quoteStatus/$1', ['filter' => 'authCustomer,csrf']);

// CART
$routes->get('cart', 'Cart::index');
$routes->post('cart/add', 'Cart::add');
$routes->post('cart/update', 'Cart::update');
$routes->get('cart/remove/(:any)', 'Cart::remove/$1');
$routes->get('cart/count', 'Cart::count');

// CHECKOUT
$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/process', 'Checkout::process');
$routes->get('checkout/success/(:any)', 'Checkout::success/$1');

// AUTH CUSTOMER
$routes->get('login', 'Auth::index');
$routes->post('login/process', 'Auth::process', ['filter' => 'csrf']);
$routes->get('logout', 'Auth::logout');
$routes->get('register', 'Register::index');
$routes->post('register/process', 'Register::process', ['filter' => 'csrf']);
$routes->get('register/verify/(:any)', 'Register::verify/$1');
$routes->get('forgot-password', 'Auth::forgot');
$routes->post('forgot-password/process', 'Auth::forgotProcess', ['filter' => 'csrf']);
$routes->get('reset-password/(:any)', 'Auth::reset/$1');

// CUSTOMER DASHBOARD
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'authCustomer']);
$routes->get('dashboard/orders', 'Dashboard::orders', ['filter' => 'authCustomer']);
$routes->get('dashboard/order/(:any)', 'Dashboard::orderDetail/$1', ['filter' => 'authCustomer']);
$routes->get('dashboard/profile', 'Dashboard::profile', ['filter' => 'authCustomer']);
$routes->post('dashboard/profile/update', 'Dashboard::updateProfile', ['filter' => 'authCustomer,csrf']);

// ORDER SELF-SERVICE
$routes->get('order/create', 'Order::create');
$routes->post('order/store', 'Order::store');
$routes->get('order/confirmation/(:any)', 'Order::confirmation/$1');

// TRACKING
$routes->get('tracking', 'Tracking::index');
$routes->post('tracking/search', 'Tracking::search');

// INVOICE
$routes->get('invoice/(:any)', 'Invoice::index/$1');
$routes->get('invoice/download/(:any)', 'Invoice::download/$1');
$routes->post('invoice/email/(:any)', 'Invoice::email/$1');

// DESIGN UPLOAD
$routes->get('design/upload', 'Design::index');
$routes->post('design/upload', 'Design::upload');
$routes->get('design/preview/(:any)', 'Design::preview/$1');

// COUPON
$routes->post('coupon/apply', 'Coupon::apply');
$routes->get('coupon/remove', 'Coupon::remove');

// PAYMENT
$routes->get('payment/(:any)', 'Payment::index/$1');
$routes->post('payment/pay', 'Payment::pay');
$routes->post('payment/notification', 'Payment::notification');
$routes->get('payment/finish', 'Payment::finish');
$routes->get('payment/unfailed', 'Payment::unfailed');
$routes->get('payment/error', 'Payment::error');

// SHIPPING API
$routes->get('api/shipping/provinces', 'Api\Shipping::provinces');
$routes->get('api/shipping/cities/(:any)', 'Api\Shipping::cities/$1');
$routes->post('api/shipping/cost', 'Api\Shipping::cost');
$routes->post('api/shipping/track', 'Api\Shipping::track');

// SITEMAP
$routes->get('sitemap.xml', 'Sitemap::index');

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
$routes->post('/home/updateAddress', 'Home::updateAddress');

$routes->post('/admin/order/getOrder', 'Order::getOrder');
$routes->post('/admin/order/getOrderSelesai', 'Order::getOrderSelesai');
$routes->get('/admin/order', 'Order::index');
$routes->get('/admin/orderSelesai', 'Order::orderSelesai');
$routes->post('/admin/order/tambahOrder', 'Order::tambahOrder');
$routes->post('/admin/order/ubahStatus', 'Order::ubahStatus');
$routes->post('/admin/order/updateResi', 'Order::updateResi');
$routes->post('/admin/order/deleteOrder', 'Order::deleteOrder');
$routes->post('/admin/order/addPayment', 'Order::addPayment');
$routes->get('/admin/order/paymentHistory', 'Order::paymentHistory');
$routes->post('/admin/order/deletePayment', 'Order::deletePayment');


$routes->get('/admin/order/getProducts', 'Order::getProducts');        // Rute untuk mendapatkan daftar produk
$routes->post('/admin/order/saveOrderProducts', 'Order::saveOrderProducts'); // Rute untuk menyimpan produk dalam order
$routes->get('/admin/order/detail/(:num)', 'Order::orderDetail/$1'); // Rute untuk menampilkan detail order berdasarkan ID order
$routes->post('admin/order/deleteProduct', 'Order::deleteProduct'); // Rute untuk menghapus produk dari order
$routes->post('admin/order/getOrderData', 'Order::getOrderData'); // Rute untuk menghapus produk dari order

$routes->get('/order/(:any)', 'Home::client/$1'); // Rute untuk menampilkan detail order berdasarkan ID order
$routes->post('/order/save', 'Home::save'); // Rute untuk menampilkan detail order berdasarkan ID order
$routes->get('order/showLogo/(:any)', 'Order::showLogo/$1');
$routes->post('order/deleteListOrder', 'Home::deleteListOrder');
$routes->get('/home/print/(:any)', 'Home::print/$1');
$routes->get('/home/invoice/(:any)', 'Home::invoice/$1');

$routes->get('/exportExcel/(:any)', 'Home::exportExcel/$1');
$routes->post('updateAddress', 'Order::updateAddress');

$routes->get('/shipment/(:any)', 'Order::shipment/$1');

$routes->get('home/getOrder/(:num)', 'Home::getOrder/$1');
$routes->post('home/saveOrder', 'Home::saveOrder');
$routes->post('home/saveAlamat', 'Home::saveAlamat');

// ADMIN PRODUCT UMUM (CRUD)
$routes->get('admin/product-umum', 'ProductUmum::index');
$routes->post('admin/product-umum/create', 'ProductUmum::create');
$routes->post('admin/product-umum/update/(:any)', 'ProductUmum::update/$1');
$routes->get('admin/product-umum/delete/(:any)', 'ProductUmum::delete/$1');
$routes->get('admin/product-umum/detail/(:any)', 'ProductUmum::detail/$1');
$routes->post('admin/product-umum/listdata', 'ProductUmum::listdata');

// RESELLER ADMIN
$routes->get('admin/resellers', 'AdminReseller::index');
$routes->post('admin/resellers/(:num)/status', 'AdminReseller::updateStatus/$1', ['filter' => 'csrf']);
$routes->get('admin/reseller-products', 'AdminReseller::products');
$routes->get('admin/reseller-products/edit/(:num)', 'AdminReseller::products/$1');
$routes->post('admin/reseller-products', 'AdminReseller::productStore', ['filter' => 'csrf']);
$routes->post('admin/reseller-products/(:num)', 'AdminReseller::productUpdate/$1', ['filter' => 'csrf']);
$routes->post('admin/reseller-products/(:num)/delete', 'AdminReseller::productDelete/$1', ['filter' => 'csrf']);

// GOOGLE LOGIN
$routes->get('login/google', 'Auth::google');
$routes->get('login/google-callback', 'Auth::googleCallback');

// LAYANAN PAGE
$routes->get('layanan', 'Home::layanan');

// ABOUT PAGE
$routes->get('tentang-kami', 'Home::tentangKami');

// ADMIN REPORT ROUTES
$routes->get('admin/report', 'Report::index');
$routes->get('admin/report/product', 'Report::product');
$routes->get('admin/report/order', 'Report::order');
$routes->get('admin/report/exportExcel', 'Report::exportExcel');

// ADMIN CONTENT ROUTES
$routes->get('admin/blog', 'Admin::blog');
$routes->get('admin/informations', 'Admin::informations');
$routes->get('admin/slider', 'Admin::slider');
$routes->get('admin/gallery', 'Admin::gallery');
$routes->get('admin/testimonial', 'Admin::testimonial');
$routes->get('admin/client', 'Admin::client');
$routes->get('admin/administrator', 'Admin::administrator');
$routes->get('admin/changelog', 'Admin::changelog');
$routes->get('admin/settings', 'Admin::settings');

// ADMIN MENU ROUTES
$routes->get('admin/slider', 'Admin::slider');
$routes->get('admin/gallery', 'Admin::gallery');
$routes->get('admin/testimonial', 'Admin::testimonial');
$routes->get('admin/blog', 'Admin::blog');
$routes->get('admin/informations', 'Admin::informations');
$routes->get('admin/changelog', 'Admin::changelog');
$routes->get('admin/settings', 'Admin::settings');

// ADMIN CALENDAR ROUTES
$routes->get('admin/calendar', 'Admin::calendar');
$routes->post('admin/calendar/add', 'Admin::addCalendarEvent');
$routes->get('admin/calendar/delete/(:any)', 'Admin::deleteCalendarEvent/$1');

// ADMIN SETTINGS ROUTE
$routes->get('admin/settings', 'Admin::settings');
$routes->post('admin/settings', 'Admin::settings');

// HOLIDAY ROUTES
$routes->get('admin/holiday', 'Holiday::index');
$routes->post('admin/holiday/add', 'Holiday::add');
$routes->post('admin/holiday/update/(:any)', 'Holiday::update/$1');
$routes->get('admin/holiday/delete/(:any)', 'Holiday::delete/$1');

// PRINT CALENDAR
$routes->get('admin/calendar/print', 'Admin::printCalendar');
