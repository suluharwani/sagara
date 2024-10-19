
var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

$(document).ready(function () {
    // Inisialisasi DataTables
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
      "url": base_url + "user/get_list",
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




    // Tambah User
    $('.tambah').on('click', function () {
        Swal.fire({
            customClass: 'swal-wide',
            title: 'Tambah User',
            html: `
                <form id="form_add_user">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Password">
                    </div>
                </form>
            `,
            confirmButtonText: 'Simpan',
            preConfirm: () => {
                const username = Swal.getPopup().querySelector('#username').value;
                const email = Swal.getPopup().querySelector('#email').value;
                const password = Swal.getPopup().querySelector('#password').value;

                if (!username || !email || !password) {
                    Swal.showValidationMessage('Silakan lengkapi semua data');
                }
                return { username: username, email: email, password: password };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'user/add',
                    data: result.value,
                    success: function () {
                        Swal.fire('Sukses', 'User berhasil ditambahkan.', 'success');
                        dataTable.ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menambahkan user.', 'error');
                    }
                });
            }
        });
    });

    // Edit User
    $(document).on('click', '.edit', function () {
        const id = $(this).attr('id');

        $.ajax({
            url: base_url + 'user/get/' + id,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                Swal.fire({
                    customClass: 'swal-wide',
                    title: 'Edit User',
                    html: `
                        <form id="form_edit_user">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" value="${data.username}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="${data.email}">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Kosongkan jika tidak ingin mengganti password">
                            </div>
                        </form>
                    `,
                    confirmButtonText: 'Update',
                    preConfirm: () => {
                        const username = Swal.getPopup().querySelector('#username').value;
                        const email = Swal.getPopup().querySelector('#email').value;
                        const password = Swal.getPopup().querySelector('#password').value;

                        return { id: id, username: username, email: email, password: password };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: base_url + 'user/update',
                            data: result.value,
                            success: function () {
                                Swal.fire('Sukses', 'User berhasil diperbarui.', 'success');
                                dataTable.ajax.reload();  // Reload DataTables
                            },
                            error: function () {
                                Swal.fire('Error', 'Gagal memperbarui user.', 'error');
                            }
                        });
                    }
                });
            },
            error: function () {
                Swal.fire('Error', 'Gagal memuat data user.', 'error');
            }
        });
    });

    // Delete User
    $(document).on('click', '.delete', function () {
        const id = $(this).attr('id');

        Swal.fire({
            customClass: 'swal-wide',
            title: 'Apakah Anda yakin?',
            text: "User ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: base_url + 'user/delete/' + id,
                    success: function () {
                        Swal.fire('Sukses', 'User berhasil dihapus.', 'success');
                        dataTable.ajax.reload();  // Reload DataTables
                    },
                    error: function () {
                        Swal.fire('Error', 'Gagal menghapus user.', 'error');
                    }
                });
            }
        });
    });
});
