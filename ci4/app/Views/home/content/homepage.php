<?php
$whatsappMessage = rawurlencode('Halo Sagara Jersey, saya ingin konsultasi desain apparel custom.');
$whatsappUrl = 'https://wa.me/6281327341834?text=' . $whatsappMessage;
?>

<div class="home-shell">
    <section class="hero-home" aria-labelledby="hero-title">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="hero-kicker">Apparel custom untuk tim Anda</span>
                    <h1 class="hero-title" id="hero-title">
                        Tampil solid.<br><span class="outline-word">Main maksimal.</span>
                    </h1>
                    <p class="hero-copy">
                        Mulai dari jersey tim, kaos komunitas, hingga apparel event. Pilih produk, bawa ide Anda, lalu kami bantu wujudkan menjadi seragam yang siap dikenakan.
                    </p>
                    <div class="hero-actions">
                        <a href="<?= base_url('portfolio') ?>" class="btn-sagara btn-sagara-primary">
                            Lihat Portfolio <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="<?= $whatsappUrl ?>" target="_blank" rel="noopener" class="btn-sagara btn-sagara-ghost">
                            <i class="fab fa-whatsapp me-2"></i>Konsultasi Desain
                        </a>
                    </div>

                    <div class="hero-quickbar" aria-label="Akses cepat">
                        <a href="<?= base_url('reseller') ?>" class="quick-link">
                            <i class="fas fa-handshake"></i>
                            <span><strong>Program Reseller</strong><small>Harga dasar dan nota mandiri</small></span>
                        </a>
                        <a href="#ready-title" class="quick-link">
                            <i class="fas fa-bag-shopping"></i>
                            <span><strong>Siap Pakai</strong><small>Pilih produk yang tersedia</small></span>
                        </a>
                        <a href="<?= base_url('tracking') ?>" class="quick-link">
                            <i class="fas fa-location-crosshairs"></i>
                            <span><strong>Lacak Order</strong><small>Cek progres pesanan Anda</small></span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="hero-visual" aria-hidden="true">
                        <div class="hero-photo">
                            <img src="<?= base_url('assets/images/home/hero-team-v2.webp') ?>" alt="" width="1120" height="1402" fetchpriority="high">
                        </div>
                        <div class="hero-stamp">Made for<br>your team</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="trust-strip" aria-label="Ringkasan Sagara Jersey">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-item"><span class="trust-number"><?= (int) ($totalProducts ?? 0) ?>+</span><span class="trust-label">Desain Portfolio</span></div>
                <div class="trust-item"><span class="trust-number"><?= (int) ($totalOrders ?? 0) ?>+</span><span class="trust-label">Order Ditangani</span></div>
                <div class="trust-item"><span class="trust-number"><?= (int) ($totalProductsSold ?? 0) ?>+</span><span class="trust-label">Produk Terjual</span></div>
            </div>
        </div>
    </section>

    <section class="section-block bg-surface" id="layanan" aria-labelledby="services-title">
        <div class="container">
            <div class="section-heading reveal">
                <span class="section-kicker">Kenapa Sagara</span>
                <h2 class="section-title" id="services-title">Dari ide mentah sampai siap tanding.</h2>
                <p class="section-lead">Alur yang jelas, pilihan yang fleksibel, dan hasil yang mewakili karakter tim Anda.</p>
            </div>
            <div class="service-grid">
                <article class="service-tile reveal">
                    <div class="service-index"><span>01</span><i class="fas fa-pen-nib"></i></div>
                    <h3>Desain Fleksibel</h3>
                    <p>Bawa referensi atau mulai dari nol. Pilih warna, detail, dan identitas yang ingin ditonjolkan.</p>
                </article>
                <article class="service-tile reveal">
                    <div class="service-index"><span>02</span><i class="fas fa-shirt"></i></div>
                    <h3>Pilihan Material</h3>
                    <p>Sesuaikan bahan dengan aktivitas, kenyamanan, dan karakter visual produk yang Anda butuhkan.</p>
                </article>
                <article class="service-tile reveal">
                    <div class="service-index"><span>03</span><i class="fas fa-box-open"></i></div>
                    <h3>Progres Terpantau</h3>
                    <p>Simpan nomor order dan gunakan fitur tracking untuk melihat perjalanan pesanan dengan mudah.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section-block" aria-labelledby="custom-title">
        <div class="container">
            <div class="product-section-head reveal">
                <div class="section-heading">
                    <span class="section-kicker">Portfolio Pengerjaan</span>
                    <h2 class="section-title" id="custom-title">Referensi dari karya nyata.</h2>
                    <p class="section-lead">Jelajahi desain yang pernah kami kerjakan sebagai inspirasi untuk identitas tim Anda.</p>
                </div>
                <a href="<?= base_url('portfolio') ?>" class="section-link">Lihat <?= (int) ($totalProducts ?? 0) ?> karya <i class="fas fa-arrow-right ms-1"></i></a>
            </div>

            <?php if (!empty($products)): ?>
                <div class="row g-4">
                    <?php foreach ($products as $product): ?>
                        <?php $customUrl = base_url('portfolio?search=' . rawurlencode($product['nama'] ?? '')); ?>
                        <div class="col-sm-6 col-lg-3 reveal">
                            <article class="sagara-product">
                                <a href="<?= $customUrl ?>" class="sagara-product-media" aria-label="Lihat <?= esc($product['nama'] ?? 'produk custom') ?>">
                                    <?php if (!empty($product['picture'])): ?>
                                        <img src="<?= base_url('assets/upload/image/' . $product['picture']) ?>" alt="<?= esc($product['nama'] ?? 'Produk custom') ?>" loading="lazy">
                                    <?php else: ?>
                                        <span class="product-placeholder"><i class="fas fa-shirt"></i></span>
                                    <?php endif; ?>
                                    <span class="product-badge">Portfolio</span>
                                </a>
                                <div class="sagara-product-body">
                                    <div class="product-meta">Karya Sagara</div>
                                    <h3><a href="<?= $customUrl ?>"><?= esc($product['nama'] ?? 'Produk Custom') ?></a></h3>
                                    <a href="<?= $customUrl ?>" class="product-card-action"><span>Lihat detail</span><i class="fas fa-arrow-right"></i></a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state"><i class="fas fa-images"></i>Portfolio sedang disiapkan.</div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section-block bg-surface" aria-labelledby="ready-title">
        <div class="container">
            <div class="product-section-head reveal">
                <div class="section-heading">
                    <span class="section-kicker">Siap Pakai</span>
                    <h2 class="section-title" id="ready-title">Pilih. Pakai. Bergerak.</h2>
                    <p class="section-lead">Koleksi yang tersedia untuk Anda yang ingin berbelanja lebih cepat.</p>
                </div>
                <a href="<?= $whatsappUrl ?>" target="_blank" rel="noopener" class="section-link">Tanya stok terbaru <i class="fas fa-arrow-right ms-1"></i></a>
            </div>

            <?php if (!empty($productsUmum)): ?>
                <div class="row g-4">
                    <?php foreach ($productsUmum as $product): ?>
                        <?php
                        $readyMessage = rawurlencode('Halo Sagara Jersey, saya tertarik dengan produk siap pakai: ' . ($product['nama'] ?? 'produk Sagara') . '. Apakah masih tersedia?');
                        $readyUrl = 'https://wa.me/6281327341834?text=' . $readyMessage;
                        $hasDiscount = !empty($product['harga_diskon']) && (float) $product['harga_diskon'] > 0 && (float) $product['harga_diskon'] < (float) ($product['harga'] ?? 0);
                        ?>
                        <div class="col-sm-6 col-lg-3 reveal">
                            <article class="sagara-product">
                                <a href="<?= $readyUrl ?>" target="_blank" rel="noopener" class="sagara-product-media" aria-label="Tanyakan <?= esc($product['nama'] ?? 'produk siap pakai') ?> melalui WhatsApp">
                                    <?php if (!empty($product['gambar'])): ?>
                                        <img src="<?= base_url('assets/upload/image/' . $product['gambar']) ?>" alt="<?= esc($product['nama'] ?? 'Produk siap pakai') ?>" loading="lazy">
                                    <?php else: ?>
                                        <span class="product-placeholder"><i class="fas fa-bag-shopping"></i></span>
                                    <?php endif; ?>
                                    <?php if ($hasDiscount): ?>
                                        <span class="product-badge sale">Hemat <?= (int) round((1 - $product['harga_diskon'] / $product['harga']) * 100) ?>%</span>
                                    <?php endif; ?>
                                </a>
                                <div class="sagara-product-body">
                                    <div class="product-meta"><?= esc($product['kategori'] ?? 'Siap pakai') ?></div>
                                    <h3><a href="<?= $readyUrl ?>" target="_blank" rel="noopener"><?= esc($product['nama'] ?? 'Produk Siap Pakai') ?></a></h3>
                                    <div class="product-price">
                                        <?php if ($hasDiscount): ?>
                                            Rp <?= number_format((float) $product['harga_diskon'], 0, ',', '.') ?>
                                            <del>Rp <?= number_format((float) $product['harga'], 0, ',', '.') ?></del>
                                        <?php elseif (!empty($product['harga'])): ?>
                                            Rp <?= number_format((float) $product['harga'], 0, ',', '.') ?>
                                        <?php else: ?>
                                            Hubungi untuk harga
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?= $readyUrl ?>" target="_blank" rel="noopener" class="product-card-action"><span>Tanya via WhatsApp</span><i class="fab fa-whatsapp"></i></a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state"><i class="fas fa-bag-shopping"></i>Koleksi siap pakai sedang disiapkan.</div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section-block bg-ink" aria-labelledby="process-title">
        <div class="container">
            <div class="section-heading center reveal">
                <span class="section-kicker">Cara Memulai</span>
                <h2 class="section-title" id="process-title">Tiga langkah, satu identitas baru.</h2>
            </div>
            <div class="process-wrap">
                <article class="process-step reveal">
                    <span class="process-number">01</span>
                    <h3>Pilih Produk</h3>
                    <p>Tentukan jenis apparel yang paling sesuai untuk tim, komunitas, atau acara Anda.</p>
                </article>
                <article class="process-step reveal">
                    <span class="process-number">02</span>
                    <h3>Kirim Ide</h3>
                    <p>Sampaikan warna, logo, jumlah, serta detail desain melalui konsultasi WhatsApp.</p>
                </article>
                <article class="process-step reveal">
                    <span class="process-number">03</span>
                    <h3>Pantau Order</h3>
                    <p>Gunakan nomor pesanan untuk mengecek progres hingga produk siap diterima.</p>
                </article>
            </div>
        </div>
    </section>

    <?php if (!empty($testimonials)): ?>
        <section class="section-block" aria-labelledby="testimonial-title">
            <div class="container">
                <div class="section-heading reveal">
                    <span class="section-kicker">Cerita Pelanggan</span>
                    <h2 class="section-title" id="testimonial-title">Dipakai dengan bangga.</h2>
                </div>
                <div class="row g-4">
                    <?php foreach ($testimonials as $testimonial): ?>
                        <?php $rating = max(0, min(5, (int) ($testimonial['rating'] ?? 5))); ?>
                        <div class="col-md-4 reveal">
                            <article class="testimonial-card">
                                <div class="testimonial-stars" aria-label="Rating <?= $rating ?> dari 5">
                                    <?php for ($i = 0; $i < $rating; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
                                </div>
                                <p class="testimonial-quote">&ldquo;<?= esc($testimonial['text'] ?? '') ?>&rdquo;</p>
                                <div class="testimonial-person">
                                    <?php if (!empty($testimonial['picture'])): ?>
                                        <img src="<?= base_url('assets/upload/image/' . $testimonial['picture']) ?>" class="testimonial-avatar" alt="" loading="lazy">
                                    <?php else: ?>
                                        <span class="testimonial-avatar testimonial-initial"><?= esc(mb_strtoupper(mb_substr($testimonial['nama'] ?? 'P', 0, 1))) ?></span>
                                    <?php endif; ?>
                                    <span><strong><?= esc($testimonial['nama'] ?? 'Pelanggan') ?></strong><small><?= esc($testimonial['company'] ?? 'Pelanggan Sagara') ?></small></span>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($galleries)): ?>
        <section class="section-block bg-surface" aria-labelledby="gallery-title">
            <div class="container">
                <div class="product-section-head reveal">
                    <div class="section-heading">
                        <span class="section-kicker">Galeri Produksi</span>
                        <h2 class="section-title" id="gallery-title">Detail yang bicara.</h2>
                    </div>
                </div>
                <div class="gallery-grid">
                    <?php foreach (array_slice($galleries, 0, 5) as $gallery): ?>
                        <figure class="gallery-card reveal">
                            <?php if (!empty($gallery['picture'])): ?>
                                <img src="<?= base_url('assets/upload/image/' . $gallery['picture']) ?>" alt="<?= esc($gallery['judul'] ?? 'Hasil produksi Sagara Jersey') ?>" loading="lazy">
                            <?php else: ?>
                                <span class="product-placeholder"><i class="fas fa-image"></i></span>
                            <?php endif; ?>
                            <?php if (!empty($gallery['judul'])): ?><figcaption class="gallery-caption"><?= esc($gallery['judul']) ?></figcaption><?php endif; ?>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="section-block" aria-labelledby="cta-title">
        <div class="container">
            <div class="cta-panel reveal">
                <span class="section-kicker section-kicker-dark">Punya ide untuk tim?</span>
                <h2 id="cta-title">Mari jadikan desain itu nyata.</h2>
                <p>Ceritakan kebutuhan Anda. Tim Sagara akan membantu menentukan langkah berikutnya dengan lebih jelas.</p>
                <div class="hero-actions">
                    <a href="<?= $whatsappUrl ?>" target="_blank" rel="noopener" class="btn-sagara btn-sagara-dark"><i class="fab fa-whatsapp me-2"></i>Mulai Konsultasi</a>
                    <a href="<?= base_url('tracking') ?>" class="btn-sagara btn-sagara-outline-dark">Lacak Pesanan</a>
                </div>
            </div>
        </div>
    </section>
</div>
