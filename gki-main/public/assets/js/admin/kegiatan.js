
var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

$(document).ready(function() {
	tinymce.init({
        selector: 'textarea#body',  // Targetkan textarea yang akan digunakan oleh TinyMCE
        plugins: 'image code link',
        toolbar: 'undo redo | image | link | code',
        images_upload_url: base_url + 'kegiatan/upload_image',  // URL untuk mengunggah gambar
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_handler: function (blobInfo, success, failure) {
            var formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            // Kirim gambar menggunakan Ajax
            $.ajax({
                url: base_url + 'kegiatan/upload_image',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    success(response.location);  // Kembalikan URL gambar ke editor
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    failure('Gagal mengunggah gambar: ' + errorThrown);
                }
            });
        },
        readonly: false,  // Pastikan editor tidak dalam mode read-only
    });
  var dataTable = $('#tabel_serverside').DataTable({
    "processing": true,
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
    "buttons": ['csv'],
    "order": [],
    "ordering": true,
    "info": true,
    "serverSide": true,
    "stateSave": true,
    "scrollX": true,
    "ajax": {
      "url": base_url + "kegiatan/get_list",
      "type": "post",
      "dataType": 'json',
      "data": {},
    },
    columns: [
      {},
      {
        mRender: function(data, type, row) {
          return `${row[2]} `;
        }
      },
      {
        mRender: function(data, type, row) {
          return `${row[4]} `;
        }
      },
      {
        mRender: function(data, type, row) {
          return `${row[5]} `;
        }
      },
      {
        mRender: function(data, type, row) {
          return `
          <a href="javascript:void(0);" class="btn btn-secondary btn-sm edit" id="${row[1]}" nama="${row[2]}">Edit</a>
          <a href="javascript:void(0);" class="btn btn-danger btn-sm delete" id="${row[1]}" nama="${row[2]}">Delete</a>`;
        }
      },
      ],
    "columnDefs": [{
      "targets": [0],
      "orderable": false
    }],
    error: function() {
      $(".tabel_serverside-error").html("");
      $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
      $("#tabel_serverside_processing").css("display", "none");
    }
  });
  });
