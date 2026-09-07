<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-chart-line me-2"></i> Laporan Penjualan</h2>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Total Pendapatan</h5>
                    <h3>Rp <?= number_format($totalRevenue['grand_total'] ?? 0, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Total Order</h5>
                    <h3><?= $totalOrders ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5>Order Pending</h5>
                    <h3><?= $pendingOrders ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Order</h5>
            <a href="<?= base_url('report/exportExcel') ?>" class="btn btn-sm btn-success">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= esc($order['order_number']) ?></td>
                            <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                            <td><?= esc($order['name']) ?></td>
                            <td>Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                            <td><span class="badge bg-warning"><?= ucfirst($order['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>