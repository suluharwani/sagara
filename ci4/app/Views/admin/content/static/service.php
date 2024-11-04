<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/datatables/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/summernote/summernote-image-list.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/summernote/summernote-lite.min.css"/>

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
                <input type="text" name="nama" inputVal="nama" class="form-control" id="nama" >
            </div>
             <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control" id="judul" >
                <input type="text" name="slug" class="form-control" id="slug" hidden >
                <input type="text" name="id_admin" class="form-control" id="id_admin" hidden >
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">Konten</label>
            <textarea class="summernote" name="text" inputVal = "text" id="text" cols="30" rows="10"></textarea>
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
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" class="form-control judul editVal" id="judul" >
                <input type="text" name="slug" class="form-control slug editVal" id="slug"  hidden>
                <input type="text" name="id_admin" class="form-control id_admin editVal" id="id_admin" hidden >

            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Content</label>
                

                <textarea class="summernote editVal" name="text" inputVal = "text" id="text" cols="30" rows="10"></textarea>
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
<script type="text/javascript" src="<?=base_url()?>/assets/summernote/summernote-lite.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/summernote/summernote-image-list.min.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
    $('.summernote').summernote({
        callbacks: {
            onImageUpload: function(files) {
                for (let i = 0; i < files.length; i++) {
                    $.upload(files[i]);
                }
            },
            onMediaDelete: function(target) {
                $.delete(target[0].src);
            }
        },
        height: 400,
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["fontname", ["fontname"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ['table', ['table']],
            ["height", ["height"]],
            ["insert", ["link", "picture", "imageList", "video", "hr"]],
            ['view', ['fullscreen', 'codeview', 'help']],

            ],
        dialogsInBody: true,
        imageList: {
            endpoint: `${base_url}admin/static_page/listGambar`,
            fullUrlPrefix: `${base_url}assets/upload/tinymce/image/`,
            thumbUrlPrefix: `${base_url}assets/upload/tinymce/1000/`
        }
    });

    $.upload = function(file) {
        let out = new FormData();
        out.append('file', file, file.name);
        $.ajax({
            method: 'POST',
            url: `${base_url}admin/upload/tinymce`,
            contentType: false,
            cache: false,
            processData: false,
            data: out,
            success: function(img) {
                $('.summernote').summernote('insertImage', img);
                $('.summernote.editVal').summernote('insertImage', img);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    };
    $.delete = function(src) {
        $.ajax({
            method: 'POST',
            url: `${base_url}admin/static/deleteGambar`,
            cache: false,
            data: {
                src: src
            },
            success: function(response) {
                        // Swal.fire({
                        //  position: 'top-end',
                        //  icon: 'success',
                        //  title: response,
                        //  showConfirmButton: false,
                        //  timer: 1500
                        // })

            }

        });
    };
});

 function konfirmasi(url) {
    var result = confirm("Want to delete?");
    if (result) {
        window.location.href = url;
    }

}

function convertToSlug(Text) {
  return Text.toLowerCase()
  .replace(/ /g, '-')
  .replace(/[^\w-]+/g, '');
}
$('#judul').change(function(){
    $('#slug').val(convertToSlug($('#judul').val()))

})
$('#id_admin').val(<?=$_SESSION['profile'][0]['id']?>)
$('.judul').change(function(){
    $('.slug').val(convertToSlug($('.judul').val()))

})
$('.id_admin').val(<?=$_SESSION['profile'][0]['id']?>)

</script>