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
                return `
                        <a href="javascript:void(0);" class="btn btn-success btn-sm viewOrderDetail" data-id="${row[1]}" >List Detail</a>
                        <a href="javascript:void(0);" class="btn btn-warning btn-sm Link" id="${row[1]}" link = "${row[7]}">Link</a>
                        <a href="${base_url}exportExcel/${row[2]}" class="btn btn-success btn-sm">Download Excel</a>`
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
  $(document).on('click', '.viewOrderDetail', function () {
    const orderId = $(this).data('id'); // Mengambil ID order dari tombol
    
    // Membuat URL tujuan
    const url = base_url+'/admin/order/detail/' + orderId;
    
    // Redirect ke URL di tab baru
    window.open(url, '_blank');
});
