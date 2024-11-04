<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/datatables/datatables.min.css"/>



<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pages</h3>
                <p class="text-subtitle text-muted">Manage Halaman</p>
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

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                          <!-- table -->
          <div class="table-responsive">
            <table  class="table table-bordered display text-left table-striped" cellspacing="0" width="100%">
              <thead>
                <tr  class="text-center">
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 20%; text-align: center;">HALAMAN</th>
                  <th style="width: 20%; text-align: center;">STATUS</th>
                  <th style="width: 20%; text-align: center;">ACTION</th>
                </tr>
              </thead>
              <tbody id="tabel"></tbody>
              <tfoot>
                <tr class="text-center">
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 20%; text-align: center;">HALAMAN</th>
                  <th style="width: 20%; text-align: center;">STATUS</th>
                  <th style="width: 20%; text-align: center;">ACTION</th>
                </tr>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- table -->
            </div>
        </div>

    </section>
    <!-- Basic Tables end -->
</div>

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
    <div class="modal fade modalCat" id="modalCat" data-bs-focus="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Halaman: <span id = "nama_kategori"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div>
                <a class="btn btn-success btn-sm tambahKategori"  >Tambah Kategori</a>
                
            </div>
                          <div class="table-responsive">
            <table id="tabelKategori" class="table table-bordered display text-center" cellspacing="0" width="100%">
              
              <thead>
                <tr  class="text-center">
  
                    <th  style="width: auto;">No</th>
                    <th  style="width: auto;">Kategori</th>
                    <th  style="width: auto;">Action</th>
                    <th  style="width: auto;">Sub Kategori</th>
                    <th  style="width: auto;">Action</th>

                    <!-- <th  style="width: 10%;">Action</th> -->

                </tr>
                <br>
              </thead>
                  <tbody id = isiCat>

                  </tbody>

              <tfoot>
               <tr>
                    <!-- <th  style="width: auto;">No</th> -->
                    <th  style="width: auto;">No</th>
                    <th  style="width: auto;">Kategori</th>
                    <th  style="width: auto;">Action</th>
                    <th  style="width: auto;">Sub Kategori</th>
                    <th  style="width: auto;">Action</th>

                    <!-- <th  style="width: 10%;">Action</th> -->
                  </tr>
              </tfoot>
            </table>

          </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
<script type="text/javascript" src="<?=base_url('assets')?>/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/js/static_pages.js"></script>
 