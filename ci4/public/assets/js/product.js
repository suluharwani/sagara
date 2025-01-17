let loc = window.location;
let base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";



 function selectGroup(id_group=null){
      $.ajax({
        type : "POST",
        url  : base_url+"admin/product/select_group",
        async : true,
        dataType : 'json',
        success: function(data){
          let selOpts = '';
          $.each(data, function(k, v)
          {
            var id = data[k].id;
            var group = data[k].group;

            selOpts += "<option value='"+id+"'>"+group+"</option>";

        });
          $('.select_group').html(selOpts);
          if (id_group!=null) {
              $('.select_group option[value='+id_group+']').attr('selected','selected');
          }
      }
  });
  }
$(document).ready(function () { 
  let dataTable = $('#tabelProduct').DataTable( {
    "processing" : true,
    "oLanguage": {
      "sLengthMenu": "Tampilkan _MENU_ data per halaman",
      "sSearch": "Pencarian: ",
      "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
      "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
      "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
      "sInfoFiltered": "(di filter dari _MAX_ total data)",
      "oPaginate": {
        "sFirst": "<<",
        "sLast": ">>",
        "sPrevious": "<",
        "sNext": ">"
      }
    },
    "dom": 'Bfrtip',
    "buttons": [
    'csv'
    ],
    "order": [],
    "ordering": true,
    "info": true,
    "serverSide": true,
    "stateSave" : true,
    "scrollX": true,
    "ajax":{
      "url" :base_url+"product/listdataProduct" , // json datasource 
      "type": "post",  // method  , by default get
      "data":{},
    },
    columns: [
    {},
    {mRender: function (data, type, row) {
      return  row[2];
    }},
    {mRender: function (data, type, row) {
      return   ` <img src="${base_url}assets/upload/image/${row[3]}"  alt="Gambar Produk" height = "60px">`;

    }},
   

    {mRender: function (data, type, row) {
    return `
                <a href="javascript:void(0);" class="btn btn-success btn-sm viewProduk" data-id="${row[1]}">View</a>
                <a href="javascript:void(0);" class="btn btn-warning btn-sm editProduk" data-id="${row[1]}">Edit</a>
                <a href="javascript:void(0);" class="btn btn-info btn-sm editImage" data-id="${row[1]}">Edit Gambar</a>
                <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_hapus_menu" data-id="${row[1]}">Delete</a>
            `;
    }
  }
  ],
  "columnDefs": [{
    "targets": [0,2,3],
    "orderable": false
  }],

  error: function(){  // error handling
    $(".tabel_serverside-error").html("");
    $("#tabel_serverside").append('<tbody class="tabel_serverside-error"><tr><th colspan="3">Data Tidak Ditemukan di Server</th></tr></tbody>');
    $("#tabel_serverside_processing").css("display","none");

  }

});

}
)


$(document).on('click', '.viewProduk', function() {
    const id = $(this).data('id');
    $.ajax({
        type: "POST",
        url: `${base_url}admin/product/getProductDetail`,
        data: { id },
        dataType: 'json',
        success: function(data) {
            Swal.fire({
                title: 'Rincian Produk',
                html: `
                    <strong>Nama:</strong> ${data.nama}<br>
                    <strong>Group:</strong> ${data.group}<br>
                    <strong>Deskripsi:</strong> ${data.text}<br>
                    <img src="${base_url}assets/upload/image/${data.picture}" height="300px;" alt="Gambar Produk">
                `,
                width: 600,
                confirmButtonText: 'Close'
            });
        },
        error: function(xhr) {
            Swal.fire('Error', 'Gagal memuat data produk.', 'error');
        }
    });
});

$(document).on('click', '.editProduk', function () {
    const id = $(this).data('id');

    // Fetch data for the selected product
    $.ajax({
        type: 'POST',
        url: `${base_url}admin/product/getProductDetail`,
        data: { id: id },
        dataType: 'json',
        success: function (data) {
            // Populate modal fields
            $('#productId').val(data.id);
            $('#namaUpdate').val(data.nama);
            $('#textUpdate').summernote('code', data.text);
            selectGroup(data.id_group);

            // Show the modal
            $('#modalUpdateProduct').modal('show');
        },
        error: function () {
            Swal.fire('Error', 'Gagal memuat data produk.', 'error');
        }
    });
});

