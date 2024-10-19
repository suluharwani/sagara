
var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

$(document).ready(function() {
	tinymce.init({
        selector: 'textarea#body',  // Targetkan textarea yang akan digunakan oleh TinyMCE
        plugins: 'image code link',
        toolbar: 'undo redo | image | link | code',
        images_upload_url: base_url + 'sejarah/upload_image',  // URL untuk mengunggah gambar
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_handler: function (blobInfo, success, failure) {
            var formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            // Kirim gambar menggunakan Ajax
            $.ajax({
                url: base_url + 'sejarah/upload_image',
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
      "url": base_url + "sejarah/get_list",
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
        title: 'Tambah Konten',
        html: `
            <form id="form_add_data">
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" class="form-control" id="title" placeholder="Judul">
                </div>
                <div class="form-group">
                    <label for="body">Konten</label>
                    <textarea id="body" class="form-control"></textarea>
                </div>
            </form>
        `,
        didOpen: () => {
        	if (tinymce.get('body')) {
                tinymce.get('body').remove();
            }
            // Inisialisasi TinyMCE setelah SweetAlert terbuka
            tinymce.init({
                selector: 'textarea#body',  // Targetkan textarea body
                plugins: 'image code link',
                toolbar: 'undo redo | image | link | code',
                images_upload_url: base_url + 'sejarah/upload_image',
                automatic_uploads: true,
            });
        },
        confirmButtonText: 'Simpan',
        preConfirm: () => {
            const title = Swal.getPopup().querySelector('#title').value;
            const body = tinyMCE.get('body').getContent();  // Ambil konten dari TinyMCE
            
            // Validasi input sebelum mengirim data
            if (!title || !body) {
                Swal.showValidationMessage('Silakan lengkapi data');
            }
            return { title: title, body: body };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim data dengan AJAX ke server
            $.ajax({
                type: "POST",
                url: base_url + 'sejarah/add',  // URL endpoint untuk menambah konten
                data: {
                    title: result.value.title,
                    body: result.value.body
                },
                success: function(response) {
                    Swal.fire('Sukses', 'Konten berhasil ditambahkan.', 'success');
                    $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                },
                error: function() {
                    Swal.fire('Error', 'Gagal menambahkan konten.', 'error');
                }
            });
        }
    });
});



    // Edit Konten
   // Edit Konten
$(document).on('click', '.edit', function() {
    const kontenId = $(this).attr('id');

    // AJAX untuk mendapatkan data konten dari server
    $.ajax({
        url: base_url + 'sejarah/get/' + kontenId,
        method: 'GET',
        dataType: 'json',
        success: function(konten) {
            // Tampilkan modal dengan form edit
            Swal.fire({
                customClass: 'swal-wide',
                title: 'Edit Konten',
                html: `
                    <form id="form_edit_data">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" id="title" value="${konten.title}">
                        </div>
                        <div class="form-group">
                            <label for="body">Konten</label>
                            <textarea class="form-control" id="body">${konten.content}</textarea>
                        </div>
                    </form>
                `,
                didOpen: () => {
                    // Hapus instansi TinyMCE sebelumnya
                    if (tinymce.get('body')) {
                        tinymce.get('body').remove();
                    }

                    // Inisialisasi TinyMCE lagi
                    tinymce.init({
                        selector: 'textarea#body',
                        plugins: 'image code link',
                        toolbar: 'undo redo | image | link | code',
                        images_upload_url: base_url + 'sejarah/upload_image',
                        automatic_uploads: true,
                    });
                },
                confirmButtonText: 'Update',
                preConfirm: () => {
                    const title = Swal.getPopup().querySelector('#title').value;
                    const body = tinyMCE.get('body').getContent();  // Ambil konten dari TinyMCE

                    // Validasi input sebelum mengirim data
                    if (!title || !body) {
                        Swal.showValidationMessage('Silakan lengkapi data');
                    }
                    return { id: kontenId, title: title, body: body };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim data dengan AJAX ke server untuk mengupdate konten
                    $.ajax({
                        type: "POST",
                        url: base_url + 'sejarah/update',
                        data: {
                            id: result.value.id,
                            title: result.value.title,
                            body: result.value.body
                        },
                        success: function() {
                            Swal.fire('Sukses', 'Konten berhasil diperbarui.', 'success');
                            $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal memperbarui konten.', 'error');
                        }
                    });
                }
            });
        },
        error: function() {
            Swal.fire('Error', 'Gagal memuat data konten.', 'error');
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
                    url: base_url + '/sejarah/delete/' + kontenId,
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
