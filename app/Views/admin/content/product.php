<link rel="stylesheet" type="text/css" href="<?= base_url('assets') ?>/datatables/datatables.min.css" />







<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Product List</h6>
                        <button class= "btn btn-primary tambahProduct">Tambah</button>
                    </div>
                    <div class="table-responsive">
                    <table id="tabel_serverside" class="table table-bordered display text-left" cellspacing="0" width="100%">
              <thead>
                <tr  class="text-center">
                  <th style=" text-align: center;">#</th>
                  <th style=" text-align: center;">Kode</th>
                  <th style=" text-align: center;">Nama</th>
                  <th style=" text-align: center;">Kelompok</th>
                  <th style=" text-align: center;">Material</th>
                  <th style=" text-align: center;">Stock</th>
                  <th style=" text-align: center;">Aktif</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="text-center">
                <th style=" text-align: center;">#</th>
                  <th style=" text-align: center;">Kode</th>
                  <th style=" text-align: center;">Nama</th>
                  <th style=" text-align: center;">Kelompok</th>
                  <th style=" text-align: center;">Material</th>
                  <th style=" text-align: center;">Stock</th>
                  <th style=" text-align: center;">Aktif</th>
                </tr>
              </tr>
            </tfoot>
          </table>
                    </div>
                </div>
            </div>
<!-- Recent Sales End -->


<!-- Widgets Start -->

<!-- Widgets End -->

<script type="text/javascript" src="<?= base_url('assets') ?>/js/product.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/datatables/datatables.min.js"></script>