// Save changes
$('.saveUpdate').on('click', function () {
    const formData = {
        id: $('#productId').val(),
        nama: $('#namaUpdate').val(),
        id_group: $('#groupUpdate').val(),
        text: $('#textUpdate').summernote('code'),
    };

    // Send update request
    $.ajax({
        type: 'POST',
        url: `${base_url}admin/product/updateProduct`,
        data: { data: formData },
        dataType: 'json',
        success: function (response) {
            Swal.fire('Berhasil!', response.message, 'success');
            $('#modalUpdateProduct').modal('hide');
            $('#tabelProduct').DataTable().ajax.reload();
        },
        error: function (xhr) {
            Swal.fire('Gagal!', xhr.responseJSON.message, 'error');
        }
    });
});

// Function to fetch and populate group options
$(document).on('click', '.editImage', function () {
    const id = $(this).data('id');

    // Fetch product details to display current image
    $.ajax({
        type: 'POST',
        url: `${base_url}admin/product/getProductDetail`,
        data: { id: id },
        dataType: 'json',
        success: function (data) {
            // Populate modal fields
            $('#productIdImage').val(data.id);
            $('#currentImage').attr('src', `${base_url}assets/upload/image/${data.picture}`);
            
            // Show the modal
            $('#modalEditImage').modal('show');
        },
        error: function () {
            Swal.fire('Error', 'Gagal memuat data produk.', 'error');
        }
    });
});

// Save new image
$('.saveImage').on('click', function () {
    const formData = new FormData($('#formEditImage')[0]);

    $.ajax({
        type: 'POST',
        url: `${base_url}admin/product/updateImage`,
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            Swal.fire('Berhasil!', response.message, 'success');
            $('#modalEditImage').modal('hide');
            $('#tabelProduct').DataTable().ajax.reload();
        },
        error: function (xhr) {
            Swal.fire('Gagal!', xhr.responseJSON.message, 'error');
        }
    });
});


$(document).on('click', '.btn_hapus_menu', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Produk ini akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: base_url + 'admin/product/deleteProduct',
                data: { id: id },
                dataType: 'json',
                success: function(res) {
                    Swal.fire('Deleted!', res.message, 'success');
                    $('#tabelProduct').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire('Oops...', xhr.responseJSON.message, 'error');
                }
            });
        }
    });
});

$('.tambahProduk').on('click',function(){
   selectGroup()
  $('.modalTambahData').modal('show')
})
$('.groupProduct').on('click',function(){
  dataCat()
  $('.modalGroupProduk').modal('show')
})
$('.restoreData').on('click',function(){
  dataDeletedCat()
  $('.modalRestore').modal('show')
})

