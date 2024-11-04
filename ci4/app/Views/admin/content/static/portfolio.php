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
                <button type="button" class="btn btn-primary tambah_data" onclick="getSelect()">Tambah Data</button>
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
                <label for="nama_contact" class="form-label">Client</label>
                <select class="form-control  select_client" name="id_client" style="width:auto;" aria-label="Default select example" id="id_client">
                </select>


            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Product</label>
                <select class="form-control  select_produk" name="id_product" style="width:auto;" aria-label="Default select example" id="id_product"></select>

            </div>
            <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="text" name="link" class="form-control" id="link" >
        </div>
        <div class="mb-3">
            <label for="delivered_at" class="form-label">Tanggal</label>
            <input type="date" name="delivered_at" class="form-control" id="delivered_at" >
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
                <input type="text" name="id_client" class="form-control editVal"  hidden>
                <input type="text" name="id_product" class="form-control editVal" hidden>
            </div>
            <div class="mb-3">
                <label for="nama_contact" class="form-label">Client</label>
                <select class="form-control  select_client editVal" name="id_client" style="width:auto;" aria-label="Default select example" id="id_client">
                </select>


            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Product</label>
                <select class="form-control  select_produk editVal" name="id_product" style="width:auto;" aria-label="Default select example" id="id_product"></select>

            </div>
               <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="text" name="link" class="form-control link editVal" id="link" >
        </div>
        <div class="mb-3">
            <label for="delivered_at" class="form-label">Tanggal</label>
            <input type="date" name="delivered_at" class="form-control delivered_at editVal" id="delivered_at" >
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
<script type="text/javascript">
    function getSelect(){
        selectClient()
        selectProduct()
    }

    $('#modalEdit').on('shown.bs.modal', function (e) {
// console.log(read)
        $('.select_client').removeAttr('selected','selected');
        $('.select_produk').removeAttr('selected','selected');
          
        id_client= $(`input[name='id_client'].editVal`).val()
        id_product = $(`input[name='id_product'].editVal`).val()
        selectClient(id_client)
        selectProduct(id_product)



    })
    function selectClient(id_client=null){
      $.ajax({
        type : "POST",
        url  : base_url+"admin/static/select_client",
        async : true,
        dataType : 'json',
        success: function(data){
          let selOpts = '';
          $.each(data, function(k, v)
          {
            var id = data[k].id;
            var email = data[k].email;
            var val = `${data[k].nama_depan} ${data[k].nama_belakang}`;
            selOpts += "<option value='"+id+"'>"+val+" - "+email+"</option>";

        });
          $('.select_client').html(selOpts);
          if (id_client!=null) {
              $('.select_client option[value='+id_client+']').attr('selected','selected');
          }
      }
  });
  }
  function selectProduct(id_product=null){
      $.ajax({
        type : "POST",
        url  : base_url+"admin/static/select_produk",
        async : true,
        dataType : 'json',
        success: function(data){
          let selOpts = '';
          $.each(data, function(k, v)
          {
            var id = data[k].id;
            var val = `${data[k].nama}`;
            selOpts += "<option value='"+id+"'>"+val+"</option>";

        });
          $('.select_produk').html(selOpts);
          if (id_product!=null) {
              $('.select_produk option[value='+id_product+']').attr('selected','selected');
              console.log(id_product)
          }
      }
  });
  }
</script>