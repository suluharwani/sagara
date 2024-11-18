<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Detail Order</h2>
        <?php if (!empty($orderDetails)): ?>
            <table class="table table-bordered">
                <thead>
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
                            <td><?= $detail['kode'] ?></td>
                            <td><?= $detail['client_name'] ?></td>
                            <td><?= $detail['product_name'] ?></td>
                            <td><?= number_format($detail['price'], 2) ?></td>
                            <td><?= $detail['status'] == 1 ? 'Aktif' : 'Tidak Aktif' ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm deleteProduct" data-id="<?= $detail['id'] ?>">Hapus</button> <!-- Tombol hapus -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Detail order tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

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
                url: base_url+'admin/order/deleteProduct', 
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