$('.tambahKategori').on('click',function(){

  Swal.fire({
    title: `Tambah Group Produk `,
    html:`<form id="form_add_data">
    <div class="form-group">
    <label for="group">Group</label>
    <input type="text" class="form-control" id="group" placeholder="group">
    </div>
    </form>`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const group = Swal.getPopup().querySelector('#group').value
      if (!group) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return { group: group }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/product/tambah_group',
      async : false,
      // dataType : "JSON",
      data : {group:result.value.group},
      success: function(data){
        dataCat()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Group berhasil ditambahkan.`,
          showConfirmButton: false,
          timer: 1500
        })
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });

  })
})

$('#file').change(function(){
  $('.uploadBtn').html('Upload');
  $('.uploadBtn').prop('disabled', false);
  $('.uploadBtn').addClass("btn-danger");
  $('.uploadBtn').removeClass("btn-success");
  $('#picture').val('');
  const file = this.files[0];
  if (file){
    let reader = new FileReader();
    reader.onload = function(event){
      $('#ajaxImgUpload').attr('src', event.target.result).width(300);
    }
    reader.readAsDataURL(file);
  }
});
$('.reset').on('click',function(){
  $('#form').trigger("reset");
  $('.uploadBtn').html('Upload');
  $('.uploadBtn').prop('disabled', false);
  $('.uploadBtn').addClass("btn-danger");
  $('.uploadBtn').removeClass("btn-success");
  $('#ajaxImgUpload').attr('src', 'https://via.placeholder.com/300');
})


$('.uploadBtn').on('click',function(){
  upload()

})
function upload(){
  input = $('#file').prop('files')[0];

  param = ''
  data = new FormData();
          // data['file'] = input;
  data.append('file', input);
  data.append('param', param);
  data.append('data', '');
  $('.uploadBtn').html('Uploading ...');
  $('.uploadBtn').attr('disabled');
  if (!input) {
    alert("Choose File");
    $('.uploadBtn').html('Upload');
    $('.uploadBtn').prop('disabled', false);
  } else {
    $.ajax({
     type : "POST",
     enctype: 'multipart/form-data',
     url  : base_url+"admin/product/upload",
     async : false,
     processData: false,
     contentType: false,
     data:data,
     success: function (res) {
      if (res.success == true) {
        $('.uploadBtn').html('Uploaded!');
        $('.uploadBtn').prop('disabled', true);
        $('.uploadBtn').removeClass("btn-danger");
        $('.uploadBtn').addClass("btn-success");
        $('#picture').val(res.picture);

                                // $('#ajaxImgUpload').attr('src', 'https://via.placeholder.com/300');
        $('#alertMsg').addClass("text-success");
        $('#alertMsg').html(res.msg);
        $('#alertMessage').show();
      } else if (res.success == false) {
        $('#alertMsg').addClass("text-danger");
        $('#alertMsg').html(res.msg);
        $('#picture').val('');

        $('#alertMessage').show();
        $('.uploadBtn').html('Upload Failed!');
        $('.uploadBtn').prop('disabled', false);
        $('.uploadBtn').addClass("btn-danger");
        $('.uploadBtn').removeClass("btn-success");

      }
      setTimeout(function () {
        $('#alertMsg').html('');
        $('#alertMessage').hide();
      }, 4000);

                            // document.getElementById("form").reset();
    }
  });
  }
}

$('.save').on('click',function(){
  if ($('#picture').val()=='') {
    Swal.fire({
      title: 'Gambar belum diupload!',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: 'Upload gambar lalu simpan',
      denyButtonText: `Tanpa Gambar`,
    }).then((result) => {
  /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        upload()
      } else if (result.isDenied) {
        simpan()
      }
    })
  }else{
    simpan()

  }
})


function simpan(){
  form = $('.form').serializeArray()
  let data = {}
  $.each(form, function(i, field){
    data[field.name] =  field.value;

  });
  if (typeof document.getElementsByName("text")[0] !== 'undefined') {
  data['text'] = document.getElementsByName("text")[0].value
}
  param=''
  $.ajax({
    type  : 'post',
    url  : base_url+"admin/product/create",
    async : false,
        // dataType : 'json',
    data:{data:data, param:param},
    success : function(res){
          //reload table
      
      $('.uploadBtn').html('Upload');
      $('.uploadBtn').prop('disabled', false);
      $('.modalTambahData').modal('hide');  
      $('#ajaxImgUpload').removeAttr('src');
      $('.uploadBtn').addClass("btn-danger");
      $('.uploadBtn').removeClass("btn-success");

      $('#form').trigger("reset");
      $('#tabelProduct').DataTable().ajax.reload();
      Swal.fire(
        'Berhasil!',
        ''+data['nama']+' telah ditambahkan.',
        'success'
        )
    },
    error: function(xhr){
      $('.uploadBtn').html('Upload');
      $('.uploadBtn').prop('disabled', false);
      $('.uploadBtn').addClass("btn-danger");
      $('.uploadBtn').removeClass("btn-success");
      let d = JSON.parse(xhr.responseText);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `${d.message}`,
        footer: '<a href="">Why do I have this issue?</a>'
      })
    }
  });
}

function dataCat(){
  $.ajax({
    type : "POST",
    url  : base_url+"admin/product/select_group",
    async : false,
    data:{},
    success: function(data){

       d = JSON.parse(data);
  let no = 1;
  let table = ''
  $.each(d, function(k, v){
            table+=     `<tr>`;
         
              table+=   `<td>${no++}</td>`;
              table+=   `<td>${d[k].group}</td>`;
              table+=   `<td><a href="javascript:void(0);" class="btn btn-warning btn-sm editCat"  id="${d[k].id}" nama = "${d[k].group}">Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteCat"  id="${d[k].id}" nama = "${d[k].group}" >Delete</a>`;
                
          table+=   `</tr>`
   })
 $('#isiCat').html(table)
  
    },
    error: function(xhr){
      let d = JSON.parse(xhr.responseText);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `${d.message}`,
        footer: '<a href="">Why do I have this issue?</a>'
      })
    }
  });
}
function dataDeletedCat(){
  $.ajax({
    type : "POST",
    url  : base_url+"admin/product/deleted_group",
    async : false,
    data:{},
    success: function(data){

       d = JSON.parse(data);
  let no = 1;
  let table = ''
  $.each(d, function(k, v){
            table+=     `<tr>`;
         
              table+=   `<td>${no++}</td>`;
              table+=   `<td>${d[k].group}</td>`;
              table+=   `<td> <a href="javascript:void(0);" class="btn btn-warning btn-sm restoreCat"  id="${d[k].id}" nama = "${d[k].group}" >Restore</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm permanentDeleteCat"  id="${d[k].id}" nama = "${d[k].group}" >Delete</a>`;
                
          table+=   `</tr>`
   })
 $('#isiDeletedCat').html(table)
  
    },
    error: function(xhr){
      let d = JSON.parse(xhr.responseText);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `${d.message}`,
        footer: '<a href="">Why do I have this issue?</a>'
      })
    }
  });
}
$('#isiCat').on('click','.editCat',function(){
  let id = $(this).attr('id');
  let nama = $(this).attr('nama');

  Swal.fire({
    title: `Edit kategori ${nama} `,
    html: `<input type="text" id="category" class="swal2-input" placeholder="" value= "${nama}">`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const category = Swal.getPopup().querySelector('#category').value
      if (!category) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {category: category }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'admin/product/update_cat',
      async : false,
      // dataType : "JSON",
      data : {catBefore:nama,id:id,category:result.value.category},
      success: function(data){
        dataCat();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Kategori ${nama} berhasil diubah menjadi ${result.value.category}.`,
          showConfirmButton: false,
          timer: 2500
        })
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });

  })
});
$('#isiCat').on('click','.deleteCat',function(){
  let id = $(this).attr('id');
  let nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Group "+nama+" akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus group!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/product/hapus_cat',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          dataCat()
          Swal.fire(
            'Deleted!',
            'Group '+nama+' telah dihapus.',
            'success'
            )
        },
        error: function(xhr){
          let d = JSON.parse(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `${d.message}`,
            footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      });
    }
  })
})
$('#isiDeletedCat').on('click','.restoreCat',function(){
  let id = $(this).attr('id');
  let nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Group "+nama+" akan dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, kembalikan group!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/product/restore_cat',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          dataDeletedCat()
      
          Swal.fire(
            'Restored!',
            'Group '+nama+' telah dikembalikan.',
            'success'
            )
        },
        error: function(xhr){
          let d = JSON.parse(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `${d.message}`,
            footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      });
    }
  })
})
$('#isiDeletedCat').on('click','.permanentDeleteCat',function(){
  let id = $(this).attr('id');
  let nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Group "+nama+" akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus permanen group!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/product/purge_group',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          dataDeletedCat()
      
          Swal.fire(
            'Deleted!',
            'Group '+nama+' telah dihapus.',
            'success'
            )
        },
        error: function(xhr){
          let d = JSON.parse(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `${d.message}`,
            footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      });
    }
  })
})

$('.sizeProduct').on('click',function(){
  dataSize()
  $('.modalSize').modal('show')
})

$('.tambahSize').on('click',function(){

  Swal.fire({
    title: `Tambah Size Produk `,
    html:`<form id="form_add_data">

    <div class="form-group">
    <label for="kategori">kategori</label>
    <input type="text" class="form-control" id="kategori" placeholder="kategori">
    <label for="ukuran">Size</label>
    <input type="text" class="form-control" id="ukuran" placeholder="ukuran">
    </div>
    </form>`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const kategori = Swal.getPopup().querySelector('#kategori').value
      const ukuran = Swal.getPopup().querySelector('#ukuran').value
      if (!kategori || !ukuran) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return { kategori:kategori,ukuran:ukuran }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/product/tambahSize',
      async : false,
      // dataType : "JSON",
      data : {kategori:result.value.kategori,ukuran:result.value.ukuran},
      success: function(data){
        dataSize()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Group berhasil ditambahkan.`,
          showConfirmButton: false,
          timer: 1500
        })
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });

  })
})

