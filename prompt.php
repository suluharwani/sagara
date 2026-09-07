<?php
/**
 * SAGARA JERSEY PRINTING - AI AGENT PROMPTS
 * 
 * File ini berisi semua prompt terstruktur untuk AI Agent
 * menjalankan pengembangan web dari FASE 0 sampai FASE 8.
 * 
 * Cara pakai:
 * 1. Salin prompt yang diinginkan
 * 2. Paste ke AI Agent
 * 3. AI Agent akan mengeksekusi otomatis
 * 
 * @package    SagaraJersey
 * @author     GitHub Copilot
 * @date       2026-09-07
 */

return [
    //================================================================================
    // FASE 0: PERSIAPAN & SETUP AWAL
    //================================================================================
    
    'fase_0' => [
        'title' => 'FASE 0: PERSIAPAN & SETUP AWAL',
        
        'task_0_1' => [
            'title' => 'Backup Database & Buat Migration untuk Tabel Baru',
            'prompt' => 'Buatkan migration CodeIgniter 4 untuk tabel-tabel baru yang dibutuhkan:

1. `cart` - id, user_id, product_id, size, color, quantity, price, created_at
2. `shipping_address` - id, user_id, name, phone, address, city, province, postal_code, is_default
3. `coupons` - id, code, type (percent/fixed), value, min_order, max_uses, used_count, expires_at, created_at
4. `order_status_history` - id, order_id, status, note, created_at
5. `notifications` - id, user_id, type, title, message, is_read, created_at
6. `settings` - id, key, value, description
7. Tambahkan field `price`, `sale_price`, `description`, `material` di tabel `product`
8. Tambahkan field `design_file` di tabel `order_list`

Simpan di app/Database/Migrations/ dan gunakan php spark make:migration'
        ],
        
        'task_0_2' => [
            'title' => 'Setup Konfigurasi Aplikasi',
            'prompt' => 'Edit file .env untuk menambahkan konfigurasi:
1. MIDTRANS_MERCHANT_ID = ""
2. MIDTRANS_CLIENT_KEY = ""
3. MIDTRANS_SERVER_KEY = ""
4. RAJAONGKIR_API_KEY = ""
5. RAJAONGKIR_TYPE = starter
6. WHATSAPP_NUMBER = "6281234567890"
7. SMTP_HOST = ""
8. SMTP_USER = ""
9. SMTP_PASS = ""
10. SMTP_PORT = 587

Buat juga file app/Config/Payment.php, app/Config/Shipping.php, app/Config/Notification.php'
        ],
    ],
    
    //================================================================================
    // FASE 1: E-COMMERCE CORE
    //================================================================================
    
    'fase_1' => [
        'title' => 'FASE 1: E-COMMERCE CORE (Minggu 1-2)',
        
        'task_1_1' => [
            'title' => 'Halaman Produk Publik (Product Catalog)',
            'prompt' => 'Buatkan halaman katalog produk yang menampilkan semua produk dengan fitur:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Product.php - tambahkan method `catalog()` dan `detail($slug)`
2. app/Views/home/content/product-catalog.php
3. app/Views/home/content/product-detail.php

FITUR:
- Tampilkan produk dalam grid (4 kolom desktop, 2 kolom mobile)
- Thumbnail produk, nama, harga, dan tombol "Lihat Detail"
- Pagination (12 produk per halaman)
- Filter by kategori/product_group
- Sorting (terbaru, termurah, terlaris)
- Search by nama produk

ROUTES:
$routes->get("product", "Product::catalog");
$routes->get("product/(:any)", "Product::detail/$1");'
        ],
        
        'task_1_2' => [
            'title' => 'Sistem Harga & Detail Produk',
            'prompt' => 'Buatkan halaman detail produk yang menampilkan informasi lengkap:

FILE: app/Views/home/content/product-detail.php

FITUR:
- Gallery gambar produk (zoom on hover)
- Nama produk
- Harga (coret harga lama jika ada diskon)
- Deskripsi produk
- Pilihan ukuran (S, M, L, XL, XXL) dari tabel `size`
- Pilihan warna (dropdown)
- Jumlah/quantity selector
- Tombol "Tambah ke Keranjang"
- Tombol "Beli via WhatsApp"
- Share ke social media (Facebook, Twitter, WhatsApp)
- Produk terkait (sama kategori)

CONTROLLER:
app/Controllers/Product.php - method detail($slug)
- Ambil data product berdasarkan slug
- Ambil data ukuran tersedia
- Ambil produk terkait (4 produk sama kategori)
- Pass data ke view'
        ],
        
        'task_1_3' => [
            'title' => 'Keranjang Belanja (Shopping Cart)',
            'prompt' => 'Buatkan sistem keranjang belanja menggunakan session:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Cart.php (baru)
2. app/Views/home/content/cart.php
3. app/Helpers/cart_helper.php (baru)

METHOD:
- index() - tampilkan isi keranjang
- add() - POST tambah produk ke keranjang
- update() - POST update quantity
- remove() - hapus item dari keranjang
- count() - return JSON jumlah item di keranjang
- clear() - kosongkan keranjang

FITUR:
- Tambah produk ke keranjang (dengan ukuran, warna, quantity)
- Tampilkan daftar item di keranjang
- Update quantity per item
- Hapus item dari keranjang
- Tampilkan subtotal per item
- Tampilkan total harga
- Tombol "Lanjut Checkout"
- Tombol "Kosongkan Keranjang"

ROUTES:
$routes->get("cart", "Cart::index");
$routes->post("cart/add", "Cart::add");
$routes->post("cart/update", "Cart::update");
$routes->get("cart/remove/(:any)", "Cart::remove/$1");
$routes->get("cart/count", "Cart::count");'
        ],
        
        'task_1_4' => [
            'title' => 'Cart Helper Functions',
            'prompt' => 'Buatkan file app/Helpers/cart_helper.php dengan fungsi:

1. addToCart($product, $size, $color, $qty) - tambah item ke session cart
2. updateCart($rowid, $qty) - update quantity
3. removeFromCart($rowid) - hapus item
4. getCart() - ambil semua item cart
5. countCart() - jumlah item di cart
6. totalCart() - total harga cart
7. clearCart() - hapus semua item cart

Struktur session cart:
cart = [
  rowid => [
    id, name, price, qty, size, color, image, subtotal ]
]'
        ],
        
        'task_1_5' => [
            'title' => 'Halaman Checkout',
            'prompt' => 'Buatkan halaman checkout dengan multi-step form:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Checkout.php (baru)
2. app/Views/home/content/checkout.php
3. app/Views/home/content/checkout-success.php

METHOD:
- index() - tampilkan form checkout
- process() - POST proses checkout
- success() - tampilkan halaman sukses

FITUR:
STEP 1 - Data Penerima:
- Nama penerima
- Nomor telepon
- Alamat lengkap
- Provinsi (dropdown dari API RajaOngkir)
- Kota (dropdown dari API RajaOngkir)
- Kode pos

STEP 2 - Pengiriman:
- Pilihan kurir (JNE, J&T, SiCepat, POS Indonesia)
- Pilihan paket (Regular, Express, SAME DAY)
- Estimasi hari pengiriman

STEP 3 - Pembayaran:
- Transfer Bank (BCA, Mandiri, BNI)
- E-Wallet (GoPay, OVO, Dana)
- Credit Card

STEP 4 - Ringkasan:
- Review semua item
- Total produk
- Total ongkir
- Total pembayaran
- Catatan (textarea)

ROUTES:
$routes->get("checkout", "Checkout::index");
$routes->post("checkout/process", "Checkout::process");
$routes->get("checkout/success/(:any)", "Checkout::success/$1");'
        ],
    ],
    
    //================================================================================
    // FASE 2: USER & AUTHENTICATION
    //================================================================================
    
    'fase_2' => [
        'title' => 'FASE 2: USER & AUTHENTICATION (Minggu 2)',
        
        'task_2_1' => [
            'title' => 'Registrasi Customer Manual',
            'prompt' => 'Buatkan sistem registrasi customer manual:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Register.php (baru)
2. app/Views/home/content/register.php
3. app/Views/emails/verification.php

METHOD:
- index() - tampilkan form registrasi
- process() - POST proses registrasi
- verify($token) - verifikasi email

FORM:
- Nama lengkap
- Email (unique)
- Password (min 8 karakter)
- Konfirmasi password
- Nomor telepon
- Checkbox "Saya menyetujui syarat dan ketentuan"

PROSES:
1. Validasi input
2. Hash password dengan bcrypt
3. Simpan ke tabel `client` dengan status "pending"
4. Generate token verifikasi
5. Kirim email verifikasi
6. Redirect ke halaman "cek email"

ROUTES:
$routes->get("register", "Register::index");
$routes->post("register/process", "Register::process");
$routes->get("register/verify/(:any)", "Register::verify/$1");'
        ],
        
        'task_2_2' => [
            'title' => 'Login Customer Manual',
            'prompt' => 'Buatkan sistem login customer manual:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Auth.php (baru)
2. app/Views/home/content/login.php

METHOD:
- index() - tampilkan form login
- process() - POST proses login
- logout() - logout user
- forgot() - tampilkan form lupa password
- reset($token) - reset password

FITUR:
- Login dengan email + password
- Remember me (cookie 30 hari)
- Link "Lupa Password?"
- Link "Belum punya akun? Daftar"
- Google OAuth (integrasi dengan yang sudah ada)

ROUTES:
$routes->get("login", "Auth::index");
$routes->post("login/process", "Auth::process");
$routes->get("logout", "Auth::logout");
$routes->get("forgot-password", "Auth::forgot");
$routes->post("forgot-password/process", "Auth::forgotProcess");
$routes->get("reset-password/(:any)", "Auth::reset/$1");'
        ],
        
        'task_2_3' => [
            'title' => 'Customer Dashboard',
            'prompt' => 'Buatkan dashboard customer setelah login:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Dashboard.php (baru)
2. app/Views/home/content/dashboard.php
3. app/Views/home/content/dashboard-orders.php
4. app/Views/home/content/dashboard-profile.php

METHOD:
- index() - tampilkan dashboard utama
- orders() - daftar order customer
- orderDetail($id) - detail order
- profile() - edit profil
- updateProfile() - POST update profil

FITUR:
- Ringkasan: total order, order aktif, total belanja
- Daftar order terbaru (status, tanggal, total)
- Detail order dengan tracking status
- Edit profil (nama, telepon, alamat)
- Ganti password
- Notifikasi

ROUTES:
$routes->get("dashboard", "Dashboard::index");
$routes->get("dashboard/orders", "Dashboard::orders");
$routes->get("dashboard/order/(:any)", "Dashboard::orderDetail/$1");
$routes->get("dashboard/profile", "Dashboard::profile");
$routes->post("dashboard/profile/update", "Dashboard::updateProfile");'
        ],
    ],
    
    //================================================================================
    // FASE 3: PAYMENT & ORDER
    //================================================================================
    
    'fase_3' => [
        'title' => 'FASE 3: PAYMENT & ORDER (Minggu 2-3)',
        
        'task_3_1' => [
            'title' => 'Payment Gateway Integration (Midtrans)',
            'prompt' => 'Buatkan integrasi payment gateway Midtrans:

FILE YANG DIBUTUHKAN:
1. app/Libraries/Midtrans.php (baru)
2. app/Controllers/Payment.php (baru)
3. app/Views/home/content/payment.php

INSTALL COMPOSER:
composer require midtrans/midtrans-php

LIBRARY (app/Libraries/Midtrans.php):
- __construct() - load Midtrans config
- createTransaction($orderData) - buat transaksi
- getStatus($orderId) - cek status
- handleNotification() - handle webhook

CONTROLLER (app/Controllers/Payment.php):
- index() - tampilkan halaman pembayaran
- pay() - POST proses bayar
- notification() - webhook dari Midtrans
- finish() - redirect setelah bayar
- unfailed() - pembayaran pending
- error() - pembayaran gagal

FITUR:
- Generate Snap Token
- Tampilkan popup Midtrans
- Handle status: settlement, pending, expire, cancel
- Update status order otomatis
- Kirim notifikasi email

ROUTES:
$routes->get("payment/(:any)", "Payment::index/$1");
$routes->post("payment/pay", "Payment::pay");
$routes->post("payment/notification", "Payment::notification");
$routes->get("payment/finish", "Payment::finish");
$routes->get("payment/unfailed", "Payment::unfailed");
$routes->get("payment/error", "Payment::error");'
        ],
        
        'task_3_2' => [
            'title' => 'Order Self-Service System',
            'prompt' => 'Buatkan sistem order self-service oleh customer:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Order.php - tambahkan method customer
2. app/Views/home/content/order-form.php
3. app/Views/home/content/order-upload.php

FITUR:
- Customer bisa buat order langsung
- Pilih produk, ukuran, warna, quantity
- Upload desain custom (PNG, JPG, PDF max 5MB)
- Preview sebelum submit
- Pilih metode pembayaran
- Terima nomor order untuk tracking

WORKFLOW:
1. Customer isi form order
2. Upload desain (opsional)
3. Pilih pengiriman
4. Pilih pembayaran
5. Bayar
6. Terima konfirmasi + nomor order

ROUTES:
$routes->get("order/create", "Order::create");
$routes->post("order/store", "Order::store");
$routes->get("order/confirmation/(:any)", "Order::confirmation/$1");'
        ],
        
        'task_3_3' => [
            'title' => 'Tracking Order Publik',
            'prompt' => 'Buatkan halaman tracking order publik:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Tracking.php (baru)
2. app/Views/home/content/tracking.php
3. app/Views/home/content/tracking-result.php

METHOD:
- index() - tampilkan form tracking
- search() - POST cari order
- result() - tampilkan hasil tracking

FITUR:
- Input nomor order + email
- Validasi order exists
- Tampilkan timeline status:
  ✓ Order diterima
  ✓ Diproses
  ✓ Dicetak
  ✓ Quality Control
  ✓ Dikemas
  ✓ Dikirim (dengan resi)
  ✓ Sampai tujuan
  ✓ Selesai
- Estimasi sampai
- Tombol hubungi CS

ROUTES:
$routes->get("tracking", "Tracking::index");
$routes->post("tracking/search", "Tracking::search");'
        ],
    ],
    
    //================================================================================
    // FASE 4: SHIPPING & LOGISTICS
    //================================================================================
    
    'fase_4' => [
        'title' => 'FASE 4: SHIPPING & LOGISTICS (Minggu 3)',
        
        'task_4_1' => [
            'title' => 'Integrasi RajaOngkir API',
            'prompt' => 'Buatkan integrasi ongkos kirim RajaOngkir:

FILE YANG DIBUTUHKAN:
1. app/Libraries/RajaOngkir.php (baru)
2. app/Controllers/Api/Shipping.php (baru)

LIBRARY (app/Libraries/RajaOngkir.php):
- __construct() - set API key
- getProvinces() - ambil daftar provinsi
- getCities($provinceId) - ambil daftar kota
- getSubdistricts($cityId) - ambil daftar kecamatan
- calculateCost($origin, $destination, $weight, $courier) - hitung ongkir
- trackWaybill($waybill, $courier) - lacak resi

CONTROLLER (app/Controllers/Api/Shipping.php):
- provinces() - return JSON provinsi
- cities($provinceId) - return JSON kota
- cost() - POST hitung ongkir
- track() - POST lacak resi

ROUTES:
$routes->get("api/shipping/provinces", "Api\Shipping::provinces");
$routes->get("api/shipping/cities/(:any)", "Api\Shipping::cities/$1");
$routes->post("api/shipping/cost", "Api\Shipping::cost");
$routes->post("api/shipping/track", "Api\Shipping::track");'
        ],
        
        'task_4_2' => [
            'title' => 'Fitur Upload Desain Custom',
            'prompt' => 'Buatkan fitur upload desain custom oleh customer:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Design.php (baru)
2. app/Views/home/content/upload-design.php

METHOD:
- index() - tampilkan form upload
- upload() - POST proses upload
- preview() - preview desain

FITUR:
- Drag & drop upload area
- Preview gambar sebelum upload
- Validasi: PNG, JPG, PDF, SVG (max 5MB)
- Auto-rename file (unique)
- Simpan ke writable/uploads/designs/
- Tampilkan di halaman order

VIEW:
app/Views/home/content/upload-design.php
- Upload area dengan drag & drop
- Progress bar
- Preview thumbnail
- Tombol hapus & ganti

ROUTES:
$routes->get("design/upload", "Design::index");
$routes->post("design/upload", "Design::upload");
$routes->get("design/preview/(:any)", "Design::preview/$1");'
        ],
    ],
    
    //================================================================================
    // FASE 5: MARKETING & ENGAGEMENT
    //================================================================================
    
    'fase_5' => [
        'title' => 'FASE 5: MARKETING & ENGAGEMENT (Minggu 3-4)',
        
        'task_5_1' => [
            'title' => 'WhatsApp Integration',
            'prompt' => 'Buatkan integrasi WhatsApp:

FILE YANG DIBUTUHKAN:
1. app/Helpers/whatsapp_helper.php (baru)
2. app/Views/home/layout/whatsapp-float.php

HELPER FUNCTIONS:
- waBaseUrl() - return wa.me URL
- waLink($phone, $text) - generate WhatsApp link
- waOrderLink($orderData) - link untuk order
- waProductLink($product) - link untuk tanya produk

VIEW (app/Views/home/layout/whatsapp-float.php):
- Floating button (pojok kanan bawah)
- Tooltip "Chat CS Kami"
- Buka chat dengan pesan default
- Pesan: "Halo Sagara, saya ingin bertanya tentang..."

FITUR:
- Tombol "Order via WhatsApp" di produk
- Kirim detail produk otomatis
- CS WhatsApp button (floating)
- Format pesan: nama produk, ukuran, quantity'
        ],
        
        'task_5_2' => [
            'title' => 'Discount & Coupon System',
            'prompt' => 'Buatkan sistem kupon diskon:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Coupon.php (baru)
2. app/Views/home/content/coupon-apply.php
3. app/Views/admin/content/coupon-manage.php

METHOD CUSTOMER:
- apply() - POST apply kpon ke checkout
- remove() - hapus kpon dari checkout

METHOD ADMIN:
- index() - daftar kpon
- create() - buat kpon baru
- store() - POST simpan kpon
- edit($id) - edit kpon
- update($id) - POST update kpon
- delete($id) - hapus kpon

FITUR:
- Kode kpon unik
- Tipe diskon: persen (%) atau nominal (Rp)
- Minimum belanja
- Maksimal penggunaan
- Tanggal expired
- Validasi di checkout
- Tampilkan penghematan di total

ROUTES:
$routes->post("coupon/apply", "Coupon::apply");
$routes->get("coupon/remove", "Coupon::remove");
$routes->get("admin/coupon", "Coupon::index");
$routes->get("admin/coupon/create", "Coupon::create");
$routes->post("admin/coupon/store", "Coupon::store");
$routes->get("admin/coupon/edit/(:any)", "Coupon::edit/$1");
$routes->post("admin/coupon/update/(:any)", "Coupon::update/$1");
$routes->get("admin/coupon/delete/(:any)", "Coupon::delete/$1");'
        ],
        
        'task_5_3' => [
            'title' => 'Invoice PDF Generator',
            'prompt' => 'Buatkan generator invoice PDF:

INSTALL COMPOSER:
composer require dompdf/dompdf

FILE YANG DIBUTUHKAN:
1. app/Libraries/Pdf.php (baru)
2. app/Controllers/Invoice.php (baru)
3. app/Views/pdf/invoice.php

LIBRARY (app/Libraries/Pdf.php):
- generateInvoice($orderData) - generate PDF invoice
- streamInvoice($orderData) - stream/download PDF
- saveInvoice($orderData) - simpan ke server

CONTROLLER (app/Controllers/Invoice.php):
- index($orderId) - tampilkan invoice HTML
- download($orderId) - download PDF
- email($orderId) - kirim invoice via email

VIEW (app/Views/pdf/invoice.php):
- Header: logo, nama perusahaan, alamat
- Info order: nomor, tanggal, status
- Data customer: nama, alamat, telepon
- Tabel item: produk, qty, harga, subtotal
- Ringkasan: subtotal, ongkir, diskon, total
- Info rekening pembayaran
- Footer: terima kasih + catatan

ROUTES:
$routes->get("invoice/(:any)", "Invoice::index/$1");
$routes->get("invoice/download/(:any)", "Invoice::download/$1");
$routes->post("invoice/email/(:any)", "Invoice::email/$1");'
        ],
    ],
    
    //================================================================================
    // FASE 6: REPORTING & ANALYTICS
    //================================================================================
    
    'fase_6' => [
        'title' => 'FASE 6: REPORTING & ANALYTICS (Minggu 4)',
        
        'task_6_1' => [
            'title' => 'Dashboard Admin Enhanced',
            'prompt' => 'Buatkan dashboard admin yang lebih informatif:

FILE: app/Views/admin/content/dashboard-enhanced.php

FITUR:
- Total pendapatan (hari ini, bulan ini, total)
- Total order (hari ini, bulan ini, total)
- Grafik penjualan (7 hari terakhir, 30 hari)
- Top 5 produk terlaris
- Top 5 customer terbanyak
- Order terbutuh (perlu diproses)
- Statistik status order (pie chart)
- Notifikasi order baru

CHART:
- Menggunakan Chart.js (CDN)
- Line chart: pendapatan harian
- Bar chart: produk terlaris
- Pie chart: status order'
        ],
        
        'task_6_2' => [
            'title' => 'Laporan Keuangan',
            'prompt' => 'Buatkan halaman laporan keuangan:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Report.php (baru)
2. app/Views/admin/content/report.php
3. app/Views/admin/content/report-print.php

METHOD:
- index() - tampilkan laporan
- sales() - laporan penjualan
- financial() - laporan keuangan
- customers() - laporan customer
- exportExcel() - export ke Excel
- exportPDF() - export ke PDF

FILTER:
- Rentang tanggal (date picker)
- Status order
- Metode pembayaran
- Produk

FITUR:
- Tabel laporan dengan pagination
- Total pendapatan, pengeluaran, profit
- Export Excel (PhpSpreadsheet)
- Export PDF (DomPDF)
- Print view'
        ],
        
        'task_6_3' => [
            'title' => 'SEO Optimization',
            'prompt' => 'Buatkan fitur SEO dasar:

FILE YANG DIBUTUHKAN:
1. app/Controllers/Sitemap.php (baru)
2. app/Views/seo/meta.php

SITEMAP:
- index() - tampilkan sitemap XML
- generate() - generate sitemap.xml

META TAGS (app/Views/seo/meta.php):
- Dynamic title per halaman
- Dynamic meta description
- Open Graph tags (og:title, og:description, og:image, og:url)
- Twitter Card tags
- Canonical URL
- Meta robots

HALAMAN YANG Perlu Dioptimasi:
- Homepage
- Katalog produk
- Detail produk
- Blog
- Halaman informasi

ROUTES:
$routes->get("sitemap.xml", "Sitemap::index");'
        ],
    ],
    
    //================================================================================
    // FASE 7: SECURITY & OPTIMIZATION
    //================================================================================
    
    'fase_7' => [
        'title' => 'FASE 7: SECURITY & OPTIMIZATION (Minggu 4)',
        
        'task_7_1' => [
            'title' => 'Rate Limiting & Security',
            'prompt' => 'Buatkan fitur keamanan tambahan:

FILE YANG DIBUTUHKAN:
1. app/Filters/RateLimit.php (baru)
2. app/Filters/AuthCustomer.php (baru)

RATE LIMIT FILTER:
- Batasi request per menit
- Login: 5 request/menit
- Register: 3 request/menit
- API: 60 request/menit
- Return 429 jika exceed

AUTH CUSTOMER FILTER:
- Cek session customer login
- Redirect ke login jika belum
- Cek role/level user

TAMBAHAN:
- CSRF protection (sudah ada CI4)
- XSS filtering (sudah ada CI4)
- SQL injection prevention (query builder)
- Password hashing (bcrypt)
- Input validation (strict)

CONFIG:
app/Config/Filters.php - daftarkan filter baru'
        ],
        
        'task_7_2' => [
            'title' => 'Image Optimization',
            'prompt' => 'Buatkan library optimasi gambar:

FILE: app/Libraries/ImageOptimizer.php

FITUR:
- resize($path, $width, $height) - resize gambar
- compress($path, $quality) - kompres (0-100)
- convertToWebP($path) - convert ke WebP
- createThumbnail($path, $size) - buat thumbnail
- autoOptimize($path) - auto resize + kompress

UKURAN THUMBNAIL:
- Small: 150x150 (cart, thumbnail)
- Medium: 400x400 (product catalog)
- Large: 800x800 (product detail)
- XL: 1200x1200 (zoom)

AUTO OPTIMIZE:
- Saat upload produk
- Saat upload desain customer
- Maksimal width: 1200px
- Kualitas: 80%
- Format: WebP jika didukung'
        ],
    ],
    
    //================================================================================
    // FASE 8: DEPLOYMENT & TESTING
    //================================================================================
    
    'fase_8' => [
        'title' => 'FASE 8: DEPLOYMENT & TESTING (Minggu 4-5)',
        
        'task_8_1' => [
            'title' => 'Testing',
            'prompt' => 'Buatkan test suite untuk fitur baru:

FILE YANG DIBUTUHKAN:
1. tests/app/Controllers/CartTest.php
2. tests/app/Controllers/CheckoutTest.php
3. tests/app/Controllers/PaymentTest.php
4. tests/app/Libraries/MidtransTest.php
5. tests/app/Libraries/RajaOngkirTest.php

UNIT TEST:
- Test model methods
- Test helper functions
- Test library methods

FEATURE TEST:
- Test registrasi customer
- Test login/logout
- Test tambah ke keranjang
- Test checkout flow
- Test payment process

RUN TEST:
php spark test'
        ],
        
        'task_8_2' => [
            'title' => 'Deployment Checklist',
            'prompt' => 'Buatkan checklist deployment:

PRODUCTION CHECKLIST:
□ Set CI_ENVIRONMENT = production
□ Disable debug mode
□ Set database production
□ Set Midtrans production keys
□ Set RajaOngkir production key
□ Set SMTP production
□ Enable CSRF protection
□ Set baseURL production
□ Optimize composer: composer install --optimize-autoloader --no-dev
□ Set folder permissions (writable 755)
□ Enable HTTPS
□ Setup cron job (backup, notification)
□ Test semua fitur
□ Go live!'
        ],
    ],
    
    //================================================================================
    // PROMPT END-TO-END UNTUK AI AGENT
    //================================================================================
    
    'end_to_end' => [
        'prompt_1' => [
            'fase' => 'FASE 0',
            'prompt' => 'Implement TASK 0.1 dan 0.2 dari roadmap. Buat migration untuk tabel baru dan setup konfigurasi. Pastikan semua migration berhasil dijalankan dengan php spark migrate.'
        ],
        'prompt_2' => [
            'fase' => 'FASE 1',
            'prompt' => 'Implement TASK 1.1 sampai 1.5 dari roadmap. Buat halaman katalog produk, detail produk, keranjang belanja, dan checkout. Pastikan semua fitur berjalan dengan baik dan responsive.'
        ],
        'prompt_3' => [
            'fase' => 'FASE 2',
            'prompt' => 'Implement TASK 2.1 sampai 2.3 dari roadmap. Buat registrasi customer manual, login manual, dan dashboard customer. Integrasikan dengan Google OAuth yang sudah ada.'
        ],
        'prompt_4' => [
            'fase' => 'FASE 3',
            'prompt' => 'Implement TASK 3.1 sampai 3.3 dari roadmap. Buat integrasi Midtrans, order self-service, dan tracking publik. Test dengan sandbox Midtrans.'
        ],
        'prompt_5' => [
            'fase' => 'FASE 4',
            'prompt' => 'Implement TASK 4.1 dan 4.2 dari roadmap. Buat integrasi RajaOngkir dan upload desain custom. Pastikan kalkulasi ongkir akurat.'
        ],
        'prompt_6' => [
            'fase' => 'FASE 5',
            'prompt' => 'Implement TASK 5.1 sampai 5.3 dari roadmap. Buat integrasi WhatsApp, sistem kupon, dan invoice PDF. Test generate PDF.'
        ],
        'prompt_7' => [
            'fase' => 'FASE 6',
            'prompt' => 'Implement TASK 6.1 sampai 6.3 dari roadmap. Buat dashboard enhanced, laporan keuangan, dan optimasi SEO. Test export Excel dan PDF.'
        ],
        'prompt_8' => [
            'fase' => 'FASE 7',
            'prompt' => 'Implement TASK 7.1 dan 7.2 dari roadmap. Buat rate limiting dan optimasi gambar. Pastikan keamanan terjaga.'
        ],
        'prompt_9' => [
            'fase' => 'FASE 8',
            'prompt' => 'Implement TASK 8.1 dan 8.2 dari roadmap. Buat test suite dan jalankan deployment checklist. Pastikan semua test pass.'
        ],
    ],
    
    //================================================================================
    // CATATAN PENTING
    //================================================================================
    
    'notes' => [
        'after_each_task' => [
            'Test fitur yang dibuat',
            'Pastikan tidak ada error',
            'Commit perubahan ke Git',
            'Lanjut ke task berikutnya',
        ],
        'best_practices' => [
            'Validasi semua input user',
            'Gunakan CSRF token di form',
            'Hash password dengan bcrypt',
            'Gunakan prepared statement',
            'Log semua aktivitas penting',
            'Buat komentar di kode',
            'Buat dokumentasi API',
        ],
        'troubleshooting' => [
            'Jika error, cek writable/logs/',
            'Jika migration error, cek urutan timestamp',
            'Jika library error, cek composer install',
            'Jika view error, cek path file',
        ],
    ],
];
