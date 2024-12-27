let loc = window.location;
let base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";
let page = loc.pathname.split("/").pop();
function toName(string) {
    a =  string.split('-').join(' ')
    b =  a.split('_').join(' ')
    return b.charAt(0).toUpperCase() + b.slice(1);
}
$('.nama_halaman').html(toName(page));
$(document).ready(function () { $('.table').DataTable({ "processing" : true,
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
  }});
$('.tableDeleted').DataTable({ "processing" : true,
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
  }});
   });
tabel();
function tabel(){
  data = "";
  param = "";
  $.ajax({
    type : "POST",
    url  : base_url+"admin/static_page/read",
    async : false,
    data:{page:page, data:data, param:param},
    success: function(data){
     d = JSON.parse(data);
     let no = 1;
     let table = ''
     let status = ''
     let button = ''
     $.each(d, function(k, v){
      if (d[k].status == 1) {
        status = `<p class="text-success">ACTIVE</p>`
        button = `<a href="javascript:void(0);" class="btn btn-secondary btn-sm editPicture" picture = "${d[k].picture}" id="${d[k].id}"  >Edit Picture</a> <a href="javascript:void(0);" class="btn btn-primary btn-sm edit" id="${d[k].id}"  >Edit Text</a> <a href="javascript:void(0);" class="btn btn-warning btn-sm ubahstatus" status = "0" id="${d[k].id}"  >Nonaktifkan</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm delete" nama = "${d[k].nama}"  id="${d[k].id}"  >Hapus</a>`
      }else{
        status = `<p class="text-danger">NON ACTIVE</p>`
        button = `<a href="javascript:void(0);" class="btn btn-secondary btn-sm editPicture" picture = "${d[k].picture}" id="${d[k].id}"  >Edit Picture</a> <a href="javascript:void(0);" class="btn btn-primary btn-sm edit" id="${d[k].id}"  >Edit Text</a> <a href="javascript:void(0);" class="btn btn-success btn-sm ubahstatus" status = "1" id="${d[k].id}"  >Aktifkan</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm delete" nama = "${d[k].nama}" id="${d[k].id}"  >Hapus</a>` 
      }
      table += `<tr><th style = "text-align: center">${no++}</th><th>${d[k].nama}</th><th style = "text-align: center"><img alt="Image" src="${base_url}assets/upload/thumb/${d[k].picture}" onerror="this.onerror=null; this.src='${base_url}assets/upload/noimage/thumb/noimage.png';" /><th  style = "text-align: center">${status}</th><th  style = "text-align: center">${button}</th></tr>`

    })
     $('#tabel').html(table);
   }
 });
};
function tabelDeleted(){
  data = "";
  param = "";
  $.ajax({
    type : "POST",
    url  : base_url+"admin/static_page/read_deleted",
    async : false,
    data:{page:page, data:data, param:param},
    success: function(data){
     d = JSON.parse(data);
     let no = 1;
     let table = ''
     let status = ''
     let button = ''
     $.each(d, function(k, v){
      if (d[k].status == 1) {
        status = `<p class="text-success">ACTIVE</p>`
        button = `<a href="javascript:void(0);" class="btn btn-primary btn-sm restore" nama = "${d[k].nama}" id="${d[k].id}"  >Restore</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm permanentDelete" nama = "${d[k].nama}"  id="${d[k].id}"  >Hapus Permanen</a>`
      }else{
        status = `<p class="text-danger">NON ACTIVE</p>`
        button = `<a href="javascript:void(0);" class="btn btn-primary btn-sm restore" nama = "${d[k].nama}" id="${d[k].id}"  >Restore</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm permanentDelete" nama = "${d[k].nama}" id="${d[k].id}"  >Hapus Permanen</a>` 
      }
      table += `<tr><th style = "text-align: center">${no++}</th><th>${d[k].nama}</th><th style = "text-align: center"><img alt="Image" src="${base_url}assets/upload/thumb/${d[k].picture}" onerror="this.onerror=null; this.src='${base_url}assets/upload/noimage/thumb/noimage.png';" /><th  style = "text-align: center">${status}</th><th  style = "text-align: center">${button}</th></tr>`

    })
     $('#tabelDeletedData').html(table);
   }
 });
};
// 
$('.tambah_data').on('click',function(){
  $('.modalTambahData').modal('show');	
})
$('.restore_data').on('click',function(){
  $('.modalDeletedData').modal('show'); 
tabelDeleted()
})
tabelDeleted()

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
    url  : base_url+"admin/static_page/create",
    async : false,
        // dataType : 'json',
    data:{page:page, data:data, param:param},
    success : function(res){
          //reload table
      $('.uploadBtn').html('Upload');
      $('.uploadBtn').prop('disabled', false);
      $('.modalTambahData').modal('hide');  
      $('#ajaxImgUpload').removeAttr('src');
      $('.uploadBtn').addClass("btn-danger");
      $('.uploadBtn').removeClass("btn-success");

      $('#form').trigger("reset");
      tabel();
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
$('#tabel').on('click','.edit',function(){
  param = {id:$(this).attr('id')}
  getDataEdit(param);
  $('.modalEdit').modal('show'); 


})
function getDataEdit(param){
  data = "";
  $.ajax({
    type : "POST",
    url  : base_url+"admin/static_page/read",
    async : false,
    data:{page:page, data:data, param:param},
    success: function(data){
     d = JSON.parse(data);
     let no = 1;
     let table = ''
     let status = ''
     let button = ''
     $.each(d[0], function(k, v){
      $(`input[name='${k}'].editVal`).val(v)
      if (k == 'text') {
      $(".summernote.editVal").summernote("code", v);
    }
    })
   }
 });
}
$('.saveUpdateText').on('click',function(){
  form = $('.formUpdateText').serializeArray()
  let data = {}
  $.each(form, function(i, field){
    data[field.name] =  field.value;
  });
  param={id:data['id']}
  $.ajax({
    type  : 'post',
    url  : base_url+"admin/static_page/update",
    async : false,
        // dataType : 'json',
    data:{page:page, data:data, param:param},
    success : function(res){
          //reload table
      $('#form').trigger("reset");
      $('.modalEdit').modal('hide');  
      tabel();
      Swal.fire(
        'Berhasil!',
        ''+data['nama']+' telah diubah.',
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
})
$('#tabel').on('click','.ubahstatus',function(){
  let id = $(this).attr('id');
  let status = $(this).attr('status');
  param = {id:id}
  data = {status:status}
  $.ajax({
    type : "POST",
    url  : base_url+"admin/static_page/update",
    async : false,
    data:{page:page, data:data, param:param},
    success: function(data){
      tabel();
    }
  });
})
$('#tabel').on('click','.delete',function(){
  id = $(this).attr('id');
  nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: ""+nama+" akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      param = {id:id}
      data = ''
      $.ajax({
        type : "POST",
        url  : base_url+"admin/static_page/delete",
        async : false,
        data:{page:page, data:data, param:param},
        success: function(data){
          tabel();
          Swal.fire(
            'Deleted!',
            ''+nama+' telah dihapus.',
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
  data.append('page', page);
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
     url  : base_url+"admin/static_page/upload",
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
$('#tabelDeletedData').on('click','.restore',function(){
  id = $(this).attr('id');
  nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: ""+nama+" akan dikembalikan!",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, restore!'
  }).then((result) => {
    if (result.isConfirmed) {
      param = {id:id}
      data = ''
      $.ajax({
        type : "POST",
        url  : base_url+"admin/static_page/restore",
        async : false,
        data:{page:page, data:data, param:param},
        success: function(data){
          tabel();
          tabelDeleted();
          Swal.fire(
            'Restored!',
            ''+nama+' telah dikembalikan.',
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
$('#tabelDeletedData').on('click','.permanentDelete',function(){
  id = $(this).attr('id');
  nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: ""+nama+" akan dihapus permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus!'
  }).then((result) => {
    if (result.isConfirmed) {
      param = {id:id}
      data = ''
      $.ajax({
        type : "POST",
        url  : base_url+"admin/static_page/purge",
        async : false,
        data:{page:page, data:data, param:param},
        success: function(data){
          tabelDeleted();
          Swal.fire(
            'Deleted!',
            ''+nama+' telah dihapus permanen.',
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
$('#tabel').on('click','.editPicture',function(){
  viewPic($(this).attr('picture'))
  $('#idUpdate').val($(this).attr('id'))
  $('.modalEditPicture').modal('show');  
})
function viewPic(data){
      $('.saveUpdatePicture').removeClass("btn-primary");
      $('.saveUpdatePicture').addClass("btn-secondary");
      $('.saveUpdatePicture').prop('disabled', true);
      $('#image_before').attr('src', `${base_url}assets/upload/1000/${data}`).height(300);
      $('#image_after').attr('src', `${base_url}assets/upload/noimage/thumb/noimage.png`).height(300);

  }
$('#fileUpdate').change(function(){
  $('.saveUpdatePicture').removeClass("btn-secondary");
  $('.saveUpdatePicture').addClass("btn-primary");
  $('.saveUpdatePicture').prop('disabled', false);
  // $('#pictureEdit').val('');
  const file = this.files[0];
  if (file){
    let reader = new FileReader();
    reader.onload = function(event){
      $('#image_after').attr('src', event.target.result).height(300);
    }
    reader.readAsDataURL(file);
  }
});

$('.saveUpdatePicture').on('click',function(){
updateFile()
})
function updateFile(){
  input = $('#fileUpdate').prop('files')[0];
  idUpdate = $('#idUpdate').val();

  data = new FormData();
          
          // data['file'] = input;
  data.append('file', input);
  data.append('page', page);
  data.append('id', idUpdate);
  data.append('param', '');
  data.append('data', '');
  if (!input) {
    alert("Choose File");
  } else {
    $.ajax({
     type : "POST",
     enctype: 'multipart/form-data',
     url  : base_url+"admin/static_page/upload",
     async : false,
     processData: false,
     contentType: false,
     data:data,
     success: function (res) {
     $('.modalEditPicture').modal('hide');  
      tabel();
      Swal.fire(
        'Berhasil!',
        'Picture Berhasil diubah.',
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
}