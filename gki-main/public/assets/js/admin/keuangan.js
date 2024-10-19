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
      "url": base_url + "keuangan/get_list",
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
          return `${convertToRupiah(row[5])} `;
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

    // Tambah Keuangan
    $('.tambah').on('click', function () {
        Swal.fire({
            customClass: 'swal-wide',
            title: 'Tambah Data Keuangan',
            html: `
                <form id="form_add_data">
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" placeholder="Deskripsi">
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" placeholder="Jumlah">
                    </div>
                    <div class="form-group">
                        <label for="tipe">Tipe</label>
                        <select class="form-control" id="tipe">
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                </form>
            `,
            confirmButtonText: 'Simpan',
            preConfirm: () => {
                const deskripsi = Swal.getPopup().querySelector('#deskripsi').value;
                const jumlah = Swal.getPopup().querySelector('#jumlah').value;
                const tipe = Swal.getPopup().querySelector('#tipe').value;
                const tanggal = Swal.getPopup().querySelector('#tanggal').value;

                if (!deskripsi || !jumlah || !tipe || !tanggal) {
                    Swal.showValidationMessage('Silakan lengkapi semua data');
                }

                return { 
                    deskripsi: deskripsi, 
                    jumlah: jumlah, 
                    tipe: tipe, 
                    tanggal: tanggal
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'keuangan/add',
                    data: result.value,
                    success: function () {
                        Swal.fire('Sukses', 'Data keuangan berhasil ditambahkan.', 'success');
                        $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menambahkan data keuangan.', 'error');
                    }
                });
            }
        });
    });

    // Edit Keuangan
    $(document).on('click', '.edit', function () {
        const id = $(this).attr('id');

        $.ajax({
            url: base_url + 'keuangan/get/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                Swal.fire({
                    customClass: 'swal-wide',
                    title: 'Edit Data Keuangan',
                    html: `
                        <form id="form_edit_data">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <input type="text" class="form-control" id="deskripsi" value="${data.deskripsi}">
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" value="${data.jumlah}">
                            </div>
                            <div class="form-group">
                                <label for="tipe">Tipe</label>
                                <select class="form-control" id="tipe">
                                    <option value="Pemasukan" ${data.tipe === 'Pemasukan' ? 'selected' : ''}>Pemasukan</option>
                                    <option value="Pengeluaran" ${data.tipe === 'Pengeluaran' ? 'selected' : ''}>Pengeluaran</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" value="${data.tanggal}">
                            </div>
                        </form>
                    `,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        const deskripsi = Swal.getPopup().querySelector('#deskripsi').value;
                        const jumlah = Swal.getPopup().querySelector('#jumlah').value;
                        const tipe = Swal.getPopup().querySelector('#tipe').value;
                        const tanggal = Swal.getPopup().querySelector('#tanggal').value;

                        if (!deskripsi || !jumlah || !tipe || !tanggal) {
                            Swal.showValidationMessage('Silakan lengkapi semua data');
                        }

                        return { 
                            id: id,
                            deskripsi: deskripsi, 
                            jumlah: jumlah, 
                            tipe: tipe, 
                            tanggal: tanggal
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: base_url + 'keuangan/update',
                            data: result.value,
                            success: function () {
                                Swal.fire('Sukses', 'Data keuangan berhasil diperbarui.', 'success');
                                $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal memperbarui data keuangan.', 'error');
                            }
                        });
                    }
                });
            },
            error: function () {
                Swal.fire('Error', 'Gagal memuat data keuangan.', 'error');
            }
        });
    });

    // Hapus Keuangan
    $(document).on('click', '.delete', function () {
        const id = $(this).attr('id');

        Swal.fire({
            customClass: 'swal-wide',
            title: 'Apakah Anda yakin?',
            text: "Data keuangan ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'keuangan/delete/' + id,
                    success: function () {
                        Swal.fire('Sukses', 'Data keuangan berhasil dihapus.', 'success');
                        $('#tabel_serverside').DataTable().ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menghapus data keuangan.', 'error');
                    }
                });
            }
        });
    });
});
function convertToRupiah(number) {
    // Pastikan input berupa angka
    let num = parseInt(number, 10);
    
    // Format angka dengan pemisah ribuan
    let rupiah = num.toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });

    // Hapus "IDR" di depan dan kembalikan hasil dalam format yang diinginkan
    return rupiah.replace("IDR", "Rp").trim();
}
