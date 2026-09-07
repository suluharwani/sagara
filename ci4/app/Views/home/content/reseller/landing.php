<div class="reseller-shell">
    <section class="reseller-hero">
        <div class="container">
            <div class="reseller-hero-grid">
                <div class="reseller-hero-copy">
                    <span class="reseller-kicker">Program Reseller Sagara</span>
                    <h1>Jual dengan brand Anda. Produksi bersama kami.</h1>
                    <p>Dapatkan harga dasar khusus, susun harga jual sendiri, dan buat nota profesional untuk customer tanpa membuka biaya produksi Anda.</p>
                    <div class="reseller-hero-actions">
                        <a href="<?= base_url('reseller/register') ?>" class="btn-reseller-primary">Daftar Reseller <i class="fas fa-arrow-right"></i></a>
                        <a href="<?= base_url('login') ?>" class="btn-reseller-secondary">Sudah punya akun</a>
                    </div>
                    <div class="reseller-hero-points">
                        <span><i class="fas fa-check"></i> Persetujuan admin</span>
                        <span><i class="fas fa-check"></i> Harga dasar privat</span>
                        <span><i class="fas fa-check"></i> Nota atas nama usaha</span>
                    </div>
                </div>
                <div class="reseller-hero-image">
                    <img src="<?= base_url('assets/images/reseller/reseller-hero.webp') ?>" alt="Tim dan hasil jersey produksi Sagara" width="1280" height="426">
                    <div class="reseller-hero-note"><strong>Partner produksi</strong><span>untuk usaha apparel Anda</span></div>
                </div>
            </div>
        </div>
    </section>

    <section class="reseller-benefits" aria-labelledby="benefit-title">
        <div class="container">
            <div class="reseller-section-head"><span class="reseller-kicker">Yang Anda dapatkan</span><h2 id="benefit-title">Fondasi usaha tanpa mengurus produksi sendiri.</h2></div>
            <div class="reseller-benefit-grid">
                <?php
                $benefits = [
                    ['benefit-design.webp', 'Dukungan desain', 'Bawa brief customer dan kembangkan desain bersama tim Sagara.'],
                    ['benefit-price.webp', 'Harga dasar khusus', 'Harga produksi hanya terlihat oleh reseller yang sudah disetujui.'],
                    ['benefit-quality.webp', 'Kualitas konsisten', 'Pilihan bahan, model, warna, dan ukuran dikelola dari satu katalog.'],
                    ['benefit-speed.webp', 'Alur lebih cepat', 'Buat nota dan teruskan kebutuhan customer tanpa pencatatan berulang.'],
                ];
                foreach ($benefits as [$image, $title, $copy]): ?>
                    <article class="reseller-benefit-card">
                        <img src="<?= base_url('assets/images/reseller/' . $image) ?>" alt="" loading="lazy">
                        <div><h3><?= esc($title) ?></h3><p><?= esc($copy) ?></p></div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="reseller-models" aria-labelledby="model-title">
        <div class="container">
            <div class="reseller-section-head"><span class="reseller-kicker">Referensi model</span><h2 id="model-title">Mulai dari kebutuhan customer, bukan desain lama.</h2><p>Admin akan mengatur produk reseller berdasarkan model, bahan, pilihan warna, ukuran, dan harga dasar.</p></div>
            <div class="reseller-model-grid">
                <?php
                $models = [
                    ['model-combo-1.webp', 'Setelan Combo'],
                    ['model-ultimate.webp', 'Setelan Ultimate'],
                    ['model-atasan.webp', 'Jersey Atasan'],
                    ['model-combo-2.webp', 'Setelan Tim'],
                ];
                foreach ($models as [$image, $label]): ?>
                    <article class="reseller-model-card"><img src="<?= base_url('assets/images/reseller/' . $image) ?>" alt="Referensi <?= esc($label) ?>" loading="lazy"><span><?= esc($label) ?></span></article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="reseller-cta">
        <div class="container"><div class="reseller-cta-box"><div><span class="reseller-kicker">Siap mulai?</span><h2>Daftarkan usaha Anda untuk melihat harga dasar.</h2></div><a href="<?= base_url('reseller/register') ?>" class="btn-reseller-primary">Ajukan Sekarang <i class="fas fa-arrow-right"></i></a></div></div>
    </section>
</div>
