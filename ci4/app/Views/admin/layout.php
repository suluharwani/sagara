<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sagara Jersey</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/admin/admin.css') ?>" rel="stylesheet">
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <h4>Sagara <span>Jersey</span></h4>
        </div>
        <nav class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin') ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
            </ul>
            
            <div class="menu-label">Produk & Order</div>
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/product') ?>">
                        <i class="fas fa-images"></i> Portfolio Desain
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/reseller-products') ?>">
                        <i class="fas fa-box-open"></i> Produk Reseller
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/resellers') ?>">
                        <i class="fas fa-handshake"></i> Reseller
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/product-umum') ?>">
                        <i class="fas fa-box"></i> Produk Umum
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/order') ?>">
                        <i class="fas fa-shopping-cart"></i> Order
                    </a>
                </li>
            </ul>
            
            <div class="menu-label">Manajemen</div>
            <ul class="list-unstyled">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/custom-designs') ?>"><i class="fas fa-palette"></i> Desain Custom</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/design-templates') ?>"><i class="fas fa-swatchbook"></i> Template Desain</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/manage/pages') ?>">
                        <i class="fas fa-file-alt"></i> Halaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/manage/static_pages') ?>">
                        <i class="fas fa-file"></i> Halaman Statis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/administrator') ?>">
                        <i class="fas fa-user-shield"></i> Administrator
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/client') ?>">
                        <i class="fas fa-user"></i> Client
                    </a>
                </li>
            </ul>
            
            <div class="menu-label">Konten Website</div>
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/blog') ?>">
                        <i class="fas fa-newspaper"></i> Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/informations') ?>">
                        <i class="fas fa-info-circle"></i> Informasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/slider') ?>">
                        <i class="fas fa-images"></i> Slider
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/gallery') ?>">
                        <i class="fas fa-photo-video"></i> Gallery
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/testimonial') ?>">
                        <i class="fas fa-comment-dots"></i> Testimonial
                    </a>
                </li>
            </ul>
            
            <div class="menu-label">Laporan & Sistem</div>
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/report') ?>">
                        <i class="fas fa-chart-bar"></i> Laporan Penjualan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/report/product') ?>">
                        <i class="fas fa-box-open"></i> Laporan Produk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/report/order') ?>">
                        <i class="fas fa-file-invoice"></i> Laporan Order
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/calendar') ?>">
                        <i class="fas fa-calendar-alt"></i> Kalender
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/changelog') ?>">
                        <i class="fas fa-history"></i> Changelog
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('admin/settings') ?>">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    
    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <button class="btn-sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari...">
                </div>
            </div>
            <div class="header-right">
                <div class="user-dropdown">
                    <img src="<?= base_url('assets/template/dist/assets/images/faces/2.jpg') ?>" alt="Avatar">
                    <div class="user-info">
                        <h6>Admin</h6>
                        <small>Administrator</small>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content -->
        <div class="admin-content">
            <?= $content ?? '' ?>
        </div>
        
        <!-- Footer -->
        <footer class="admin-footer">
            <p>&copy; 2026 Sagara Jersey. All Rights Reserved.</p>
        </footer>
    </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= base_url('assets/js/admin/admin.js') ?>"></script>
</body>
</html>
