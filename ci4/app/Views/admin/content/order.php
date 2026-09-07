<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/datatables/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/summernote/summernote-image-list.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/summernote/summernote-lite.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Order Aktif</h3>
                <p class="text-subtitle text-muted">Kelola pesanan yang sedang berjalan</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb" id="breadcrumb" >
                        <!-- <div id = "breadCrumb"></div> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
              <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                  <h5 class="mb-1">Daftar Order Aktif</h5>
                  <small class="text-muted">Gunakan menu aksi untuk mengelola setiap pesanan.</small>
                </div>
                <button type="button" class="btn btn-primary tambahOrder"><i class="fas fa-plus me-1"></i> Tambah Order</button>
            </div>
            <div class="card-body">
                          <!-- table -->
          <div class="table-responsive">
            <table id="tabel_serverside" class="table table-hover align-middle display text-left" cellspacing="0" width="100%">
              <thead>
                <tr  class="text-center">
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 5%; text-align: center;">TEAM</th>
                  <th style="width: 5%; text-align: center;">KODE</th>
                  <th style="width: 5%; text-align: center;">CUSTOMER</th>
                  <th style="width: 5%; text-align: center;">DEADLINE</th>
                  <th style="width: 5%; text-align: center;">QTY</th>
                  <th style="width: 5%; text-align: center;">STATUS</th>
                  <th style="width: 14%; text-align: center;">AKSI</th>
                </tr>
              </thead>
          </table>
        </div>
        <!-- table -->
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->
</div>
 <div class="modal fade orderDetailModal" id="" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Detail Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="orderDetailContent">
                        <!-- Detail order akan dimuat di sini oleh JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
  
        <!-- modal -->

         <div class="modal modal_restore" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Halaman dihapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table" id = "tabelRestore">
  
</table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- modal -->
<script type="text/javascript" src="<?=base_url('assets')?>/datatables/datatables.min.js"></script>
<script>window.APP_BASE_URL = <?= json_encode(rtrim(base_url(), '/') . '/') ?>;</script>
<script type="text/javascript" src="<?=base_url()?>/assets/js/order.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/summernote/summernote-lite.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/summernote/summernote-image-list.min.js"></script>

