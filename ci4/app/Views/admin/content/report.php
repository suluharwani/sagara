<div class="content-header">
    <h2>Laporan Penjualan</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
            <li class="breadcrumb-item active">Laporan Penjualan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-info"><h3><?= $totalOrders ?? 0 ?></h3><p>Total Order</p></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info"><h3><?= $completedOrders ?? 0 ?></h3><p>Order Selesai</p></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
            <div class="stat-info"><h3><?= $processOrders ?? 0 ?></h3><p>Order Proses</p></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-info"><h3>Rp <?= number_format($totalRevenue ?? 0, 0, ',', '.') ?></h3><p>Total Pendapatan</p></div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="card-header"><i class="fas fa-table me-2"></i> Detail Laporan</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>No</th><th>Kode Order</th><th>Nama Tim</th><th>Status</th><th>Tanggal</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $i => $order): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($order['kode'] ?? '-') ?></td>
                            <td><?= esc($order['nama_tim'] ?? '-') ?></td>
                            <td><span class="badge bg-primary"><?= $order['status'] ?? 0 ?></span></td>
                            <td><?= isset($order['created_at']) ? date('d M Y', strtotime($order['created_at'])) : '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>