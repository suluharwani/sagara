================================================================================
  SAGARA JERSEY - DEPLOYMENT CHECKLIST
================================================================================

□ SETUP ENVIRONMENT
  □ Set CI_ENVIRONMENT = production di .env
  □ Disable debug mode
  □ Set display_errors = Off di php.ini

□ DATABASE
  □ Setup database production
  □ Update credentials di .env
  □ Run migration: php spark migrate
  □ Test koneksi database

□ PAYMENT GATEWAY
  □ Daftar Midtrans (midtrans.com)
  □ Get Production Client Key & Server Key
  □ Update .env dengan production keys
  □ Setup webhook URL
  □ Test payment sandbox

□ SHIPPING
  □ Daftar RajaOngkir (rajaongkir.com)
  □ Get API Key
  □ Set origin city ID
  □ Update .env

□ EMAIL
  □ Setup SMTP (Gmail/SES/Custom)
  □ Update .env dengan SMTP credentials
  □ Test email sending

□ SECURITY
  □ Setup SSL/HTTPS
  □ Enable CSRF protection
  □ Setup rate limiting
  □ Backup strategy

□ DEPLOYMENT
  □ Upload files to server
  □ Setup baseURL production
  □ Optimize composer: composer install --optimize-autoloader --no-dev
  □ Set folder permissions (writable 755)
  □ Test all features

□ POST-LAUNCH
  □ Setup monitoring
  □ Setup backup schedule
  □ Setup analytics
  □ Test payment flow
  □ Go live!

================================================================================
  TEST SUITE
================================================================================

TEST: Product Catalog
  □ Buka /product
  □ Test search produk
  □ Test filter kategori
  □ Test sorting (terbaru, termurah, termahal)
  □ Test pagination
  □ Klik detail produk

TEST: Product Detail
  □ Buka /product/{slug}
  □ Cek gambar produk
  □ Cek harga & deskripsi
  □ Pilih ukuran
  □ Set quantity
  □ Klik "Tambah ke Keranjang"
  □ Klik "Beli via WhatsApp"

TEST: Cart
  □ Buka /cart
  □ Cek item di keranjang
  □ Update quantity
  □ Hapus item
  □ Kosongkan keranjang

TEST: Checkout
  □ Tambah produk ke keranjang
  □ Buka /checkout
  □ Isi data penerima
  □ Pilih kurir
  □ Pilih pembayaran
  □ Submit order
  □ Cek halaman success

TEST: Customer Auth
  □ Buka /register
  □ Daftar akun baru
  □ Verifikasi email
  □ Login dengan akun baru
  □ Buka dashboard
  □ Edit profil
  □ Logout

TEST: Tracking
  □ Buka /tracking
  □ Input nomor order + email
  □ Cek status order
  □ Cek riwayat status

TEST: Payment
  □ Buat order
  □ Lanjut pembayaran
  □ Test payment sandbox
  □ Cek notifikasi payment

TEST: Admin
  □ Login admin
  □ Cek dashboard
  □ Cek laporan
  □ Export Excel

================================================================================
  DOKUMENTASI TEKNIS
================================================================================

API ENDPOINTS:

Shipping API:
  GET /api/shipping/provinces - Get provinces list
  GET /api/shipping/cities/{provinceId} - Get cities by province
  POST /api/shipping/cost - Calculate shipping cost
  POST /api/shipping/track - Track waybill

Payment:
  POST /payment/pay - Create payment transaction
  POST /payment/notification - Midtrans webhook
  GET /payment/finish - Payment success
  GET /payment/unfailed - Payment pending
  GET /payment/error - Payment failed

Cart:
  GET /cart - View cart
  POST /cart/add - Add item to cart
  POST /cart/update - Update cart item
  GET /cart/remove/{rowid} - Remove cart item
  GET /cart/count - Get cart count (JSON)

Checkout:
  GET /checkout - Checkout page
  POST /checkout/process - Process checkout
  GET /checkout/success/{orderNumber} - Success page

AUTH:
  GET /register - Registration page
  POST /register/process - Process registration
  GET /register/verify/{token} - Email verification
  GET /login - Login page
  POST /login/process - Process login
  GET /logout - Logout
  GET /forgot-password - Forgot password
  POST /forgot-password/process - Process forgot password
  GET /reset-password/{token} - Reset password

Dashboard:
  GET /dashboard - Customer dashboard
  GET /dashboard/orders - Order list
  GET /dashboard/order/{id} - Order detail
  GET /dashboard/profile - Profile page
  POST /dashboard/profile/update - Update profile

Tracking:
  GET /tracking - Tracking page
  POST /tracking/search - Search order

================================================================================
  Dibuat oleh: GitHub Copilot
  Tanggal: 2026-09-07
  Proyek: Sagara Jersey Printing Website
================================================================================
