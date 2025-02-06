<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
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
            <h2>Invoice</h2>
            <p><strong>Tanggal:</strong> <?= date('d/m/Y', strtotime($order['created_at'])) ?></p>
            <p><strong>Team:</strong> <?= $order['nama_tim'] ?></p>
            <img src="<?= base_url().$order['logo_tim'] ?>" alt="Team Logo" class="jersey-image">
        </div>

        <!-- Product List -->
        <div class="container mt-5">
            <h2>Product List</h2>
            <div class="row">
                <?php foreach ($orderDetail as $orderDet): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img 
                                src="<?= base_url('assets/upload/image/' . $orderDet['picture']) ?>" 
                                class="card-img-top" 
                                alt="<?= esc($orderDet['nama_product']) ?>" 
                                style="height: auto; object-fit: cover;"
                            >
                            <div class="card-body">
                                <h5 class="card-title"><?= esc($orderDet['nama_product']) ?></h5>
                                <p class="card-text"><strong>Price:</strong> Rp <?= number_format($orderDet['price'], 0, ',', '.') ?></p>
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
                            <td>Rp <?= number_format($player['price'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Jersey Details -->
        <div class="table-outer mb-5">
            <div class="section-title">Jersey Details</div>
            <?= $order['deskripsi'] ?>
        </div>

        <!-- Payment History -->
        <div class="table-outer mb-5">
            <div class="section-title">Payment History</div>
            <table id="payment-history-table" class="table table-bordered table-custom">
                <thead class="table-light">
                    <tr>
                        <th>Nama Pembayar</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Uang Muka (DP)</th>
                        <th>Pelunasan</th>
                        <th>Diskon</th>
                        <th>Kurang Bayar</th>
                        <th>Tanggal Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Payment history rows will be inserted here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderId = '<?= $order['id'] ?>'; // Mengambil ID order dari PHP
            const paymentHistoryTableBody = document.querySelector('#payment-history-table tbody');

            fetch(`<?=base_url('admin/')?>order/paymentHistory?id_order=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    const payments = data.payments;
                    let kurangBayar = 0;

                    payments.forEach((payment, index) => {
                        // Hitung kurang bayar untuk pembayaran pertama
                        if (index === 0) {
                            kurangBayar = payment.price - payment.downpayment - payment.completion - payment.discount;
                        } else {
                            // Untuk pembayaran berikutnya, gunakan kurang bayar sebelumnya
                            kurangBayar -= payment.downpayment + payment.completion + payment.discount;
                        }

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${payment.name || 'N/A'}</td>
                            <td>Rp ${new Intl.NumberFormat('id-ID').format(index === 0 ? payment.price : kurangBayar + (parseInt(payment.downpayment) + parseInt(payment.completion) + parseInt(payment.discount)))}</td>
                            <td>Rp ${new Intl.NumberFormat('id-ID').format(payment.downpayment)}</td>
                            <td>Rp ${new Intl.NumberFormat('id-ID').format(payment.completion)}</td>
                            <td>Rp ${new Intl.NumberFormat('id-ID').format(payment.discount)}</td>
                            <td>Rp ${new Intl.NumberFormat('id-ID').format(kurangBayar)}</td>
                            <td>${new Date(payment.created_at).toLocaleDateString()}</td>
                        `;
                        paymentHistoryTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching payment history:', error));
        });
    </script>
</body>
</html>
