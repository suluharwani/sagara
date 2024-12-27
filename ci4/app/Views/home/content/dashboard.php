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
                    return '<a href="'+base_url+'exportExcel/'+data+'" class="btn btn-success">' + data + '</a>';
                }
            },
            { "data": "deadline", "title": "Deadline" },
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

// Function to show the SweetAlert2 input form for address and postal code
function showAddressForm(id) {
    Swal.fire({
        title: 'Input Alamat dan Kodepos',
        html: `
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" class="swal2-input" placeholder="Masukkan alamat">
            </div>
            <div class="form-group">
                <label for="kodepos">Kodepos</label>
                <input type="text" id="kodepos" class="swal2-input" placeholder="Masukkan kodepos">
            </div>
        `,
        confirmButtonText: 'Simpan',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const alamat = document.getElementById('alamat').value;
            const kodepos = document.getElementById('kodepos').value;

            // Validate the inputs
            if (!alamat || !kodepos) {
                Swal.showValidationMessage('Alamat dan Kodepos harus diisi');
                return false;
            }

            // Make AJAX call to save the data
            $.ajax({
                url: 'home/updateAddress', // Replace with your server endpoint
                method: 'POST',
                data: {
                    id: id,      // Send the ID of the item being updated
                    alamat: alamat,
                    kodepos: kodepos
                },
                success: function(response) {
                    if (response.success) {
                        // If success, update the DataTable with the new data
                        var table = $('#myTable').DataTable();
                        var row = table.row(function(idx, data, node) {
                            return data.id === id; // Find the row by ID
                        });

                        // Update the row with new alamat and kodepos
                        row.data().alamat = alamat;
                        row.data().kodepos = kodepos;
                        table.row(row).invalidate().draw(); // Invalidate the row and redraw the table

                        Swal.fire('Data berhasil disimpan!', '', 'success');
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan data', 'error');
                }
            });
        }
    });
}

</script>
