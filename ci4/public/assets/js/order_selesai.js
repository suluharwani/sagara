var loc = window.location;
var base_url = window.APP_BASE_URL || (loc.protocol + "//" + loc.hostname + (loc.port ? ":" + loc.port : "") + "/");

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>'"]/g, function (character) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;' }[character];
    });
}


$(document).ready(function() {
    var dataTable = $('#tabel_serverside').DataTable( {
        "processing" : true,
        "oLanguage": {
            "sLengthMenu": "Tampilkan _MENU_ data per halaman",
            "sSearch": "Pencarian: ",
            "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
            "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
            "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
            "sInfoFiltered": "(di filter dari _MAX_ total data)",
            "oPaginate": {
                "sFirst": "<<",
                "sLast": ">>",
                "sPrevious": "<",
                "sNext": ">"
            }
        },
        "dom": 'Bfrtip',
        "buttons": [
            'csv'
        ],
        "order": [],
        "ordering": true,
        "info": true,
        "serverSide": true,
        "stateSave" : true,
        "scrollX": true,
        "ajax": {
            "url" : base_url + "admin/order/getOrderSelesai", // json datasource
            "type": "post",  // method, by default get
            "dataType": 'json',
            "data": {},
        },
        columns: [
            {},
            { mRender: function (data, type, row) {
                return row[12];
            }},
            { mRender: function (data, type, row) {
                return row[2];
            }},
            { mRender: function (data, type, row) {
                return `${escapeHtml(row[10])} ${escapeHtml(row[11])}`.trim() || '-';
            }},
            { mRender: function (data, type, row) {
                // Format tanggal Indonesia
                return formatTanggalIndonesia(row[4]);
            }},
            { mRender: function (data, type, row) {
                // Format tanggal Indonesia
                return row[13] ? `<span class="badge bg-light-primary">${escapeHtml(row[13])}</span>` : '-';
            }},
            { mRender: function (data, type, row) {
                const statuses = {
                    0: ['Tidak Aktif', 'bg-secondary'],
                    1: ['Diproses', 'bg-warning text-dark'],
                    2: ['Lunas', 'bg-success'],
                    3: ['Selesai', 'bg-primary'],
                    4: ['Batal', 'bg-danger']
                };
                const status = statuses[row[6]] || ['Tidak diketahui', 'bg-secondary'];
                return `<span class="badge ${status[1]}">${status[0]}</span>`;
            }},
            { mRender: function (data, type, row) {
                const orderId = Number(row[1]);
                const orderCode = encodeURIComponent(row[2] || '');
                const orderLink = encodeURIComponent(row[7] || '');
                return `<div class="btn-group btn-group-sm" role="group" aria-label="Aksi order">
                    <button type="button" class="btn btn-outline-primary viewOrderDetail" data-id="${orderId}" title="Lihat detail"><i class="fas fa-list"></i></button>
                    <button type="button" class="btn btn-outline-success UbahStatus" id="${orderId}" status="${Number(row[6])}" title="Ubah status"><i class="fas fa-sync-alt"></i></button>
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Aksi lainnya</span></button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><button type="button" class="dropdown-item Detail" id="${orderId}"><i class="fas fa-plus me-2"></i>Tambah produk</button></li>
                        <li><button type="button" class="dropdown-item Pembayaran" id="${orderId}"><i class="fas fa-wallet me-2"></i>Pembayaran</button></li>
                        <li><button type="button" class="dropdown-item PaymentHistory" data-id="${orderId}"><i class="fas fa-history me-2"></i>Riwayat pembayaran</button></li>
                        <li><button type="button" class="dropdown-item Link" data-link="${orderLink}"><i class="fas fa-link me-2"></i>Link pelanggan</button></li>
                        <li><a class="dropdown-item" href="${base_url}exportExcel/${orderCode}"><i class="fas fa-file-excel me-2"></i>Unduh Excel</a></li>
                        <li><a class="dropdown-item" href="${base_url}invoice/${orderCode}" target="_blank" rel="noopener"><i class="fas fa-file-invoice me-2"></i>Invoice</a></li>
                        <li><a class="dropdown-item" href="${base_url}shipment/${orderId}" target="_blank" rel="noopener"><i class="fas fa-truck me-2"></i>Form pengiriman</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><button type="button" class="dropdown-item text-danger Delete" id="${orderId}"><i class="fas fa-trash me-2"></i>Hapus order</button></li>
                    </ul>
                </div>`;
            }}
        ],
        "columnDefs": [{
            "targets": [0],
            "orderable": false
        }],
    "rowCallback": function( row, data, index ) {
            // Mengambil tanggal dari row[4]
            var status = data[6];

            if (status == 3) {
                // Lebih dari seminggu - Hijau pudar
                $(row).css('background-color', 'rgba(0, 128, 0, 0.2)'); // hijau pudar
            } else{
                // Kurang dari 3 hari - Merah pudar
                $(row).css('background-color', 'rgba(255, 0, 0, 0.3)'); // merah pudar
            }
        },
        error: function(){  // error handling
            $(".tabel_serverside-error").html("");
            $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
            $("#tabel_serverside_processing").css("display","none");
        }
    });
});


