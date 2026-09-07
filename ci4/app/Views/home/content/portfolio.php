<div class="reseller-shell portfolio-page">
    <section class="portfolio-head">
        <div class="container">
            <span class="reseller-kicker">Arsip pengerjaan Sagara</span>
            <h1>Portfolio desain yang sudah kami kerjakan.</h1>
            <p>Jelajahi referensi jersey untuk menemukan arah visual tim Anda. Setiap desain dapat dikembangkan kembali sesuai identitas baru.</p>
            <form action="<?= base_url('portfolio') ?>" method="get" class="portfolio-search" role="search">
                <label class="visually-hidden" for="portfolio-search">Cari portfolio</label>
                <input id="portfolio-search" type="search" name="search" value="<?= esc($search) ?>" placeholder="Cari nama desain atau tim">
                <button type="submit"><i class="fas fa-search" aria-hidden="true"></i> Cari</button>
            </form>
        </div>
    </section>

    <section class="portfolio-content">
        <div class="container">
            <?php if ($portfolioItems): ?>
                <div class="portfolio-grid">
                    <?php foreach ($portfolioItems as $item): ?>
                        <article class="portfolio-work">
                            <div class="portfolio-work-image">
                                <img src="<?= base_url('assets/upload/image/' . rawurlencode($item['picture'])) ?>" alt="<?= esc($item['nama'] ?: 'Desain jersey Sagara') ?>" loading="lazy">
                            </div>
                            <div class="portfolio-work-copy">
                                <span>Karya Sagara</span>
                                <h2><?= esc($item['nama'] ?: $item['judul'] ?: 'Desain jersey custom') ?></h2>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <?php if ($pager && $pager->getPageCount() > 1): ?>
                    <nav class="reseller-pagination" aria-label="Navigasi halaman portfolio"><?= $pager->links() ?></nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="reseller-empty"><i class="fas fa-images"></i><h2>Portfolio tidak ditemukan</h2><p>Coba gunakan kata kunci yang berbeda.</p></div>
            <?php endif; ?>
        </div>
    </section>
</div>
