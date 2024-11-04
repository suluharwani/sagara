<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/datatables/datatables.min.css"/>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class = "nama_halaman"></h3>
                <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required)</p> -->
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb" id="breadcrumb">
                       <!--  <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
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
                <button type="button" class="btn btn-primary tambah_data">Tambah Data</button>
                <button type="button" class="btn btn-primary restore_data">Recycle Bin</button>
                
            </div>
            <div class="card-body">
              <!-- table -->
              <div class="table-responsive">
                <table  class="table table-bordered display text-left table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr  class="text-center">
                      <th style="width: 5%; text-align: center;">NO</th>
                      <th style="width: 20%; text-align: center;">HALAMAN</th>
                      <th style="width: 20%; text-align: center;">IMAGE</th>
                      <th style="width: 20%; text-align: center;">STATUS</th>
                      <th style="width: 35%; text-align: center;">ACTION</th>
                  </tr>
              </thead>
              <tbody id="tabel"></tbody>
              <tfoot>
                <tr class="text-center">
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 20%; text-align: center;">HALAMAN</th>
                  <th style="width: 20%; text-align: center;">IMAGE</th>
                  <th style="width: 20%; text-align: center;">STATUS</th>
                  <th style="width: 35%; text-align: center;">ACTION</th>
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
<!-- modal -->
<div class="modal fade modalTambahData" id="modalTambahData" data-bs-focus="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Halaman: <span class = "nama_halaman"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="form"  class="form" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" >
            </div>
            <div class="mb-3">
            <label for="nama_brand" class="form-label">Nama Brand</label>
            <input type="text" name="nama_brand" class="form-control" id="nama_brand" >
        </div>
            <div class="mb-3">
                <label for="join_at" class="form-label">Tanggal Bergabung</label>
                <input type="date" name="join_at" class="form-control" id="join_at" >
            </div>
            <div class="mb-3">
                <div class="d-grid text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <img class="mb-3" id="ajaxImgUpload" alt="Preview Image" src="https://via.placeholder.com/300" />
                            </div>
                            <div class="col">
                                <span id = "alertMsg"></span>
                                <input type="text" name="picture" id="picture" hidden>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <input type="file" name="file" multiple="true" id="file" 
                    class="form-control form-control-lg"  accept="image/*">
                </div>
                <div class="d-grid">
                   <button type="button" class="btn btn-danger uploadBtn">Upload</button>
               </div>
           </div>
           
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="text" name="link" class="form-control" id="link" >
        </div>
    </form>

</div>
<div class="modal-footer">

    <button type="button" class="btn btn-danger reset" >Reset</button>
    <button type="button" class="btn btn-primary save" >Simpan</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<!-- modal -->
<div class="modal fade modalDeletedData" id="modalDeletedData" data-bs-focus="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Halaman: <span class = "nama_halaman"></span> terhapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
     <!-- table -->
     <div class="table-responsive">
        <table  class="table table-bordered display text-left table-striped" cellspacing="0" width="100%">
          <thead>
            <tr  class="text-center">
              <th style="width: 5%; text-align: center;">NO</th>
              <th style="width: 20%; text-align: center;">HALAMAN</th>
              <th style="width: 20%; text-align: center;">IMAGE</th>
              <th style="width: 20%; text-align: center;">STATUS</th>
              <th style="width: 20%; text-align: center;">ACTION</th>
          </tr>
      </thead>
      <tbody id="tabelDeletedData"></tbody>
      <tfoot>
        <tr class="text-center">
          <th style="width: 5%; text-align: center;">NO</th>
          <th style="width: 20%; text-align: center;">HALAMAN</th>
          <th style="width: 20%; text-align: center;">IMAGE</th>
          <th style="width: 20%; text-align: center;">STATUS</th>
          <th style="width: 20%; text-align: center;">ACTION</th>
      </tr>
  </tr>
</tfoot>
</table>
</div>
<!-- table -->

</div>
<div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<!-- modal -->
<div class="modal fade modalEdit" id="modalEdit" data-bs-focus="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data: <span class = "nama_halaman"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="formUpdateText"  class="formUpdateText" >
            <input type="text" name="id" class="editVal" id="id" hidden>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control editVal" id="nama" >
            </div>
            <div class="mb-3">
            <label for="nama_brand" class="form-label">Nama Brand</label>
            <input type="text" name="nama_brand" class="form-control editVal" id="nama_brand" >
        </div>
            <div class="mb-3">
                <label for="join_at" class="form-label">Tanggal Bergabung</label>
                <input type="date" name="join_at" class="form-control editVal" id="join_at" >
            </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="text" name="link" class="form-control editVal" id="link" >
        </div>
    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary saveUpdateText" >Simpan</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<!-- modal -->
<div class="modal fade modalEditPicture" id="modalEditPicture" data-bs-focus="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data: <span class = "nama_halaman"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="formUpdatePicture"  class="" >
            <input type="number" name="id" id="idUpdate" hidden>
                        <div class="mb-3">
                <div class="d-grid text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <img class="mb-3" id="image_before" alt="Preview Image"/>
                            </div>
                            <div class="col">
                               <i class="bi bi-arrow-right" style="font-size: 10rem; color: cornflowerblue;"></i>
                            </div>
                            <div class="col">
                                <img class="mb-3" id="image_after" alt="Preview Image"/>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <input type="file" name="fileUpdate" multiple="true" id="fileUpdate" 
                    class="form-control form-control-lg"  accept="image/*">
                </div>
                <div class="d-grid">
                   <!-- <button type="button" class="btn btn-danger uploadBtn">Upload</button> -->
               </div>
           </div>
    </form>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary saveUpdatePicture" >Simpan</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="<?=base_url()?>/assets/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/js/static_crud.js"></script>
