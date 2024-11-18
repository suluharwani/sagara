<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Overview</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        .jersey-image {
            width: 100px;
            height: auto;
        }
        .section-title {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 1em;
        }
        .jersey-group {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .table-custom th, .table-custom td {
            text-align: center;
        }
        .table-outer {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Header Section -->
        <div class="text-center mb-4">
            <h2>Order Overview</h2>
            <p><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($order['created_at'])) ?></p>
            <p><strong>Team:</strong> <?= $order['nama_tim'] ?></p>
            <img src="<?= base_url($order['logo_tim']) ?>" alt="Team Logo" class="jersey-image">
        </div>

        <div class="container mt-5">
    <h2>Product List</h2>
    <div class="row">
        <?php foreach ($orderDetail as $orderDet): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- Display the product image -->
                    <img 
                        src="<?= base_url('assets/upload/image/' . $orderDet['picture']) ?>" 
                        class="card-img-top" 
                        alt="<?= esc($orderDet['nama_product']) ?>" 
                        style="height: auto; object-fit: cover;"
                    >
                    <div class="card-body">
                        <!-- Display product details -->
                        <h5 class="card-title"><?= esc($orderDet['nama_product']) ?></h5>
                        <p class="card-text"><strong>Price:</strong> Rp <?= number_format($orderDet['price'], 0, ',', '.') ?></p>
                        <!-- <p class="card-text"><strong>Client:</strong> <?= esc($orderDet['client_name']) ?></p> -->
                        <!-- <a href="<?= base_url('order/view/' . $orderDet['order_id']) ?>" class="btn btn-primary">View Order</a> -->
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="text-end mt-3">
        <h4>Total Harga: Rp <?= number_format($totalPrice, 0, ',', '.') ?></h4>
    </div>
        <!-- Player List -->
        <div class="table-outer mb-5">
            <div class="section-title">Player List</div>
            <table class="table table-bordered table-custom">
                <thead class="table-light">
                    <tr>
                        <th>Role</th>
                        <th>Size</th>
                        <th>Nama Punggung</th>
                        <th>Jersey</th>
                        <th>Jersey Number</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($players as $player): ?>
                        <tr>
                            <td><?= ucfirst($player['keterangan']) ?></td>
                            <td><?= $player['ukuran'] ?></td>
                            <td><?= $player['nama_player'] ?></td>
                            <td><?= $player['nama_product'] ?></td>
                            <td><?= $player['nomor_punggung'] ?></td>
                            <td><?= $player['price'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

<div class="table-outer mb-5">
    <div class="section-title">Rincian Produksi</div>
<!-- Jersey Details -->

<div class="table-outer mb-5">
    <div class="section-title">Ringkasan Ukuran Berdasarkan Produk</div>
    <?php foreach ($sizeSummary as $kategori => $ukuranList): ?>
        <?php foreach ($ukuranList as $ukuran => $dataUkuran): ?>
            <?php foreach ($dataUkuran['products'] as $produkId => $produk): ?>
                <?php if (!isset($productsDisplayed[$produkId])): // Cegah duplikasi produk ?>
                    <div class="table-outer mb-5">
                        <div class="section-title">Ringkasan Jersey <?= esc($produk['nama_product']) ?></div>
                        <div class="table-outer mb-3">
                            <table class="table table-bordered table-custom">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kategori Ukuran</th>
                                        <th>Ukuran</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sizeSummary as $kategoriLoop => $ukuranLoopList): ?>
                                        <?php foreach ($ukuranLoopList as $ukuranLoop => $dataUkuranLoop): ?>
                                            <?php if (isset($dataUkuranLoop['products'][$produkId])): ?>
                                                <tr>
                                                    <td><?= ucfirst($kategoriLoop) ?></td>
                                                    <td><?= esc($ukuranLoop) ?></td>
                                                    <td><?= esc($dataUkuranLoop['products'][$produkId]['count']) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php $productsDisplayed[$produkId] = true; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>



</div>


        <!-- Jersey Details -->
        <div class="table-outer">
            <div class="section-title">Jersey Details</div>
            <p><strong>Material:</strong> Milano Fullprint</p>
            <p><strong>Design:</strong> Kerah F</p>
            <p><strong>Color Codes:</strong></p>
            <ul>
                <li>GK: Purple</li>
                <li>GK Alternate: Red</li>
                <li>Top Only</li>
                <li>Long Sleeve</li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
