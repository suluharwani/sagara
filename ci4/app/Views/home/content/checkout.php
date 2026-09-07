<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-credit-card me-2"></i> Checkout</h2>

    <form action="<?= base_url('checkout/process') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="row">
            <!-- Form Checkout -->
            <div class="col-lg-8">
                <!-- Data Penerima -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i> Data Penerima</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" name="phone" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi</label>
                                <select name="province" class="form-select" id="province" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota/Kabupaten</label>
                                <select name="city" class="form-select" id="city" required>
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Pengiriman -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-truck me-2"></i> Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Kurir</label>
                            <select name="courier" class="form-select" required>
                                <option value="">Pilih Kurir</option>
                                <option value="jne">JNE</option>
                                <option value="jnt">J&T</option>
                                <option value="sicepat">SiCepat</option>
                                <option value="anteraja">AnterAja</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="ninja">Ninja Express</option>
                                <option value="lion">Lion Parcel</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-wallet me-2"></i> Metode Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="bca" id="bca" required>
                            <label class="form-check-label" for="bca">Transfer BCA</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="mandiri" id="mandiri">
                            <label class="form-check-label" for="mandiri">Transfer Mandiri</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="bni" id="bni">
                            <label class="form-check-label" for="bni">Transfer BNI</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="gopay" id="gopay">
                            <label class="form-check-label" for="gopay">GoPay</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="ovo" id="ovo">
                            <label class="form-check-label" for="ovo">OVO</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="dana" id="dana">
                            <label class="form-check-label" for="dana">DANA</label>
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-sticky-note me-2"></i> Catatan</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="note" class="form-control" rows="3" placeholder="Tambahan catatan untuk order..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Order -->
            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Ringkasan Order</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($cart as $item): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span><?= esc($item['name']) ?> (<?= esc($item['size'] ?? '-') ?>) x<?= $item['qty'] ?></span>
                                <span>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Produk</span>
                            <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim</span>
                            <span id="shippingCost">Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Pembayaran</strong>
                            <strong id="grandTotal">Rp <?= number_format($total, 0, ',', '.') ?></strong>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-check me-2"></i> Buat Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Load provinces on page load
document.addEventListener('DOMContentLoaded', function() {
    fetch('<?= base_url('api/shipping/provinces') ?>')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('province');
            data.forEach(province => {
                const option = document.createElement('option');
                option.value = province.province_id;
                option.textContent = province.province;
                select.appendChild(option);
            });
        });
});

// Load cities when province changes
document.getElementById('province').addEventListener('change', function() {
    const provinceId = this.value;
    fetch('<?= base_url('api/shipping/cities/') ?>' + provinceId)
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('city');
            select.innerHTML = '<option value="">Pilih Kota</option>';
            data.forEach(city => {
                const option = document.createElement('option');
                option.value = city.city_id;
                option.textContent = city.city_name;
                select.appendChild(option);
            });
        });
});
</script>