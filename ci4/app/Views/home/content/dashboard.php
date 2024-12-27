<!-- Include SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="<?=base_url('assets')?>/template/dist/assets/extensions/sweetalert2/sweetalert2.min.css">
<script src="<?=base_url('assets')?>/template/dist/assets/extensions/sweetalert2/sweetalert2.min.js"></script>

<!-- CSS DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- JS DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<div role="main" class="main">
    <section class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a></li>
                        <li class="active">Client</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h1 class="font-weight-bold">Dashboard</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section pt-0">
        <div class="container container-lg-custom">
            <table id="myTable" class="display responsive nowrap" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Nama Tim</th>
                        <th>Brand</th>
                        <th>Alamat</th> <!-- New column for Alamat -->
                        <th>Kodepos</th> <!-- New column for Kodepos -->
                        <th>Actions</th> <!-- Column for the action button -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated here by DataTables -->
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    var loc = window.location;
    var base_url = loc.protocol + "//" + loc.hostname + (loc.port ? ":" + loc.port : "") + "/";

    $('#myTable').DataTable({
        "ajax": {
            "url": base_url + "client/getOrder",
            "dataSrc": "",
            "error": function(xhr, status, error) {
                console.error("Error loading data:", error);
            }
        },
        "columns": [
            { 
                "title": "No",  // Change the title to "No"
                "render": function(data, type, row, meta) {
                    return meta.row + 1; // meta.row is zero-based, so we add 1 to start from 1
                }
            },
            { "data": "kode", "title": "Download",
                "render": function(data, type, row) {
                    return '<a href="'+base_url+'exportExcel/'+data+'" class="btn btn-success">Pesanan</a> <a href="'+base_url+'exportExcel/'+data+'" class="btn btn-warning">Invoice</a> <a href="'+base_url+'exportExcel/'+data+'" class="btn btn-secondary">Resi</a>';
                }
            },
            { "data": "deadline", "title": "Deadline",
                "render": function(data, type, row) {
                    return '<a href="'+data+'" target="_blank">' + formatTanggalSaja(data) + '</a>';
                }
             },
            {"data": "link", "title": "Link",
                "render": function(data, type, row) {
                    return '<a href="'+data+'" target="_blank">' + data + '</a>';
                }
            },
            { "data": "nama_tim", "title": "Nama Tim" },
            { "data": "brand", "title": "Brand" },
            { "data": "alamat", "title": "Alamat" }, 
            { "data": "kodepos", "title": "Kodepos" },
            { "title": "Actions", 
                "render": function(data, type, row) {
                    return '<button class="btn btn-primary btn-sm" onclick="showAddressForm(' + row.id + ')">Add Alamat</button>';
                }
            } 
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "responsive": true, // Enable responsive feature
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data yang ditemukan",
            "zeroRecords": "Tidak ada data yang sesuai",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});

function formatTanggalSaja(dateString) {
    // Mengonversi string tanggal ke objek Date
    const date = new Date(dateString);
    
    // Memeriksa apakah objek Date valid
 
    // Daftar nama bulan dalam bahasa Indonesia
    const months = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    // Mendapatkan tanggal, bulan, dan tahun
    const dateNum = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();

    // Mengembalikan string tanggal dalam format "DD Bulan YYYY"
    return `${dateNum} ${month} ${year}`;
}
// Function to show the SweetAlert2 input form for address and postal code
function showAddressForm(id) {
    // Mengambil data alamat jika ID diberikan
    if (id) {
        $.ajax({
            url: `home/getOrder/${id}`, // Ganti dengan endpoint yang sesuai untuk mendapatkan data
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Menampilkan form dengan data yang diambil
                    displayForm(response.data);
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Gagal', 'Terjadi kesalahan saat mengambil data', 'error');
            }
        });
    } else {
        // Jika tidak ada ID, tampilkan form kosong
        displayForm({});
    }
}