function dataSize(){
  $.ajax({
    type : "POST",
    url  : base_url+"admin/product/selectSize",
    async : false,
    data:{},
    success: function(data){

       d = JSON.parse(data);
  let no = 1;
  let table = ''
  $.each(d, function(k, v){
            table+=     `<tr>`;
         
              table+=   `<td>${no++}</td>`;
              table+=   `<td>${d[k].kategori}</td>`;
              table+=   `<td>${d[k].ukuran}</td>`;
              table+=   `<td><a href="javascript:void(0);" class="btn btn-warning btn-sm editSize"  id="${d[k].id}" kategori = "${d[k].kategori}" ukuran = "${d[k].ukuran}">Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteSize"  id="${d[k].id}" kategori = "${d[k].kategori}" ukuran = "${d[k].ukuran}" >Delete</a>`;
                
          table+=   `</tr>`
   })
 $('#isiSize').html(table)
  
    },
    error: function(xhr){
      let d = JSON.parse(xhr.responseText);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: `${d.message}`,
        footer: '<a href="">Why do I have this issue?</a>'
      })
    }
  });
}

$('#isiSize').on('click','.editSize',function(){
  let id = $(this).attr('id');
  let kategori = $(this).attr('kategori');
  let ukuran = $(this).attr('ukuran');

  Swal.fire({
    title: `Edit Size `,
    html: `<form id="form_edit_data">
    <div class="form-group">
    <label for="kode">kategori</label>
    <input type="text" class="form-control" id="kategori" aria-describedby="kategori" placeholder="kategori" value= "${kategori}">

    </div>
    <div class="form-group">
    <label for="namaWarehouse">ukuran</label>
    <input type="text" class="form-control" id="ukuran" aria-describedby="ukuran" placeholder="ukuran" value= "${ukuran}">

    </div>
    </form>
    `,
    confirmButtonText: 'Update',
    focusConfirm: false,
    preConfirm: () => {
      const kategori = Swal.getPopup().querySelector('#kategori').value
      const ukuran = Swal.getPopup().querySelector('#ukuran').value
      if (!kategori||!ukuran) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      
      return {kategori:kategori, ukuran:ukuran  }
    }
  }).then((result) => {
    params = {kategori:result.value.kategori,id:id,ukuran:result.value.ukuran}
    $.ajax({
      type : "POST",
      url  : base_url+'admin/product/updateSize',
      async : false,
      // dataType : "JSON",
      data : {params},
      success: function(data){
        dataSize();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Berhasil diubah.`,
          showConfirmButton: false,
          timer: 2500
        })
      },
      error: function(xhr){
        let d = JSON.parse(xhr.responseText);
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: `${d.message}`,
          footer: '<a href="">Why do I have this issue?</a>'
        })
      }
    });

  })
});

// $('#isiSize').on('click','.deleteSize',function(){
//   let id = $(this).attr('id');
//   let kategori = $(this).attr('kategori');
//   let ukuran = $(this).attr('ukuran');

//   Swal.fire({
//     title: 'Apakah anda yakin?',
//     text: `${kategori}-${ukuran} akan dihapus!`,
//     icon: 'warning',
//     showCancelButton: true,
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
//     confirmButtonText: 'Ya, hapus!'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       $.ajax({
//         type  : 'post',
//         url   : base_url+'/admin/product/purge_group',
//         async : false,
//         // dataType : 'json',
//         data:{id:id, nama:nama},
//         success : function(data){
//           //reload table
//           dataDeletedCat()
      
//           Swal.fire(
//             'Deleted!',
//             `Group ${kategori}-${ukuran} telah dihapus.`,
//             'success'
//             )
//         },
//         error: function(xhr){
//           let d = JSON.parse(xhr.responseText);
//           Swal.fire({
//             icon: 'error',
//             title: 'Oops...',
//             text: `${d.message}`,
//             footer: '<a href="">Why do I have this issue?</a>'
//           })
//         }
//       });
//     }
//   })
// })

$('#isiSize').on('click','.deleteSize',function(){
  let id = $(this).attr('id');
  let kategori = $(this).attr('kategori');
  let ukuran = $(this).attr('ukuran');

  Swal.fire({
    title: 'Apakah anda yakin?',
    text: ""+kategori+"-"+ukuran+"  akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      params = {id:id, kategori:kategori, ukuran:ukuran}
      data = ''
      $.ajax({
        type : "POST",
        url  : base_url+'/admin/product/purgeSize',
        async : false,
        data:{params:params},
        success: function(data){
          dataSize();
      Swal.fire(
            'Deleted!',
            `Group ${kategori}-${ukuran} telah dihapus.`,
            'success'
            )
        },
        error: function(xhr){
          let d = JSON.parse(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: `${d.message}`,
            footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      });
    }
  })

})
