<!-- Layanan Section -->
<section class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5" style="background-image: url('<?= base_url('assets/HTML/img/bg/breadcrumb.jpg') ?>');">
    <div class="container">
        <div class="row">
            <div class="col-md-12 order-2 order-md-1 align-self-center p-static">
                <h1 class="text-8 font-weight-bold">Layanan Kami</h1>
                <span class="text-4">Berbagai layanan percetakan berkualitas</span>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-warning fw-bold text-uppercase">Layanan Kami</span>
            <h2 class="display-5 fw-bold mt-2">Kenapa Pilih Sagara Jersey?</h2>
            <p class="text-muted">Kami menyediakan berbagai layanan percetakan dengan kualitas terbaik</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 service-card">
                    <div class="service-icon mb-3">
                        <i class="fas fa-tshirt fa-3x text-warning"></i>
                    </div>
                    <h4>Jersey Custom</h4>
                    <p class="text-muted">Buat jersey dengan desain sendiri untuk tim futsal, sepak bola, atau komunitas Anda. Bahan premium dan nyaman dipakai.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 service-card">
                    <div class="service-icon mb-3">
                        <i class="fas fa-print fa-3x text-warning"></i>
                    </div>
                    <h4>Kaos Custom</h4>
                    <p class="text-muted">Cetak kaos dengan desain sendiri untuk event, promosi, atau seragam perusahaan. Hasil cetak tahan lama dan tidak mudah pudar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 service-card">
                    <div class="service-icon mb-3">
                        <i class="fas fa-palette fa-3x text-warning"></i>
                    </div>
                    <h4>Desain Bebas</h4>
                    <p class="text-muted">Bebaskan kreativitas Anda dengan desain custom sesuai keinginan. Tim kami siap membantu mewujudkan ide Anda!</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 service-card">
                    <div class="service-icon mb-3">
                        <i class="fas fa-shipping-fast fa-3x text-warning"></i>
                    </div>
                    <h4>Cepat & Tepat Waktu</h4>
                    <p class="text-muted">Produksi cepat dengan estimasi 3-7 hari kerja. Pengiriman ke seluruh Indonesia dengan berbagai pilihan kurir.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 service-card">
                    <div class="service-icon mb-3">
                        <i class="fas fa-hand-holding-usd fa-3x text-warning"></i>
                    </div>
                    <h4>Harga Terjangkau</h4>
                    <p class="text-muted">Harga grosir murah untuk partai besar. Cocok untuk komunitas, perusahaan, dan event dengan budget terbatas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4 service-card">
                    <div class="service-icon mb-3">
                        <i class="fas fa-headset fa-3x text-warning"></i>
                    </div>
                    <h4>CS Ramah</h4>
                    <p class="text-muted">Customer service siap membantu Anda 24/7 melalui WhatsApp, telepon, dan email. Konsultasi gratis!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 cta-section">
    <div class="container text-center text-white">
        <h2 class="display-5 fw-bold mb-4">Butuh Layanan Percetakan?</h2>
        <p class="lead mb-4">Hubungi kami sekarang untuk konsultasi gratis dan dapatkan harga spesial!</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="https://wa.me/6281327341834" class="btn btn-warning btn-lg px-4">
                <i class="fab fa-whatsapp me-2"></i> Chat WhatsApp
            </a>
            <a href="<?= base_url('product') ?>" class="btn btn-outline-light btn-lg px-4">
                <i class="fas fa-shopping-bag me-2"></i> Lihat Produk
            </a>
        </div>
    </div>
</section>

<style>
.service-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
}
.service-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 193, 7, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
.cta-section {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}
</style>