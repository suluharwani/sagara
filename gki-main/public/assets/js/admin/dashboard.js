
var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";
hitungKeuanganDariServer()
function hitungKeuanganDariServer() {
    $.ajax({
        url: base_url + 'keuangan/getAll',  // URL endpoint untuk mengambil data
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            // Cek apakah response berupa array
            if (Array.isArray(response)) {
                let totalPemasukan = 0;
                let totalPengeluaran = 0;

                // Menggunakan $.each untuk iterasi melalui data
                $.each(response, function (index, item) {
                    if (item.tipe === 'pemasukan') {  // Pastikan tipe sesuai
                        totalPemasukan += parseFloat(item.jumlah);
                    } else if (item.tipe === 'pengeluaran') {
                        totalPengeluaran += parseFloat(item.jumlah);
                    }
                });

                let selisih = totalPemasukan - totalPengeluaran;

                // Tampilkan hasil dalam format rupiah
                $('#totalPemasukan').text(convertToRupiah(totalPemasukan));
                $('#totalPengeluaran').text(convertToRupiah(totalPengeluaran));
                $('#selisih').text(convertToRupiah(selisih));
            } else {
                console.error('Data keuangan tidak valid.');
                Swal.fire('Error', 'Data keuangan tidak ditemukan.', 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Gagal mengambil data keuangan.', 'error');
        }
    });
}

// Fungsi untuk mengonversi angka menjadi format Rupiah
function convertToRupiah(number) {
    return "Rp " + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}


// Fungsi untuk mengonversi angka menjadi format Rupiah
function convertToRupiah(number) {
    return "Rp " + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
