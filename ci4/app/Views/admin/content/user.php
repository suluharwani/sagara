<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/datatables/datatables.min.css"/>



<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Tabel User</h3>
                <p class="text-subtitle text-muted">Manage account client website</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb" id="breadcrumb">
<!--                         <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">DataTable Jquery</li> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary tambah_user">Tambah user</button>
            </div>
            <div class="card-body">
                          <!-- table -->
          <div class="table-responsive">
            <table id="tabel_serverside" class="table table-bordered display text-center" cellspacing="0" width="100%">
              <thead>
                <tr  class="text-center">
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 20%;">NAMA/EMAIL</th>
                  <th style="width: 5%; ">FOTO</th>
                  <th style="width: 15%;">LEVEL USER</th>
                  <th style="width: 15%;">STATUS</th>
                  <th style="width: 40%; text-align: center;">ACTION</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="text-center">
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 20%;">NAMA/EMAIL</th>
                  <th  style="width: 5%;">FOTO</th>
                  <th style="width: 15%;">LEVEL USER</th>
                  <th style="width: 15%;">STATUS</th>
                  <th style="width: 40%; text-align: center;">ACTION</th>
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

 
<script type="text/javascript" src="<?=base_url('assets')?>/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/js/client.js"></script>
 