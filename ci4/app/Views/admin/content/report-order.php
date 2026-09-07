<div class="content-header">
    <h2>Laporan Order</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
            <li class="breadcrumb-item active">Laporan Order</li>
        </ol>
    </nav>
</div>

<div class="admin-card">
    <div class="card-header">
        <i class="fas fa-file-invoice me-2"></i> Detail Order
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
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php 
                        $statusLabels = [
                            0 => ['label' => 'Baru', 'class' => 'bg-primary'],
                            1 => ['label' => 'Proses', 'class' => 'bg-warning'],
                            2 => ['label' => 'Selesai', 'class' => 'bg-success'],
                            3 => ['label' => 'Dikirim', 'class' => 'bg-info'],
                        ];
                        foreach ($orders as $i => $order): 
                            $status = $order['status'] ?? 0;
                            $statusInfo = $statusLabels[$status] ?? ['label' => 'Unknown', 'class' => 'bg-secondary'];
                        ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($order['kode'] ?? '-') ?></td>
                            <td><?= esc($order['nama_tim'] ?? '-') ?></td>
                            <td><span class="badge <?= $statusInfo['class'] ?>"><?= $statusInfo['label'] ?></span></td>
                            <td><?= isset($order['created_at']) ? date('d M Y', strtotime($order['created_at'])) : '-' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada order</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>