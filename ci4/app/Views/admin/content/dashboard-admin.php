<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2>Dashboard</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <!-- Live Clock -->
            <div class="live-clock text-end">
                <div class="clock-time" id="clockTime">00:00:00</div>
                <div class="clock-date" id="clockDate">07 Sep 2026</div>
            </div>
            <!-- Date Filter -->
            <form method="get" action="<?= base_url('admin') ?>" class="d-flex gap-2">
                <input type="date" name="start_date" class="form-control form-control-sm" value="<?= $startDate ?? date('Y-m-d', strtotime('-30 days')) ?>">
                <input type="date" name="end_date" class="form-control form-control-sm" value="<?= $endDate ?? date('Y-m-d') ?>">
                <button type="submit" class="btn btn-admin btn-admin-primary btn-sm">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3><?= $totalOrders ?? 0 ?></h3>
                <p>Total Order</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3><?= $completedOrders ?? 0 ?></h3>
                <p>Order Selesai</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3><?= $processOrders ?? 0 ?></h3>
                <p>Order Proses</p>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?= $totalClients ?? 0 ?></h3>
                <p>Total Klien</p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Line Chart - Tren Order -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-chart-line me-2"></i> Tren Order (<?= date('d M Y', strtotime($startDate ?? '')) ?> - <?= date('d M Y', strtotime($endDate ?? '')) ?>)
            </div>
            <div class="card-body">
                <canvas id="orderTrendChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Pie Chart - Status Order -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header">
                <i class="fas fa-chart-pie me-2"></i> Distribusi Status Order
            </div>
            <div class="card-body">
                <canvas id="statusPieChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Order Terbaru -->
<div class="admin-card">
    <div class="card-header">
        <i class="fas fa-history me-2"></i> Order Terbaru
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Order</th>
                        <th>Nama Tim</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentOrders)): ?>
                        <?php 
                        $statusLabels = [
                            0 => ['label' => 'Baru', 'class' => 'bg-primary'],
                            1 => ['label' => 'Proses', 'class' => 'bg-warning'],
                            2 => ['label' => 'Selesai', 'class' => 'bg-success'],
                            3 => ['label' => 'Dikirim', 'class' => 'bg-info'],
                        ];
                        foreach ($recentOrders as $i => $order): 
                            $status = $order['status'] ?? 0;
                            $statusInfo = $statusLabels[$status] ?? ['label' => 'Unknown', 'class' => 'bg-secondary'];
                        ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($order['kode'] ?? '-') ?></td>
                            <td><?= esc($order['nama_tim'] ?? '-') ?></td>
                            <td><span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['label'] ?></span></td>
                            <td><?= isset($order['created_at']) ? date('d M Y', strtotime($order['created_at'])) : '-' ?></td>
                            <td>
                                <?php if (!empty($order['id'])): ?>
                                    <a href="<?= base_url('admin/order/detail/' . $order['id']) ?>" class="btn btn-sm btn-info" title="Lihat detail order" aria-label="Lihat detail order">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada order</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Line Chart - Order Trend
    const ctxTrend = document.getElementById('orderTrendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: <?= json_encode($chartLabels ?? []) ?>,
            datasets: [{
                label: 'Jumlah Order',
                data: <?= json_encode($chartData ?? []) ?>,
                borderColor: '#1976d2',
                backgroundColor: 'rgba(25, 118, 210, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1976d2',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
    
    // Pie Chart - Status Distribution
    const ctxPie = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($statusLabels ?? []) ?>,
            datasets: [{
                data: <?= json_encode($statusCounts ?? []) ?>,
                backgroundColor: ['#1976d2', '#ffc107', '#4caf50', '#2196f3'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>
