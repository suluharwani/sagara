var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";


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
            "url" : base_url + "admin/order/getOrder", // json datasource
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
                return `${row[10]} ${row[10]}`;
            }},
            { mRender: function (data, type, row) {
                // Format tanggal Indonesia
                return formatTanggalIndonesia(row[4]);
            }},
            { mRender: function (data, type, row) {
                // Format tanggal Indonesia
                return row[13];
            }},
            { mRender: function (data, type, row) {
                if (row[6] == 0) {
                    status = "Tidak Aktif";
                } else if (row[6] == 1) {
                    status = "DP Masuk (Diproses)";
                } else if (row[6] == 2) {
                    status = "Lunas";
                } else if (row[6] == 3) {
                    status = "Selesai";
                } else if (row[6] == 4) {
                    status = "Batal";
                } else {
                    status = "Tidak ada";
                }
                return status;
            }},
            { mRender: function (data, type, row) {
                return `<a href="javascript:void(0);" class="btn btn-success btn-sm Detail" id="${row[1]}" >Add Detail</a>
                        <a href="javascript:void(0);" class="btn btn-success btn-sm viewOrderDetail" data-id="${row[1]}" >List Detail</a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm Pembayaran" id="${row[1]}" >Pembayaran</a>
                        <a href="javascript:void(0);" class="btn btn-info btn-sm PaymentHistory" data-id="${row[1]}">Riwayat Pembayaran</a>
                        <a href="javascript:void(0);" class="btn btn-warning btn-sm Link" id="${row[1]}" link = "${row[7]}">Link</a>
                        <a href="javascript:void(0);" class="btn btn-warning btn-sm UbahStatus" id="${row[1]}" status = "${row[6]}">Ubah Status</a>
                        <a href="${base_url}exportExcel/${row[2]}" class="btn btn-warning btn-sm">Download Excel</a>
                        <a href="${base_url}invoice/${row[2]}" class="btn btn-warning btn-sm">Invoice</a>
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm resi" id="${row[1]}" no_resi ="${row[13]}" ">Resi</a>
                        <a href="javascript:void(0);" onclick="printpengirimanPDF('${row[1]}')" class="btn btn-primary btn-sm">Pengiriman</a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm Delete" id="${row[1]}" >Delete</a>`;
            }}
        ],
        "columnDefs": [{
            "targets": [0],
            "orderable": false
        }],
    "rowCallback": function( row, data, index ) {
            // Mengambil tanggal dari row[4]
            var rowDate = new Date(data[4]);
            var currentDate = new Date();
            var timeDiff = rowDate - currentDate ;
            var daysDiff = Math.floor(timeDiff / (1000 * 3600 * 24)); // Menghitung selisih hari
            console.log(daysDiff)
            if (daysDiff > 7) {
                // Lebih dari seminggu - Hijau pudar
                $(row).css('background-color', 'rgba(0, 128, 0, 0.2)'); // hijau pudar
            } else if (daysDiff <= 7 && daysDiff > 3) {
                // Kurang dari seminggu - Kuning pudar
                $(row).css('background-color', 'rgba(255, 255, 0, 0.3)'); // kuning pudar
            } else if (daysDiff <= 3) {
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
$('.tambahOrder').on('click', function () {
  $.when(
    $.ajax({
      url: base_url + '/admin/user/getClient',
      method: 'POST',
      dataType: 'json', // Mengharapkan respons dalam format JSON
    })
  ).done(function (clientsResponse) {
    const clientsData = clientsResponse;
    if (Array.isArray(clientsData)) {
      console.log(clientsData)
      let clientOptions = clientsData.map(client => `<option value="${client.id}">${client.nama_depan} ${client.nama_belakang}</option>`).join('');

      const generateHash = () => {
        return Math.random().toString(36).substr(2, 9);
      };

      const kode = generateHash();

      Swal.fire({
        title: 'Tambah Order',
        html: `
          <form id="form_add_data" enctype="multipart/form-data">
            <div class="form-group">
              <label for="kode">Kode</label>
              <input type="text" class="form-control" id="kode" value="${kode}" readonly>
            </div>
            <div class="form-group">
              <label for="id_client">Client</label>
              <select class="form-control" id="id_client" required>
                ${clientOptions}
              </select>
            </div>
            <div class="form-group">
              <label for="nama_tim">Nama Tim</label>
              <input type="text" class="form-control" id="nama_tim" required>
            </div>
            <div class="form-group">
              <label for="brand">Brand/Merk</label>
              <input type="text" class="form-control" id="brand" required>
            </div>
            <div class="form-group">
              <label for="logo_tim">Logo Tim</label>
              <input type="file" class="form-control" id="logo_tim" accept="image/*" required>
            </div>
            <div class="form-group">
              <label for="deadline">Deadline</label>
              <input type="date" class="form-control" id="deadline" required>
            </div>
            <div class="form-group">
              <label for="deadline">Deskripsi Bahan</label>
              <textarea class="form-control" rows="5" id="deskripsi" required style="width: 100%;"></textarea>
            </div>
          </form>
        `,
        confirmButtonText: 'Confirm',
        focusConfirm: false,
        preConfirm: () => {
          const kode = Swal.getPopup().querySelector('#kode').value;
          const id_client = Swal.getPopup().querySelector('#id_client').value;
          const nama_tim = Swal.getPopup().querySelector('#nama_tim').value;
          const brand = Swal.getPopup().querySelector('#brand').value;
          const deadline = Swal.getPopup().querySelector('#deadline').value;
          const deskripsi = Swal.getPopup().querySelector('#deskripsi').value;
          const logo_tim = Swal.getPopup().querySelector('#logo_tim').files[0]; // Mendapatkan file logo

          if (!deskripsi||!kode || !id_client || !nama_tim || !brand || !deadline || !logo_tim) {
            Swal.showValidationMessage('Silakan lengkapi semua data');
          }

          const link = `${base_url}/order/${kode}`;

          return { deskripsi,kode, id_client, nama_tim, brand, deadline, link, logo_tim };
        },
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = new FormData();
          formData.append('kode', result.value.kode);
          formData.append('id_client', result.value.id_client);
          formData.append('nama_tim', result.value.nama_tim);
          formData.append('brand', result.value.brand);
          formData.append('deadline', result.value.deadline);
          formData.append('link', result.value.link);
          formData.append('deskripsi', result.value.deskripsi);
          formData.append('logo_tim', result.value.logo_tim); // Menambahkan logo ke formData

          $.ajax({
            type: 'POST',
            url: base_url + 'admin/order/tambahOrder',
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Order berhasil ditambahkan.',
                showConfirmButton: false,
                timer: 1500,
              });
              $('#tabel_serverside').DataTable().ajax.reload();
            },
            error: function (xhr) {
              let d = JSON.parse(xhr.responseText);
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `${d.message}`,
                footer: '<a href="">Why do I have this issue?</a>',
              });
            },
          });
        }
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Data client tidak dalam format yang diharapkan.',
        footer: '<a href="">Why do I have this issue?</a>',
      });
    }
  }).fail(function () {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Gagal memuat data client.',
      footer: '<a href="">Why do I have this issue?</a>',
    });
  });
});

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
$(document).on('click', '.resi', function () {
  const orderId = $(this).attr('id');
  const resi = $(this).attr('no_resi')|| ""; // Mengambil status saat ini dari elemen

  Swal.fire({
    title: 'Input Pembayaran',
    html: `
      <form id="form_payment">
        <div class="form-group">
          <label for="name">Resi</label>
          <input type="text" id="resi" class="form-control" placeholder="Masukkan resi" value="${resi}" required>
        </div>
        
      </form>
    `,
    showCancelButton: true,
    confirmButtonText: 'Simpan Resi',
    preConfirm: () => {
      return {
        resi: $('#resi').val(),
      };
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const resiData = result.value;

      // Kirim data pembayaran ke server
      $.ajax({
        type: 'POST',
        url: base_url + 'admin/order/updateResi', // Endpoint untuk menambah pembayaran
        data: {
          id: orderId,
          ...resiData // Spread payment data
        },
        success: function (response) {
          Swal.fire({
            icon: 'success',
            title: 'Resi berhasil ditambahkan',
            showConfirmButton: false,
            timer: 1500
          });

          // Reload tabel riwayat pembayaran
          // loadPaymentHistory(orderId);
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan saat menambahkan resi',
            footer: '<a href="">Why do I have this issue?</a>'
          });
        }
      });
    }
  });
});
$(document).on('click', '.Link', function () {
  const orderLink = $(this).attr('link'); // Mengambil link dari atribut data-link

  // Tampilkan modal dengan SweetAlert
  Swal.fire({
    title: 'Order Link',
    html: `<a href="${orderLink}" target="_blank">${orderLink}</a>`, // Menampilkan link sebagai elemen klik
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
    const url = base_url+'/admin/order/detail/' + orderId;
    
    // Redirect ke URL di tab baru
    window.open(url, '_blank');
});


function printpengirimanPDF(id) {
  // Fetch the order data based on the ID
  $.ajax({
      url: base_url +`home/getOrder/${id}`, // Adjust the endpoint as necessary
      method: 'GET',
      success: function(response) {
          if (response.success) {
              const orderData = response.data;

              // Create a new jsPDF instance with A6 size
              const { jsPDF } = window.jspdf;
              const doc = new jsPDF({
                  orientation: "portrait",
                  unit: "mm",
                  format: "a6",
                  putOnlyUsedFonts: true,
                  floatPrecision: 16 // or "smart", default is 16
              });

              // Function to add order details to the PDF
              function addOrderDetails(startY) {
                  // Set the title
                  doc.setFontSize(16);
                  doc.text("Resi Pengiriman", 10, startY);

                  // Add order details as a table
                  const tableStartY = startY + 10;
                  const rowHeight = 7;
                  const columnX = 10;
                  const labelWidth = 30;

                  const orderDetails = [
                      // { label: "Kode", value: orderData.kode },
                      // { label: "Deadline", value: formatTanggalSaja(orderData.deadline) },
                      // { label: "Status", value: orderData.status },
                      { label: "Brand", value: orderData.brand },
                      { label: "Pengirim", value: orderData.pengirim },
                      { label: "No Pengirim", value: orderData.no_pengirim },
                      { label: "Nama Tim", value: orderData.nama_tim },
                      { label: "Penerima", value: orderData.penerima },
                      { label: "Alamat", value: orderData.alamat },
                      { label: "Kodepos", value: orderData.kodepos },
                      { label: "No Penerima", value: orderData.no_penerima },

                  ];

                  doc.setFontSize(12);
                  orderDetails.forEach((detail, index) => {
                      const rowY = tableStartY + index * rowHeight;
                      doc.text(`${detail.label}`, columnX, rowY);
                      doc.text(`${detail.value}`, columnX + labelWidth, rowY);
                  });

                  // Add a footer or additional information if necessary
                  doc.setFontSize(10);
                  const footerY = tableStartY + orderDetails.length * rowHeight + 10;
                  doc.text("Terima kasih atas pesanan Anda!", 10, footerY);
                  doc.text("Harap divideokan saat unboxing", 10, footerY + 10);

                  // Save the PDF
                  doc.save(`Alamat Pengiriman ${orderData.nama_tim} - brand ${orderData.brand}.pdf`);
              }

              // Load the logo image if it exists
              if (orderData.logo_tim) {
                  const logoImg = new Image();
                  logoImg.src = orderData.logo_tim; // Assuming logo_tim is a URL to the image

                  logoImg.onload = function() {
                      // Add the logo to the PDF
                      doc.addImage(logoImg, 'PNG', 10, 10, 30, 30); // Adjust the position and size as needed
                      addOrderDetails(50); // Call to add order details after logo is added, starting below the logo
                  };

                  logoImg.onerror = function() {
                      // If logo fails to load, just continue without adding it
                      addOrderDetails(10); // Call to add order details starting from the top
                  };
              } else {
                  // If no logo URL, directly add the order details
                  addOrderDetails(10); // Call to add order details starting from the top
              }
          } else {
              Swal.fire('Gagal', response.message, 'error');
          }
      },
      error: function() {
          Swal.fire('Gagal', 'Terjadi kesalahan saat mengambil data', 'error');
      }
  });
}