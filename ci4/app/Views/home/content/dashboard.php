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
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Nama Tim</th>
                        <th>Brand</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated here by DataTables -->
                </tbody>
            </table>
        </div>
    </section>
</div>

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
            { "data": "id", "title": "ID" },
            { "data": "kode", "title": "Kode" },
            { "data": "deadline", "title": "Deadline" },
            {"data": "link",
                "title": "link",
                "render": function(data, type, row) {
                    return '<a href="'+data+'">' + data + '</a>';
                }},
            { "data": "nama_tim", "title": "Nama Tim" },
            { "data": "brand", "title": "Brand" }
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
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
</script>
