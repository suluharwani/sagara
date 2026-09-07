<div class="content-header">
    <h2>Laporan Penjualan</h2>
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
        <p>Data laporan akan ditampilkan di sini.</p>
    </div>
</div>