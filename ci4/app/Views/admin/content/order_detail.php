<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h2 class="mb-1">Detail Order</h2>
                <p class="text-muted mb-0">Produk yang tercatat pada order ini.</p>
            </div>
            <button type="button" class="btn btn-outline-secondary" onclick="window.close()"><i class="fas fa-times me-1"></i>Tutup</button>
        </div>
        <?php if (!empty($orderDetails)): ?>
            <div class="card border-0 shadow-sm">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Order</th>
                        <th>Nama Client</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th> <!-- Kolom aksi untuk hapus -->
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach ($orderDetails as $detail): ?>
                        <tr id="order_product_<?= $detail['id'] ?>"> <!-- ID untuk menghapus baris ini setelah penghapusan -->
                            <td><span class="fw-semibold"><?= esc($detail['kode']) ?></span></td>
                            <td><?= esc($detail['client_name']) ?></td>
                            <td><?= esc($detail['product_name']) ?></td>
                            <td>Rp <?= number_format((float) $detail['price'], 0, ',', '.') ?></td>
                            <td><span class="badge <?= $detail['status'] == 1 ? 'bg-success' : 'bg-secondary' ?>"><?= $detail['status'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></span></td>
                            <td>
                                <button class="btn btn-outline-danger btn-sm deleteProduct" data-id="<?= $detail['id'] ?>"><i class="fas fa-trash me-1"></i>Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
              </div>
            </div>
        <?php else: ?>
            <p>Detail order tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var base_url = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;

      $(document).on('click', '.deleteProduct', function () {
    console.log('Tombol Hapus diklik'); // Pastikan tombol diklik
    
    const productId = $(this).data('id');
    console.log('ID Produk:', productId); // Periksa apakah ID produk benar
    
    const row = $('#order_product_' + productId);
    console.log('Elemen Baris:', row); // Cek elemen baris

    // Jika semua log di atas berfungsi, maka lanjutkan logika lainnya
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Produk yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/order/deleteProduct',
                data: { id: productId },
                success: function (response) {
                    console.log('Produk berhasil dihapus'); // Debug hasil sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Produk berhasil dihapus',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    row.remove();
                },
                error: function (xhr) {
                    console.log('Error:', xhr.responseText); // Debug error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat menghapus produk',
                        footer: '<a href="">Why do I have this issue?</a>'
                    });
                }
            });
        }
    });
});


    </script>
</body>
</html>
