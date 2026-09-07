<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body p-5 text-center">
                    <h3 class="mb-4">Pembayaran Order</h3>
                    
                    <div class="alert alert-info">
                        <p class="mb-1"><strong>Nomor Order:</strong> <?= esc($order['order_number']) ?></p>
                        <p class="mb-0"><strong>Total:</strong> Rp <?= number_format($order['grand_total'], 0, ',', '.') ?></p>
                    </div>

                    <?php if (isset($snapToken)): ?>
                        <button id="pay-button" class="btn btn-primary btn-lg">
                            <i class="fas fa-credit-card me-2"></i> Bayar Sekarang
                        </button>

                        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= env('MIDTRANS_CLIENT_KEY') ?>"></script>
                        <script>
                            document.getElementById('pay-button').addEventListener('click', function() {
                                snap.pay('<?= $snapToken ?>', {
                                    onSuccess: function(result) {
                                        window.location.href = '<?= base_url('payment/finish') ?>';
                                    },
                                    onPending: function(result) {
                                        window.location.href = '<?= base_url('payment/unfailed') ?>';
                                    },
                                    onError: function(result) {
                                        window.location.href = '<?= base_url('payment/error') ?>';
                                    }
                                });
                            });
                        </script>
                    <?php else: ?>
                        <form action="<?= base_url('payment/pay') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card me-2"></i> Lanjut Pembayaran
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>