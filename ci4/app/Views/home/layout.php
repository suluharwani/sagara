<?php $navCustomer = session()->get('customer'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sagara Jersey - Custom Wear untuk Tim Anda</title>
    <meta name="description" content="Jersey, kaos, dan apparel custom untuk tim, komunitas, dan event. Jelajahi produk atau konsultasikan desain Anda bersama Sagara Jersey.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/layout.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/auth-sagara.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/reseller.css') ?>" rel="stylesheet">
    <script>document.documentElement.classList.add('js');</script>
</head>
<body>

<a class="skip-link" href="#main-content">Lewati ke konten utama</a>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>" aria-label="Sagara Jersey, kembali ke beranda">
            <span class="brand-mark">S</span>
            <span class="brand-name">Sagara <strong>Jersey</strong></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('portfolio') ?>">Portfolio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>#ready-title">Siap Pakai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('layanan') ?>">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('reseller') ?>">Reseller</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('tracking') ?>"><i class="fas fa-location-dot me-1"></i>Lacak Order</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link btn-login" href="<?= $navCustomer ? base_url(($navCustomer['account_type'] ?? 'customer') === 'reseller' ? 'reseller/dashboard' : 'dashboard') : base_url('login') ?>">
                        <i class="fas fa-user me-1"></i> <?= $navCustomer ? 'Dashboard' : 'Masuk' ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main id="main-content">
    <?= $content ?? '' ?>
</main>

<!-- Footer -->
<footer class="footer-custom">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <a class="footer-brand" href="<?= base_url() ?>"><span class="brand-mark">S</span> Sagara Jersey</a>
                <p class="footer-intro">Apparel custom yang membantu identitas tim Anda terlihat solid - dari ide sampai siap dikenakan.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook Sagara Jersey"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram Sagara Jersey"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/6281327341834" target="_blank" rel="noopener" aria-label="WhatsApp Sagara Jersey"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2">
                <h5>Jelajahi</h5>
                <ul>
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= base_url('portfolio') ?>">Portfolio</a></li>
                    <li><a href="<?= base_url('reseller') ?>">Program Reseller</a></li>
                    <li><a href="<?= base_url() ?>#ready-title">Produk Siap Pakai</a></li>
                    <li><a href="<?= base_url('blog') ?>">Blog</a></li>
                    <li><a href="<?= base_url('contact') ?>">Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5>Bantuan</h5>
                <ul>
                    <li><a href="<?= base_url('tracking') ?>">Lacak Order</a></li>
                    <li><a href="<?= base_url('layanan') ?>">Cara Pemesanan</a></li>
                    <li><a href="<?= base_url('contact') ?>">Hubungi Kami</a></li>
                    <li><a href="<?= base_url('login') ?>">Area Pelanggan</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5>Kontak</h5>
                <ul class="text-white-50">
                    <li><i class="fas fa-map-marker-alt me-2"></i> Penganten, Klambu, Grobogan</li>
                    <li><i class="fas fa-phone me-2"></i> +62 813-2734-1834</li>
                    <li><i class="fas fa-envelope me-2"></i> info@sagarajersey.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Sagara Jersey. Dibuat untuk tim yang ingin tampil berbeda.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= base_url('assets/js/layout.js') ?>"></script>
</body>
</html>
