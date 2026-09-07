<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sagara Jersey - Percetakan Kaos & Jersey Custom</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/layout.css') ?>" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">
            Sagara <span>Jersey</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('product') ?>">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('layanan') ?>">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('tentang-kami') ?>">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('contact') ?>">Kontak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('tracking') ?>">Tracking</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="nav-link btn-login" href="<?= base_url('login') ?>">
                        <i class="fas fa-user me-1"></i> Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <?= $content ?? '' ?>
</main>

<!-- Footer -->
<footer class="footer-custom">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5>Sagara Jersey</h5>
                <p class="text-white-50">Percetakan jersey dan kaos custom berkualitas tinggi. Desain bebas, bahan premium, pengiriman ke seluruh Indonesia.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/6281327341834"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2">
                <h5>Menu</h5>
                <ul>
                    <li><a href="<?= base_url() ?>">Home</a></li>
                    <li><a href="<?= base_url('product') ?>">Produk</a></li>
                    <li><a href="<?= base_url('blog') ?>">Blog</a></li>
                    <li><a href="<?= base_url('contact') ?>">Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h5>Layanan</h5>
                <ul>
                    <li><a href="#">Jersey Custom</a></li>
                    <li><a href="#">Kaos Custom</a></li>
                    <li><a href="#">Seragam Kerja</a></li>
                    <li><a href="#">Jacket Custom</a></li>
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
            <p>&copy; 2026 Sagara Jersey. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="<?= base_url('assets/js/layout.js') ?>"></script>
</body>
</html>