function displayForm(data) {
    Swal.fire({
        title: 'Input Alamat dan Kodepos',
        html: `
            <form id="addressForm">
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" class="form-control" placeholder="Masukkan brand" value="${data.brand || ''}">
                </div>
                <div class="form-group">
                    <label for="namaPengirim">Nama Pengirim</label>
                    <input type="text" id="namaPengirim" class="form-control" placeholder="Masukkan nama pengirim" value="${data.nama_pengirim || ''}">
                </div>
                <div class="form-group">
                    <label for="noTeleponPengirim">No Telepon Pengirim</label>
                    <input type="text" id="noTeleponPengirim" class="form-control" placeholder="Masukkan no telepon pengirim" value="${data.no_telepon_pengirim || ''}">
                </div>
                <div class="form-group">
                    <label for="alamatTujuan">Alamat Tujuan</label>
                    <textarea id="alamatTujuan" class="form-control" placeholder="Masukkan alamat tujuan">${data.alamat || ''}</textarea>
                </div>
                <div class="form-group">
                    <label for="penerima">Penerima</label>
                    <input type="text" id="penerima" class="form-control" placeholder="Masukkan nama penerima" value="${data.penerima || ''}">
                </div>
                <div class="form-group">
                    <label for="kodepos">Kodepos</label>
                    <input type="text" id="kodepos" class="form-control" placeholder="Masukkan kodepos" value="${data.kodepos || ''}">
                </div>
                <div class="form-group">
                    <label for="noTeleponPenerima">No Telepon Penerima</label>
                    <input type="text" id="noTeleponPenerima" class="form-control" placeholder="Masukkan no telepon penerima" value="${data.no_telepon_penerima || ''}">
                </div>
                <input type="hidden" id="orderId" value="${data.id || ''}"> <!-- Menyimpan ID untuk update -->
            </form>
        `,
        confirmButtonText: 'Simpan',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const orderData = {
                id: document.getElementById('orderId').value,
                brand: document.getElementById('brand').value,
                nama_pengirim: document.getElementById('namaPengirim').value,
                no_telepon_pengirim: document.getElementById('noTeleponPengirim').value,
                alamat: document.getElementById('alamatTujuan').value,
                penerima: document.getElementById('penerima').value,
                kodepos: document.getElementById('kodepos').value,
                no_telepon_penerima: document.getElementById('noTeleponPenerima').value
            };

            // Validasi input
            for (const key in orderData) {
                if (!orderData[key]) {
                    Swal.showValidationMessage(`${key.replace(/_/g, ' ')} harus diisi`);
                    return false;
                }
            }

            // Mengirim data ke server
            return $.ajax({
                url: 'order/save', // Ganti dengan endpoint yang sesuai untuk menyimpan data
                method: 'POST',
                data: orderData
            });
        }
    }).then((result ) => {
        if (result.isConfirmed) {
            if (result.value.success) {
                Swal.fire('Sukses', result.value.message, 'success');
                // Refresh atau update tampilan jika perlu
            } else {
                Swal.fire('Gagal', result.value.errors.join(', '), 'error');
            }
        }
    });
}
// Mengambil data order untuk diupdate
function fetchOrderData(orderId) {
    $.ajax({
        url: `home/getOrder/${orderId}`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                // Isi form dengan data yang diterima
                $('#brand').val(response.data.brand);
                $('#namaPengirim').val(response.data.nama_pengirim);
                $('#noTeleponPengirim').val(response.data.no_telepon_pengirim);
                $('#alamatTujuan').val(response.data.alamat);
                $('#penerima').val(response.data.penerima);
                $('#kodepos').val(response.data.kodepos);
                $('#noTeleponPenerima').val(response.data.no_telepon_penerima);
            } else {
                Swal.fire('Gagal', response.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Gagal', 'Terjadi kesalahan saat mengambil data', 'error');
        }
    });
}

function saveOrderData() {
    const orderData = {
        id: $('#orderId').val(), // ID yang akan diupdate
        kode: $('#kode').val(),
        id_client: $('#id_client').val(),
        alamat: $('#alamat').val(),
        kodepos: $('#kodepos').val(),
        brand: $('#brand').val(),
        nama_tim: $('#nama_tim').val(),
        logo_tim: $('#logo_tim').val(),
        // Tambahkan field lain sesuai kebutuhan
    };

    $.ajax({
        url: 'home/saveOrder',
        method: 'POST',
        data: orderData,
        success: function(response) {
            if (response.success) {
                Swal.fire('Sukses', response.message, 'success');
                // Refresh atau update tampilan jika perlu
            } else {
                Swal.fire('Gagal', response.errors.join(', '), 'error');
            }
        },
        error: function() {
            Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data', 'error');
        }
    });
}
</script>
