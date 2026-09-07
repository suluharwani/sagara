<div class="content-header">
    <h2>Laporan Produk</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
            <li class="breadcrumb-item active">Laporan Produk</li>
        </ol>
    </nav>
</div>

<div class="admin-card">
    <div class="card-header">
        <i class="fas fa-box me-2"></i> Daftar Produk
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $i => $product): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($product['nama'] ?? '-') ?></td>
                            <td><?= esc($product['kategori'] ?? '-') ?></td>
                            <td>Rp <?= number_format($product['harga'] ?? 0, 0, ',', '.') ?></td>
                            <td>
                                <?php if (($product['status'] ?? 0) == 1): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td><?= isset($product['created_at']) ? date('d M Y', strtotime($product['created_at'])) : '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada produk</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>