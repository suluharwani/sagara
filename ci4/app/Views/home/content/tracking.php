<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4"><i class="fas fa-search me-2"></i> Lacak Order</h3>
                    
                    <form action="<?= base_url('tracking/search') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor Order</label>
                            <input type="text" name="order_number" class="form-control" placeholder="INV-20260907-XXXXXX" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i> Lacak
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>