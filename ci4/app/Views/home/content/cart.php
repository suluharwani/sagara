<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-shopping-cart me-2"></i> Keranjang Belanja</h2>

    <?php if (count($cart) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $rowid => $item): ?>
                        <tr>
                            <td>
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?= base_url('assets/upload/image/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>" style="width: 80px; height: 80px; object-fit: cover;">
                                <?php endif; ?>
                                <?= esc($item['name']) ?>
                            </td>
                            <td><?= esc($item['size'] ?? '-') ?></td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td>
                                <form action="<?= base_url('cart/update') ?>" method="post" class="d-flex gap-2">
                                    <input type="hidden" name="rowid" value="<?= $rowid ?>">
                                    <input type="number" name="quantity" value="<?= $item['qty'] ?>" min="1" class="form-control" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            <td>
                                <a href="<?= base_url('cart/remove/' . $rowid) ?>" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2"><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <a href="<?= base_url('cart/clear') ?>" class="btn btn-outline-danger">Kosongkan Keranjang</a>
            <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-lg">Lanjut Checkout</a>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
            <h5>Keranjang Kosong</h5>
            <p>Belum ada produk di keranjang Anda.</p>
            <a href="<?= base_url('product') ?>" class="btn btn-primary">Belanja Sekarang</a>
        </div>
    <?php endif; ?>
</div>