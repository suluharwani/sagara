var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port ? ":" + loc.port : "") + "/";

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
      "url": base_url + "jadwal/get_list",
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
          return `${row[5]} `;
        }
      },
      {
        mRender: function(data, type, row) {
          return `${row[6]} `;
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

    // Tambah Jadwal
    $('.tambah').on('click', function () {
        Swal.fire({
            customClass: 'swal-wide',
            title: 'Tambah Jadwal',
            html: `
                <form id="form_add_data">
                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="nama_kegiatan" placeholder="Nama Kegiatan">
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                    <div class="form-group">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="time" class="form-control" id="waktu_mulai">
                    </div>
                    <div class="form-group">
                        <label for="waktu_selesai">Waktu Selesai</label>
                        <input type="time" class="form-control" id="waktu_selesai">
                    </div>
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" placeholder="Lokasi">
                    </div>
                </form>
            `,
            confirmButtonText: 'Simpan',
            preConfirm: () => {
                const nama_kegiatan = Swal.getPopup().querySelector('#nama_kegiatan').value;
                const tanggal = Swal.getPopup().querySelector('#tanggal').value;
                const waktu_mulai = Swal.getPopup().querySelector('#waktu_mulai').value;
                const waktu_selesai = Swal.getPopup().querySelector('#waktu_selesai').value;
                const lokasi = Swal.getPopup().querySelector('#lokasi').value;

                if (!nama_kegiatan || !tanggal || !waktu_mulai || !waktu_selesai || !lokasi) {
                    Swal.showValidationMessage('Silakan lengkapi semua data');
                }

                return { 
                    nama_kegiatan: nama_kegiatan, 
                    tanggal: tanggal, 
                    waktu_mulai: waktu_mulai, 
                    waktu_selesai: waktu_selesai, 
                    lokasi: lokasi 
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'jadwal/add',
                    data: result.value,
                    success: function () {
                        Swal.fire('Sukses', 'Jadwal berhasil ditambahkan.', 'success');
                        $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menambahkan jadwal.', 'error');
                    }
                });
            }
        });
    });

    // Edit Jadwal
    $(document).on('click', '.edit', function () {
        const id = $(this).attr('id');

        $.ajax({
            url: base_url + 'jadwal/get/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                Swal.fire({
                    customClass: 'swal-wide',
                    title: 'Edit Jadwal',
                    html: `
                        <form id="form_edit_data">
                            <div class="form-group">
                                <label for="nama_kegiatan">Nama Kegiatan</label>
                                <input type="text" class="form-control" id="nama_kegiatan" value="${data.nama_kegiatan}">
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" value="${data.tanggal}">
                            </div>
                            <div class="form-group">
                                <label for="waktu_mulai">Waktu Mulai</label>
                                <input type="time" class="form-control" id="waktu_mulai" value="${data.waktu_mulai}">
                            </div>
                            <div class="form-group">
                                <label for="waktu_selesai">Waktu Selesai</label>
                                <input type="time" class="form-control" id="waktu_selesai" value="${data.waktu_selesai}">
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" value="${data.lokasi}">
                            </div>
                        </form>
                    `,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        const nama_kegiatan = Swal.getPopup().querySelector('#nama_kegiatan').value;
                        const tanggal = Swal.getPopup().querySelector('#tanggal').value;
                        const waktu_mulai = Swal.getPopup().querySelector('#waktu_mulai').value;
                        const waktu_selesai = Swal.getPopup().querySelector('#waktu_selesai').value;
                        const lokasi = Swal.getPopup().querySelector('#lokasi').value;

                        if (!nama_kegiatan || !tanggal || !waktu_mulai || !waktu_selesai || !lokasi) {
                            Swal.showValidationMessage('Silakan lengkapi semua data');
                        }

                        return { 
                            id: id,
                            nama_kegiatan: nama_kegiatan, 
                            tanggal: tanggal, 
                            waktu_mulai: waktu_mulai, 
                            waktu_selesai: waktu_selesai, 
                            lokasi: lokasi 
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: base_url + 'jadwal/update',
                            data: result.value,
                            success: function () {
                                Swal.fire('Sukses', 'Jadwal berhasil diperbarui.', 'success');
                                $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal memperbarui jadwal.', 'error');
                            }
                        });
                    }
                });
            },
            error: function () {
                Swal.fire('Error', 'Gagal memuat data jadwal.', 'error');
            }
        });
    });

    // Hapus Jadwal
    $(document).on('click', '.delete', function () {
        const id = $(this).attr('id');

        Swal.fire({
            customClass: 'swal-wide',
            title: 'Apakah Anda yakin?',
            text: "Jadwal ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'jadwal/delete/' + id,
                    success: function () {
                        Swal.fire('Sukses', 'Jadwal berhasil dihapus.', 'success');
                        $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menghapus jadwal.', 'error');
                    }
                });
            }
        });
    });