function formatTanggalIndonesia(datetime) {
    // Cek apakah datetime adalah objek Date
    if (!(datetime instanceof Date)) {
        datetime = new Date(datetime); // Konversi string atau nilai lain menjadi objek Date
    }

    const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    let tanggal = datetime.getDate();
    let bulanNama = bulan[datetime.getMonth()];
    let tahun = datetime.getFullYear();
    let jam = datetime.getHours().toString().padStart(2, '0');
    let menit = datetime.getMinutes().toString().padStart(2, '0');
    let detik = datetime.getSeconds().toString().padStart(2, '0');
    let hariNama = hari[datetime.getDay()];

    // Format: Hari, Tanggal Bulan Tahun Jam:Menit:Detik
    return `${hariNama}, ${tanggal} ${bulanNama} ${tahun} ${jam}:${menit}:${detik}`;
}
$(document).on('click', '.UbahStatus', function () {
  const orderId = $(this).attr('id');
  const currentStatus = $(this).attr('status'); // Mengambil status saat ini dari elemen

  Swal.fire({
    title: 'Ubah Status Order',
    input: 'select',
    inputOptions: {
      '0': 'Tidak Aktif',
      '1': 'DP Masuk (Diproses)',
      '2': 'Lunas',
      '3': 'Selesai',
      '4': 'Batal'
    },
    inputValue: currentStatus,  // Mengatur status default sesuai dengan status yang ada
    // inputPlaceholder: 'Pilih status baru',
    showCancelButton: true,
    confirmButtonText: 'Ubah Status',
    preConfirm: (status) => {
      if (!status) {
        Swal.showValidationMessage('Anda harus memilih status');
      }
      return status;
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const newStatus = result.value;

      // Kirim permintaan ke server untuk memperbarui status
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/order/ubahStatus', // Ganti dengan endpoint yang sesuai
        data: {
          id: orderId,
          status: newStatus
        },
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Status berhasil diubah',
            showConfirmButton: false,
            timer: 1500
          });

          // Reload DataTable untuk merefleksikan perubahan status
          $('#tabel_serverside').DataTable().ajax.reload();
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat mengubah status',
            footer: '<a href="">Why do I have this issue?</a>'
          });
        }
      });
    }
  });
});
$(document).on('click', '.Link', function () {
  const orderLink = decodeURIComponent($(this).data('link') || '');

  // Tampilkan modal dengan SweetAlert
  Swal.fire({
    title: 'Order Link',
    html: `<a href="${escapeHtml(orderLink)}" target="_blank" rel="noopener">${escapeHtml(orderLink)}</a>`,
    showCancelButton: true,
    cancelButtonText: 'Tutup',
    confirmButtonText: 'Buka Link'
  }).then((result) => {
    if (result.isConfirmed) {
      // Jika pengguna memilih "Buka Link", kita akan membuka link di tab baru
      window.open(orderLink, '_blank');
    }
  });
});
$(document).on('click', '.Delete', function () {
  const orderId = $(this).attr('id'); // Mengambil ID order dari data-id
  
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Data yang dihapus tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Kirim permintaan ke server untuk menghapus order
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/order/deleteOrder', // Endpoint untuk menghapus order
        data: { id: orderId },
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Order berhasil dihapus',
            showConfirmButton: false,
            timer: 1500
          });

          // Reload DataTable setelah penghapusan
          $('#tabel_serverside').DataTable().ajax.reload();
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menghapus order',
            footer: '<a href="">Why do I have this issue?</a>'
          });
        }
      });
    }
  });
});
$(document).on('click', '.Pembayaran', function () {
  const orderId = $(this).attr('id'); // Mengambil ID order dari atribut id

  // Munculkan popup input untuk pembayaran
  Swal.fire({
    title: 'Input Pembayaran',
    html: `
      <form id="form_payment">
        <div class="form-group">
          <label for="name">Nama Pembayar</label>
          <input type="text" id="name" class="form-control" placeholder="Nama pembayar" required>
        </div>
        <div class="form-group">
          <label for="price">Jumlah Pembayaran</label>
          <input type="number" id="price" class="form-control" placeholder="Masukkan jumlah pembayaran" required>
        </div>
        <div class="form-group">
          <label for="downpayment">Uang Muka (DP)</label>
          <input type="number" id="downpayment" class="form-control" placeholder="Masukkan jumlah DP">
        </div>
        <div class="form-group">
          <label for="completion">Nominal Pelunasan</label>
          <input type="number" id="completion" class="form-control" placeholder="Masukkan nominal pelunasan">
        </div>
        <div class="form-group">
          <label for="discount">Diskon (%)</label>
          <input type="number" id="discount" class="form-control" placeholder="Masukkan diskon (jika ada)">
        </div>
        <div class="form-group">
          <label for="status">Status Pembayaran</label>
          <select id="status" class="form-control">
            <option value="1">Lunas</option>
            <option value="0">Belum Lunas</option>
          </select>
        </div>
      </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Simpan Pembayaran',
    preConfirm: () => {
      return {
        name: $('#name').val(),
        price: $('#price').val(),
        downpayment: $('#downpayment').val(),
        completion: $('#completion').val(), // Mengambil input pelunasan
        discount: $('#discount').val(),
        status: $('#status').val()
      };
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const paymentData = result.value;

      // Kirim data pembayaran ke server
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/order/addPayment', // Endpoint untuk menambah pembayaran
        data: {
          id_order: orderId,
          ...paymentData // Spread payment data
        },
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Pembayaran berhasil ditambahkan',
            showConfirmButton: false,
            timer: 1500
          });

          // Reload tabel riwayat pembayaran
          loadPaymentHistory(orderId);
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menambahkan pembayaran',
            footer: '<a href="">Why do I have this issue?</a>'
          });
        }
      });
    }
  });
});

function loadPaymentHistory(orderId) {
  $.ajax({
    type: 'GET',
    url: base_url + 'admin/order/paymentHistory', // Endpoint untuk mendapatkan riwayat pembayaran
    data: { id_order: orderId },
    success: function (response) {
      // Kosongkan tabel sebelumnya
      $('#payment_history_table tbody').empty();

      response.payments.forEach(payment => {
        const row = `
          <tr>
            <td>${payment.name}</td>
            <td>${payment.price}</td>
            <td>${payment.downpayment}</td>
            <td>${payment.completion}</td> <!-- Menampilkan nominal pelunasan -->
            <td>${payment.discount}</td>
            <td>${payment.created_at}</td>
            <td>
              <button class="btn btn-danger btn-sm DeletePayment" data-id="${payment.id}">Hapus</button>
            </td>
          </tr>
        `;
        $('#payment_history_table tbody').append(row);
      });
    }
  });
}
$(document).on('click', '.DeletePayment', function () {
  const paymentId = $(this).data('id');

  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Pembayaran yang dihapus tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/order/deletePayment', // Endpoint untuk menghapus riwayat pembayaran
        data: { id: paymentId },
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Pembayaran berhasil dihapus',
            showConfirmButton: false,
            timer: 1500
          });

          // Reload tabel riwayat pembayaran
          loadPaymentHistory(orderId);
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menghapus pembayaran',
            footer: '<a href="">Why do I have this issue?</a>'
          });
        }
      });
    }
  });
});

$(document).on('click', '.PaymentHistory', function () {
  const orderId = $(this).data('id'); // Mengambil ID order dari atribut data-id

  // Buat AJAX request untuk mengambil riwayat pembayaran
  $.ajax({
    type: 'GET',
    url: base_url + 'admin/order/paymentHistory', // Endpoint untuk mendapatkan riwayat pembayaran
    data: { id_order: orderId },
    success: function (response) {
      let paymentHistoryHtml = '';

      // Cek jika ada pembayaran yang ditemukan
      if (response.payments.length > 0) {
        paymentHistoryHtml = `
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nama Pembayar</th>
                <th>Jumlah Pembayaran</th>
                <th>Uang Muka (DP)</th>
                <th>Pelunasan</th>
                <th>Diskon</th>
                <th>Tanggal Pembayaran</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
        `;

        // Iterasi untuk setiap pembayaran dalam respons
        response.payments.forEach(payment => {
          paymentHistoryHtml += `
            <tr>
              <td>${payment.name}</td>
              <td>${payment.price}</td>
              <td>${payment.downpayment}</td>
              <td>${payment.completion}</td>
              <td>${payment.discount}</td>
              <td>${payment.created_at}</td>
              <td>
                <button class="btn btn-danger btn-sm DeletePayment" data-id="${payment.id}">Hapus</button>
              </td>
            </tr>
          `;
        });

        paymentHistoryHtml += `
            </tbody>
          </table>
        `;
      } else {
        paymentHistoryHtml = '<p>Tidak ada riwayat pembayaran ditemukan.</p>';
      }

      // Tampilkan modal dengan riwayat pembayaran
      Swal.fire({
        title: 'Riwayat Pembayaran',
        html: paymentHistoryHtml,
        width: '800px',
        showCancelButton: true,
        cancelButtonText: 'Tutup'
      });
    },
    error: function (xhr) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Terjadi kesalahan saat mengambil riwayat pembayaran',
        footer: '<a href="">Why do I have this issue?</a>'
      });
    }
  });
});
$(document).on('click', '.DeletePayment', function () {
  const paymentId = $(this).data('id'); // Mengambil ID pembayaran dari data-id

  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: "Pembayaran yang dihapus tidak dapat dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // AJAX request untuk menghapus pembayaran
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/order/deletePayment', // Endpoint untuk menghapus riwayat pembayaran
        data: { id: paymentId },
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Pembayaran berhasil dihapus',
            showConfirmButton: false,
            timer: 1500
          });

          // Setelah berhasil, panggil ulang loadPaymentHistory untuk merefresh data
          loadPaymentHistory(orderId);
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menghapus pembayaran',
            footer: '<a href="">Why do I have this issue?</a>'
          });
        }
      });
    }
  });
});$(document).on('click', '.Detail', function () {
  const orderId = $(this).attr('id'); // Mengambil ID order dari atribut id

  // Buat AJAX request untuk mengambil daftar produk
  $.ajax({
    type: 'GET',
    url: base_url + 'admin/order/getProducts', // Endpoint untuk mendapatkan produk
    success: function (response) {
      let productOptions = '';

      // Buat opsi produk dari data yang diterima
      response.products.forEach(product => {
        productOptions += `<option value="${product.id}">${product.nama}</option>`;
      });

      let orderProductHtml = `
        <form id="form_order_list">
          <table class="table table-bordered" id="order_product_table">
            <thead>
              <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select class="form-control product-select" name="id_product[]">
                    ${productOptions}
                  </select>
                </td>
                <td>
                  <input type="number" class="form-control product-price" name="price[]" placeholder="Masukkan harga">
                </td>
                <td>
                  <button type="button" class="btn btn-danger btn-sm remove-product">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
          <button type="button" class="btn btn-primary btn-sm" id="addProduct">Tambah Produk</button>
        </form>
      `;

      // Tampilkan modal dengan form produk
      Swal.fire({
        title: 'Detail Order',
        html: orderProductHtml,
        width: '800px',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        preConfirm: () => {
          // Ambil data dari form
          const formData = $('#form_order_list').serializeArray();
          // Konversi form data menjadi format array of objects yang lebih mudah dibaca
          const processedData = convertFormDataToObject(formData);
          return processedData;
        }
      }).then((result) => {
        if (result.isConfirmed) {
          const orderData = result.value;

          // Kirim data produk ke server untuk disimpan
          $.ajax({
            type: 'POST',
            url: base_url + 'admin/order/saveOrderProducts', // Endpoint untuk menyimpan produk dalam order
            data: {
              id_order: orderId,
              order_data: orderData
            },
            success: function (response) {
              Swal.fire({
                icon: 'success',
                title: 'Produk berhasil ditambahkan ke order',
                showConfirmButton: false,
                timer: 1500
              });
            },
            error: function (xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat menyimpan produk',
                footer: '<a href="">Why do I have this issue?</a>'
              });
            }
          });
        }
      });
    },
    error: function (xhr) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Terjadi kesalahan saat mengambil daftar produk',
        footer: '<a href="">Why do I have this issue?</a>'
      });
    }
  });
});

// Fungsi untuk konversi serializeArray menjadi format yang lebih mudah
function convertFormDataToObject(formData) {
  const dataObj = {};
  
  formData.forEach(item => {
    const name = item.name.replace('[]', ''); // Hilangkan tanda []
    if (!dataObj[name]) {
      dataObj[name] = [];
    }
    dataObj[name].push(item.value);
  });

  return dataObj;
}

// Event listener untuk menambah baris produk baru
$(document).on('click', '#addProduct', function () {
  const productRow = `
    <tr>
      <td>
        <select class="form-control product-select" name="id_product[]">
          ${$('.product-select').first().html()}
        </select>
      </td>
      <td>
        <input type="number" class="form-control product-price" name="price[]" placeholder="Masukkan harga">
      </td>
      <td>
        <button type="button" class="btn btn-danger btn-sm remove-product">Hapus</button>
      </td>
    </tr>
  `;
  $('#order_product_table tbody').append(productRow);
});

// Event listener untuk menghapus baris produk
$(document).on('click', '.remove-product', function () {
  $(this).closest('tr').remove();
});

$(document).on('click', '.viewOrderDetail', function () {
    const orderId = $(this).data('id'); // Mengambil ID order dari tombol
    
    // Membuat URL tujuan
    const url = base_url + 'admin/order/detail/' + orderId;
    
    // Redirect ke URL di tab baru
    window.open(url, '_blank');
});
