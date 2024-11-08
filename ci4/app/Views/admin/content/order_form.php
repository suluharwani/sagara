<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesan Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Header dengan logo dan keterangan -->
        <div class="d-flex align-items-center mb-4">
            <!-- Logo tim -->
            <div class="me-3">
                <img src="<?= base_url($pesanan['logo_tim']) ?>" alt="Logo Tim" width="100" height="100" class="rounded-circle border">
            </div>
            <!-- Keterangan pesanan -->
            <div>
                <h2>Form Pemesan Produk</h2>
                <p><strong>Order ID:</strong> <?= $id_order ?></p>
                <p><strong>Nama Tim:</strong> <?= esc($pesanan['nama_tim']) ?></p>
                <p><strong>Brand:</strong> <?= esc($pesanan['brand']) ?></p>
            </div>
        </div>
        
        <!-- Tabel Daftar Produk -->
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orderDetail): ?>
                    <?php foreach ($orderDetail as $product): ?>
                        <tr>
                            <td>
                                <img src="<?= base_url('assets/upload/image/' . esc($product['picture'])) ?>" alt="<?= esc($product['product_name']) ?>" width="50" class="zoom-image" data-bs-toggle="modal" data-bs-target="#zoomModal" data-bs-image="<?= base_url('assets/upload/image/' . esc($product['picture'])) ?>">
                            </td>
                            <td><?= esc($product['product_name']) ?></td>
                            <td>Rp <?= number_format($product['price'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada produk untuk Order ID: <?= $id_order ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal untuk Zoom Gambar -->
        <div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <img id="zoomedImage" src="" alt="Zoomed Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Form pemesan produk -->
        <form action="/order/save" method="post">
            <input type="hidden" name="id_order" value="<?= $id_order ?>">
             <div class="mb-3">
                <label for="product" class="form-label">Pilih Produk</label>
                <select class="form-select" id="product" name="product" required>
                    <?php foreach ($orderDetail as $product): ?>
                        <option value="<?= esc($product['product_id']) ?>">
                            <?= esc($product['product_name']) ?> - Rp <?= number_format($product['price'], 0, ',', '.') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Punggung</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="ukuran" class="form-label">Ukuran</label>
                <select class="form-select" id="size" name="size" required>
                    <?php foreach ($ukuran as $size): ?>
                        <option value="<?= esc($size['id']) ?>">
                            <?= esc($size['kategori']) ?> - <?= esc($size['ukuran']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nomor_punggung" class="form-label">Nomor Punggung</label>
                <input type="number" class="form-control" id="nomor_punggung" name="nomor_punggung" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <select class="form-select" id="keterangan" name="keterangan" required>
                    <option value="player">Player</option>
                    <option value="keeper">Keeper</option>
                    <option value="official">Official</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
            
        </form>

        <hr>

        <!-- Daftar pemesanan produk -->
        <h3>Daftar Pemesanan Produk untuk Order ID: <?= $id_order ?></h3>
        <a class="btn btn-primary" href="<?=base_url('home/print/').$id_order?>">Print</a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Nama</th>
                    <th>Ukuran</th>
                    <th>Nomor Punggung</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders): ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= esc($order['nama_produk']) ?></td>
                            <td><?= esc($order['nama']) ?></td>
                            <td><?= esc($order['ukuran']) ?></td>
                            <td><?= esc($order['nomor_punggung']) ?></td>
                            <td><?= esc($order['keterangan']) ?></td>
                            <td><?= esc($order['price']) ?></td>
                            <td>
                                <form action="/order/deleteListOrder" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                    <input type="hidden" name="id_order" value="<?= $id_order ?>">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <button type="submit" name="hapus" value="hapus" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada pesanan untuk Order ID: <?= $id_order ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- JavaScript untuk menampilkan gambar di modal zoom -->
    <script>
        document.querySelectorAll('.zoom-image').forEach(image => {
            image.addEventListener('click', function () {
                const imgSrc = this.getAttribute('data-bs-image');
                document.getElementById('zoomedImage').src = imgSrc;
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
