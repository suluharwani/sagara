var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port ? ":" + loc.port : "") + "/";

$(document).ready(function () {
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
      "url": base_url + "pengisi_acara/get_list",
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
          return `${row[4]} `;
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


    // Tambah Pengisi Acara
    $('.tambah').on('click', function () {
        Swal.fire({
            customClass: 'swal-wide',
            title: 'Tambah Pengisi Acara',
            html: `
                <form id="form_add_data">
                    <div class="form-group">
                        <label for="nama_pengisi">Nama Pengisi</label>
                        <input type="text" class="form-control" id="nama_pengisi" placeholder="Nama Pengisi">
                    </div>
                    <div class="form-group">
                        <label for="acara">Acara</label>
                        <input type="text" class="form-control" id="acara" placeholder="Acara">
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal dan Waktu</label>
                        <input type="datetime-local" class="form-control" id="tanggal">
                    </div>
                </form>
            `,
            confirmButtonText: 'Simpan',
            preConfirm: () => {
                const nama_pengisi = Swal.getPopup().querySelector('#nama_pengisi').value;
                const acara = Swal.getPopup().querySelector('#acara').value;
                const tanggal = Swal.getPopup().querySelector('#tanggal').value;  // Tanggal dan waktu

                if (!nama_pengisi || !acara || !tanggal) {
                    Swal.showValidationMessage('Silakan lengkapi semua data');
                }

                return { 
                    nama_pengisi: nama_pengisi, 
                    acara: acara, 
                    tanggal: tanggal
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'pengisi_acara/add',
                    data: result.value,
                    success: function () {
                        Swal.fire('Sukses', 'Pengisi acara berhasil ditambahkan.', 'success');
                        $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menambahkan pengisi acara.', 'error');
                    }
                });
            }
        });
    });

    // Edit Pengisi Acara
    $(document).on('click', '.edit', function () {
        const id = $(this).attr('id');

        $.ajax({
            url: base_url + 'pengisi_acara/get/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                Swal.fire({
                    customClass: 'swal-wide',
                    title: 'Edit Pengisi Acara',
                    html: `
                        <form id="form_edit_data">
                            <div class="form-group">
                                <label for="nama_pengisi">Nama Pengisi</label>
                                <input type="text" class="form-control" id="nama_pengisi" value="${data.nama_pengisi}">
                            </div>
                            <div class="form-group">
                                <label for="acara">Acara</label>
                                <input type="text" class="form-control" id="acara" value="${data.acara}">
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal dan Waktu</label>
                                <input type="datetime-local" class="form-control" id="tanggal" value="${data.tanggal}">
                            </div>
                        </form>
                    `,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        const nama_pengisi = Swal.getPopup().querySelector('#nama_pengisi').value;
                        const acara = Swal.getPopup().querySelector('#acara').value;
                        const tanggal = Swal.getPopup().querySelector('#tanggal').value;

                        if (!nama_pengisi || !acara || !tanggal) {
                            Swal.showValidationMessage('Silakan lengkapi semua data');
                        }

                        return { 
                            id: id,
                            nama_pengisi: nama_pengisi, 
                            acara: acara, 
                            tanggal: tanggal
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: base_url + 'pengisi_acara/update',
                            data: result.value,
                            success: function () {
                                Swal.fire('Sukses', 'Pengisi acara berhasil diperbarui.', 'success');
                                $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal memperbarui pengisi acara.', 'error');
                            }
                        });
                    }
                });
            },
            error: function () {
                Swal.fire('Error', 'Gagal memuat data pengisi acara.', 'error');
            }
        });
    });

    // Hapus Pengisi Acara
    $(document).on('click', '.delete', function () {
        const id = $(this).attr('id');

        Swal.fire({
            customClass: 'swal-wide',
            title: 'Apakah Anda yakin?',
            text: "Pengisi acara ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'pengisi_acara/delete/' + id,
                    success: function () {
                        Swal.fire('Sukses', 'Pengisi acara berhasil dihapus.', 'success');
                        $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menghapus pengisi acara.', 'error');
                    }
                });
            }
        });
    });
});