//tambah
$('.tambah').on('click', function() {
    Swal.fire({
        customClass: 'swal-wide',
        title: 'Tambah Kegiatan',
        html: `
            <form id="form_add_data">
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" placeholder="Nama Kegiatan">
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi Kegiatan</label>
                    <input type="text" class="form-control" id="lokasi" placeholder="Lokasi Kegiatan">
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal">
                </div>
                <div class="form-group">
                    <label for="body">Konten</label>
                    <textarea id="body" class="form-control"></textarea>
                </div>
            </form>
        `,
        didOpen: () => {
            // Hapus instansi TinyMCE yang sebelumnya jika sudah ada
            if (tinymce.get('body')) {
                tinymce.get('body').remove();
            }

            // Inisialisasi TinyMCE setelah SweetAlert terbuka
            tinymce.init({
                selector: 'textarea#body',  // Targetkan textarea body
                plugins: 'image code link',
                toolbar: 'undo redo | image | link | code',
                images_upload_url: base_url + 'kegiatan/upload_image',
                automatic_uploads: true,
            });
        },
        confirmButtonText: 'Simpan',
        preConfirm: () => {
            const nama_kegiatan = Swal.getPopup().querySelector('#nama_kegiatan').value;
            const lokasi = Swal.getPopup().querySelector('#lokasi').value;
            const tanggal = Swal.getPopup().querySelector('#tanggal').value;
            const body = tinyMCE.get('body').getContent();  // Ambil konten dari TinyMCE
            
            // Validasi input sebelum mengirim data
            if (!nama_kegiatan || !lokasi || !tanggal || !body) {
                Swal.showValidationMessage('Silakan lengkapi semua data');
            }
            return { 
                nama_kegiatan: nama_kegiatan, 
                lokasi: lokasi, 
                tanggal: tanggal, 
                body: body 
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim data dengan AJAX ke server
            $.ajax({
                type: "POST",
                url: base_url + 'kegiatan/add',  // URL endpoint untuk menambah kegiatan
                data: {
                    nama_kegiatan: result.value.nama_kegiatan,
                    deskripsi: result.value.body,
                    tanggal: result.value.tanggal,
                    lokasi: result.value.lokasi
                },
                success: function(response) {
                    Swal.fire('Sukses', 'Kegiatan berhasil ditambahkan.', 'success');
                    $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                },
                error: function() {
                    Swal.fire('Error', 'Gagal menambahkan kegiatan.', 'error');
                }
            });
        }
    });
});



    // Edit Konten
   // Edit Konten
$(document).on('click', '.edit', function() {
    const kegiatanId = $(this).attr('id');  // Dapatkan ID kegiatan yang akan diedit

    // AJAX untuk mengambil data kegiatan berdasarkan ID
    $.ajax({
        url: base_url + 'kegiatan/get/' + kegiatanId,  // Endpoint untuk mendapatkan data kegiatan berdasarkan ID
        method: 'GET',
        dataType: 'json',
        success: function(kegiatan) {
            // Tampilkan modal edit dengan SweetAlert
            Swal.fire({
                customClass: 'swal-wide',
                title: 'Edit Kegiatan',
                html: `
                    <form id="form_edit_data">
                        <div class="form-group">
                            <label for="nama_kegiatan">Nama Kegiatan</label>
                            <input type="text" class="form-control" id="nama_kegiatan" value="${kegiatan.nama_kegiatan}">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Kegiatan</label>
                            <input type="text" class="form-control" id="lokasi" value="${kegiatan.lokasi}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" value="${kegiatan.tanggal}">
                        </div>
                        <div class="form-group">
                            <label for="body">Konten</label>
                            <textarea id="body" class="form-control">${kegiatan.deskripsi}</textarea>
                        </div>
                    </form>
                `,
                didOpen: () => {
                    // Hapus instansi TinyMCE yang sebelumnya jika ada
                    if (tinymce.get('body')) {
                        tinymce.get('body').remove();
                    }

                    // Inisialisasi TinyMCE untuk textarea body
                    tinymce.init({
                        selector: 'textarea#body',
                        plugins: 'image code link',
                        toolbar: 'undo redo | image | link | code',
                        images_upload_url: base_url + 'kegiatan/upload_image',
                        automatic_uploads: true,
                    });
                },
                confirmButtonText: 'Update',
                preConfirm: () => {
                    const nama_kegiatan = Swal.getPopup().querySelector('#nama_kegiatan').value;
                    const lokasi = Swal.getPopup().querySelector('#lokasi').value;
                    const tanggal = Swal.getPopup().querySelector('#tanggal').value;
                    const body = tinyMCE.get('body').getContent();  // Ambil konten dari TinyMCE

                    // Validasi input sebelum mengirim data
                    if (!nama_kegiatan || !lokasi || !tanggal || !body) {
                        Swal.showValidationMessage('Silakan lengkapi semua data');
                    }
                    return { 
                        id: kegiatanId, 
                        nama_kegiatan: nama_kegiatan, 
                        lokasi: lokasi, 
                        tanggal: tanggal, 
                        body: body 
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data dengan AJAX ke server untuk memperbarui kegiatan
                    $.ajax({
                        type: "POST",
                        url: base_url + 'kegiatan/update',  // Endpoint untuk memperbarui kegiatan
                        data: {
                            id: result.value.id,
                            nama_kegiatan: result.value.nama_kegiatan,
                            deskripsi: result.value.body,
                            tanggal: result.value.tanggal,
                            lokasi: result.value.lokasi
                        },
                        success: function(response) {
                            Swal.fire('Sukses', 'Kegiatan berhasil diperbarui.', 'success');
                            $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal memperbarui kegiatan.', 'error');
                        }
                    });
                }
            });
        },
        error: function() {
            Swal.fire('Error', 'Gagal memuat data kegiatan.', 'error');
        }
    });
});


    // Hapus Konten
    $(document).on('click', '.delete', function() {
        const kontenId = $(this).attr('id');

        Swal.fire({
            customClass: 'swal-wide',
            title: 'Apakah Anda yakin?',
            text: "Konten ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + '/kegiatan/delete/' + kontenId,
                    success: function() {
                        Swal.fire('Sukses', 'Konten berhasil dihapus.', 'success');
                       $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menghapus konten.', 'error');
                    }
                });
            }
        });
    });
