<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x text-success"></i>
                    </div>
                    <h2 class="font-weight-bold text-success">Order Berhasil!</h2>
                    <p class="lead">Terima kasih telah berbelanja di Sagara Jersey</p>
                    
                    <div class="alert alert-info">
                        <p class="mb-1"><strong>Nomor Order:</strong></p>
                        <h4 class="text-primary"><?= esc($order['order_number']) ?></h4>
                    </div>

                    <div class="order-details text-start mt-4">
                        <h5>Detail Order:</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama Penerima</th>
                                <td><?= esc($order['name']) ?></td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td><?= esc($order['phone']) ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= esc($order['address']) ?></td>
                            </tr>
                            <tr>
                                <th>Kurir</th>
                                <td><?= strtoupper(esc($order['courier'])) ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td><strong>Rp <?= number_format($order['total'], 0, ',', '.') ?></strong></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span class="badge bg-warning"><?= ucfirst($order['status']) ?></span></td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted">Silakan lakukan pembayaran sesuai metode yang dipilih.</p>
                        <p class="text-muted">Konfirmasi pembayaran akan dikirimkan melalui email.</p>
                    </div>

                    <div class="mt-4">
                        <a href="<?= base_url('tracking') ?>" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i> Lacak Order
                        </a>
                        <a href="<?= base_url('product') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart me-1"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>