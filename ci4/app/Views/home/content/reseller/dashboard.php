<?php $approved = $reseller['status'] === 'approved'; ?>
<div class="reseller-shell reseller-portal">
    <div class="container">
        <div class="reseller-portal-head">
            <div><span class="reseller-kicker">Dashboard reseller</span><h1><?= esc($reseller['business_name']) ?></h1><p>Kode reseller: <strong><?= esc($reseller['code']) ?></strong></p></div>
            <span class="reseller-status <?= esc($reseller['status']) ?>"><?= esc(ucfirst($reseller['status'])) ?></span>
        </div>

        <?php if ($success = session()->getFlashdata('success')): ?><div class="reseller-alert success"><p><?= esc($success) ?></p></div><?php endif; ?>
        <?php if ($error = session()->getFlashdata('error')): ?><div class="reseller-alert danger"><p><?= esc($error) ?></p></div><?php endif; ?>

        <?php if (!$approved): ?>
            <section class="reseller-pending-card">
                <div class="reseller-pending-icon"><i class="fas fa-hourglass-half"></i></div>
                <div><span>Pengajuan sedang diproses</span><h2>Admin sedang memeriksa data usaha Anda.</h2><p>Harga dasar, katalog, dan pembuatan nota akan terbuka setelah status berubah menjadi disetujui.</p><?php if ($reseller['admin_note']): ?><div class="reseller-admin-note"><strong>Catatan admin</strong><p><?= esc($reseller['admin_note']) ?></p></div><?php endif; ?></div>
            </section>
        <?php else: ?>
            <div class="reseller-stat-grid">
                <article><span>Total Nota</span><strong><?= (int) $quoteCount ?></strong><i class="fas fa-file-invoice"></i></article>
                <article><span>Disetujui Customer</span><strong><?= (int) $acceptedCount ?></strong><i class="fas fa-circle-check"></i></article>
                <article><span>Nilai Penjualan</span><strong>Rp <?= number_format($sellingTotal, 0, ',', '.') ?></strong><i class="fas fa-chart-line"></i></article>
            </div>
            <div class="reseller-quick-actions"><a href="<?= base_url('reseller/quotes/create') ?>" class="btn-reseller-primary"><i class="fas fa-plus"></i> Buat Nota</a><a href="<?= base_url('reseller/products') ?>" class="btn-reseller-secondary"><i class="fas fa-shirt"></i> Lihat Katalog</a></div>
            <section class="reseller-table-card">
                <div class="reseller-card-head"><div><span>Aktivitas terbaru</span><h2>Nota terakhir</h2></div><a href="<?= base_url('reseller/quotes') ?>">Lihat semua</a></div>
                <?php if ($recentQuotes): ?><div class="table-responsive"><table class="reseller-table"><thead><tr><th>Nomor</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr></thead><tbody><?php foreach ($recentQuotes as $quote): ?><tr><td><strong><?= esc($quote['quote_number']) ?></strong></td><td><?= esc($quote['customer_name']) ?></td><td>Rp <?= number_format($quote['selling_total'], 0, ',', '.') ?></td><td><span class="quote-status <?= esc($quote['status']) ?>"><?= esc(ucfirst($quote['status'])) ?></span></td><td><a href="<?= base_url('reseller/quotes/' . $quote['id']) ?>">Buka</a></td></tr><?php endforeach; ?></tbody></table></div><?php else: ?><div class="reseller-empty compact"><i class="fas fa-file-circle-plus"></i><h3>Belum ada nota</h3><p>Buat nota pertama untuk customer Anda.</p></div><?php endif; ?>
            </section>
        <?php endif; ?>
    </div>
</div>
