<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/datatables/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/summernote/summernote-image-list.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets')?>/summernote/summernote-lite.min.css"/>


<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Produk</h3>
                <p class="text-subtitle text-muted">Manage Produk</p>
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
              <div class="card-header">
              <div class="text-center">
              <h3>PRODUK</h3>
            </div>
                <button type="button" class="btn btn-primary tambahProduk">Tambah Produk</button>
                <button type="button" class="btn btn-primary groupProduct">Group Produk</button>
                <button type="button" class="btn btn-primary sizeProduct">Size Produk</button>
                <div class="float-lg-end">
                <button type="button" class="btn btn-primary restoreData">Restore Produk Terhapus</button>
                </div>
            </div>
            <div class="card-body">
                          <!-- table -->
          <div class="table-responsive">
            <table id="tabelProduct" class="table table-bordered display text-left" cellspacing="0" width="100%">
              <thead>
                <tr  class="text-center">
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 20%; text-align: center;">PRODUK</th>
                  <th style="width: 5%; text-align: center;">IMAGE</th>
                  <th style="width: 20%; text-align: center;">ACTION</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="text-center">
                  <th style="width: 5%; text-align: center;">NO</th>
                  <th style="width: 20%; text-align: center;">PRODUK</th>
                  <th style="width: 5%; text-align: center;">IMAGE</th>
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
 <div class="modal modalRestore" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Produk dihapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div class="table-responsive">
            <table id="tabelKategori" class="table table-bordered display text-center" cellspacing="0" width="100%">
              
              <thead>
                <tr  class="text-center">
  
                    <th  style="width: auto;">No</th>
                    <th  style="width: auto;">Kategori</th>
                    <th  style="width: auto;">Action</th>

                    <!-- <th  style="width: 10%;">Action</th> -->

                </tr>
                <br>
              </thead>
                  <tbody id = isiDeletedCat>

                  </tbody>

              <tfoot>
               <tr>
                    <!-- <th  style="width: auto;">No</th> -->
                    <th  style="width: auto;">No</th>
                    <th  style="width: auto;">Kategori</th>
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
    <div class="modal fade modalGroupProduk" id="modalCat" data-bs-focus="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Group Produk: <span id = "nama_kategori"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div>
                <a class="btn btn-success btn-sm tambahKategori"  >Tambah Kategori/Group</a>
                
            </div>
                          <div class="table-responsive">
            <table id="tabelKategori" class="table table-bordered display text-center" cellspacing="0" width="100%">
              
              <thead>
                <tr  class="text-center">
  
                    <th  style="width: auto;">No</th>
                    <th  style="width: auto;">Kategori</th>
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
        <!-- modal -->
          <div class="modal fade modalSize" id="modalSize" data-bs-focus="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Group Size: <span id = "nama_kategori"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <div>
                <a class="btn btn-success btn-sm tambahSize"  >Tambah Size</a>
                
            </div>
                          <div class="table-responsive">
            <table id="tabelKategori" class="table table-bordered display text-center" cellspacing="0" width="100%">
              
              <thead>
                <tr  class="text-center">
  
                    <th  style="width: auto;">No</th>
                    <th  style="width: auto;">Kategori</th>
                    <th  style="width: auto;">Size</th>
                    <th  style="width: auto;">Action</th>

                    <!-- <th  style="width: 10%;">Action</th> -->

                </tr>
                <br>
              </thead>
                  <tbody id = isiSize>

                  </tbody>

              <tfoot>
               <tr>
                    <!-- <th  style="width: auto;">No</th> -->
                    <th  style="width: auto;">No</th>
                    <th  style="width: auto;">Kategori</th>
                    <th  style="width: auto;">Size</th>
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
                <label for="nama" class="form-label">Nama Produk</label>
                <input type="text" name="nama" class="form-control" id="nama" >
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Group</label>
                <select class="form-control  select_group" name="id_group" style="width:auto;" aria-label="Default select example" id="id_group"></select>

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
                <label for="contact" class="form-label">Deskripsi Produk</label>
                <textarea class="summernote editVal" name="text" inputVal = "text" id="text" cols="30" rows="10"></textarea>
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

<div class="modal fade" id="modalViewProduct" tabindex="-1" aria-labelledby="modalViewProductLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalViewProductLabel">Rincian Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">
              <img id="productImage" src="https://via.placeholder.com/300" class="img-fluid" alt="Gambar Produk">
            </div>
            <div class="col-md-8">
              <h4 id="productName"></h4>
              <p id="productGroup"></p>
              <p id="productDescription"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalUpdateProduct" tabindex="-1" aria-labelledby="modalUpdateProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUpdateProductLabel">Update Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formUpdateProduct" enctype="multipart/form-data">
                    <input type="hidden" id="productId" name="id">
                    <div class="mb-3">
                        <label for="namaUpdate" class="form-label">Nama Produk</label>
                        <input type="text" name="nama" class="form-control" id="namaUpdate" required>
                    </div>
                    <div class="mb-3">
                        <label for="groupUpdate" class="form-label">Group Produk</label>
                        <select class="form-control select_group" name="id_group" id="groupUpdate" required></select>
                    </div>
                    <div class="mb-3">
                        <label for="textUpdate" class="form-label">Deskripsi Produk</label>
                        <textarea class="summernote" name="text" id="textUpdate" cols="30" rows="10"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveUpdate">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditImage" tabindex="-1" aria-labelledby="modalEditImageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditImageLabel">Edit Gambar Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditImage" enctype="multipart/form-data">
                    <input type="hidden" id="productIdImage" name="id">
                    <div class="mb-3 text-center">
                        <img id="currentImage" src="https://via.placeholder.com/300" class="img-fluid mb-3" alt="Gambar Produk">
                    </div>
                    <div class="mb-3">
                        <label for="newImage" class="form-label">Pilih Gambar Baru</label>
                        <input type="file" class="form-control" id="newImage" name="image" accept="image/*" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveImage">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<script type="text/javascript" src="<?=base_url('assets')?>/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/js/product.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/summernote/summernote-lite.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/summernote/summernote-image-list.min.js"></script>
 <script type="text/javascript">

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

</script>