<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="mb-4">Hasil Tracking</h3>
            
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Order #<?= esc($order['order_number']) ?></strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> <?= esc($order['name']) ?></p>
                            <p><strong>Telepon:</strong> <?= esc($order['phone']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total:</strong> Rp <?= number_format($order['total'], 0, ',', '.') ?></p>
                            <p><strong>Status:</strong> <span class="badge bg-warning"><?= ucfirst($order['status']) ?></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <h5>Riwayat Status</h5>
            <div class="timeline">
                <?php foreach ($history as $item): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <p class="mb-0"><strong><?= ucfirst($item['status']) ?></strong></p>
                            <small class="text-muted"><?= date('d M Y H:i', strtotime($item['created_at'])) ?></small>
                            <?php if ($item['note']): ?>
                                <p class="text-muted mb-0"><?= esc($item['note']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <a href="<?= base_url('tracking') ?>" class="btn btn-primary">Cari Order Lain</a>
            </div>
        </div>
    </div>
</div>