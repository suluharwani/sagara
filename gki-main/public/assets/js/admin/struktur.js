
var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

$(document).ready(function() {

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
      "url": base_url + "struktur/get_list",
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
          return `${row[3]} `;
        }
      },
      {
        mRender: function(data, type, row) {
          return `<img src="${base_url}assets/img/struktur_organisasi/${row[4]}" class="img-thumbnail" width="50"> `;
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

$('.tambah').on('click', function() {
    Swal.fire({
        customClass: 'swal-wide',
        title: 'Tambah Struktur Organisasi',
        html: `
            <form id="form_add_data" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="Nama">
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" class="form-control" id="jabatan" placeholder="Jabatan">
                </div>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" id="foto">
                </div>
            </form>
        `,
        confirmButtonText: 'Simpan',
        preConfirm: () => {
            const nama = Swal.getPopup().querySelector('#nama').value;
            const jabatan = Swal.getPopup().querySelector('#jabatan').value;
            const foto = Swal.getPopup().querySelector('#foto').files[0];  // Ambil file foto

            if (!nama || !jabatan || !foto) {
                Swal.showValidationMessage('Silakan lengkapi data');
            }

            let formData = new FormData();
            formData.append('nama', nama);
            formData.append('jabatan', jabatan);
            formData.append('foto', foto);

            return formData;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: base_url + 'struktur/add',
                data: result.value,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire('Sukses', 'Struktur organisasi berhasil ditambahkan.', 'success');
                    $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                },
                error: function() {
                    Swal.fire('Error', 'Gagal menambahkan struktur organisasi.', 'error');
                }
            });
        }
    });
});

 $('.tambah').on('click', function () {
        Swal.fire({
            customClass: 'swal-wide',
            title: 'Tambah Struktur Organisasi',
            html: `
                <form id="form_add_data" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" placeholder="Jabatan">
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" class="form-control" id="foto">
                    </div>
                </form>
            `,
            confirmButtonText: 'Simpan',
            preConfirm: () => {
                const nama = Swal.getPopup().querySelector('#nama').value;
                const jabatan = Swal.getPopup().querySelector('#jabatan').value;
                const foto = Swal.getPopup().querySelector('#foto').files[0];

                if (!nama || !jabatan || !foto) {
                    Swal.showValidationMessage('Silakan lengkapi data');
                }

                let formData = new FormData();
                formData.append('nama', nama);
                formData.append('jabatan', jabatan);
                formData.append('foto', foto);

                return formData;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'struktur/add',
                    data: result.value,
                    processData: false,
                    contentType: false,
                    success: function () {
                        Swal.fire('Sukses', 'Struktur organisasi berhasil ditambahkan.', 'success');
                        $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menambahkan struktur organisasi.', 'error');
                    }
                });
            }
        });
    }); 

    // Edit Struktur Organisasi
    $(document).on('click', '.edit', function () {
        const id = $(this).attr('id');

        $.ajax({
            url: base_url + 'struktur/get/' + id,
            method: 'POST',
            dataType: 'json',
            success: function (data) {
                Swal.fire({
                    customClass: 'swal-wide',
                    title: 'Edit Struktur Organisasi',
                    html: `
                        <form id="form_edit_data" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" value="${data.nama}">
                            </div>
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" value="${data.jabatan}">
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto (Kosongkan jika tidak ingin mengganti)</label>
                                <input type="file" class="form-control" id="foto">
                            </div>
                        </form>
                    `,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        const nama = Swal.getPopup().querySelector('#nama').value;
                        const jabatan = Swal.getPopup().querySelector('#jabatan').value;
                        const foto = Swal.getPopup().querySelector('#foto').files[0];

                        if (!nama || !jabatan) {
                            Swal.showValidationMessage('Silakan lengkapi data');
                        }

                        let formData = new FormData();
                        formData.append('id', id);
                        formData.append('nama', nama);
                        formData.append('jabatan', jabatan);
                        if (foto) {
                            formData.append('foto', foto);
                        }

                        return formData;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: base_url + `struktur/update/${id}`,
                            data: result.value,
                            processData: false,
                            contentType: false,
                            success: function () {
                                Swal.fire('Sukses', 'Struktur organisasi berhasil diperbarui.', 'success');
                                $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal memperbarui struktur organisasi.', 'error');
                            }
                        });
                    }
                });
            },
            error: function () {
                Swal.fire('Error', 'Gagal memuat data struktur organisasi.', 'error');
            }
        });
    });

    // Hapus Struktur Organisasi
    $(document).on('click', '.delete', function () {
        const id = $(this).attr('id');

        Swal.fire({
            customClass: 'swal-wide',
            title: 'Apakah Anda yakin?',
            text: "Struktur organisasi ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'struktur/delete/' + id,
                    success: function () {
                        Swal.fire('Sukses', 'Struktur organisasi berhasil dihapus.', 'success');
                        $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menghapus struktur organisasi.', 'error');
                    }
                });
            }
        });
    });
