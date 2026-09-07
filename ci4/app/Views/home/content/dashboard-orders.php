<div class="container py-4">
    <h2 class="mb-4">Daftar Order Saya</h2>
    
    <div class="card">
        <div class="card-body">
            <?php if (count($orders) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= esc($order['order_number']) ?></td>
                                <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                                <td>Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                                <td><span class="badge bg-warning"><?= ucfirst($order['status']) ?></span></td>
                                <td><a href="<?= base_url('dashboard/order/' . $order['id']) ?>" class="btn btn-sm btn-primary">Detail</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">Belum ada order.</p>
            <?php endif; ?>
        </div>
    </div>
</div>