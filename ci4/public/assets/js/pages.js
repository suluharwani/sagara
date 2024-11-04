var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

tabel();
function tabel(){
  var dataTable = $('#tabel_serverside').DataTable( {
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
      "url" :base_url+"pages/listdata_pages" , // json datasource 
      "type": "post",  // method  , by default get
      "data":{},
    },
    columns: [
    {},
    {mRender: function (data, type, row) {
      return  row[2];
    }},
    {mRender: function (data, type, row) {
      return   '<a href="javascript:void(0);" class="btn btn-success btn-sm view_data_category" nama_page = "'+row[2]+'" id="'+row[1]+'" >Category</a>  ';

    }},
   

    {mRender: function (data, type, row) {
    return   ' <a href="javascript:void(0);" class="btn btn-warning btn-sm editPage"  id="'+row[1]+'"  nama = "'+row[2]+'" >Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_hapus_menu" id="'+row[1]+'"  nama = "'+row[2]+'" >Hapus</a>';

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
};
$('#tabel_serverside').on('click','.view_data_category',function(){
  let id = $(this).attr('id');
  let nama_page = $(this).attr('nama_page');
  dataCat(id);
     $('.tambahKategori').attr({'id':`${id}`, 'nama':`${nama_page}`});
     $('.modalCat').modal('show')
  $('#nama_kategori').html(nama_page);
});
function dataCat(id){
  $.ajax({
    type : "POST",
    url  : base_url+"admin/page/cat_list",
    async : false,
    data:{id:id},
    success: function(data){

     tableCat(data);
  
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
function tableCat(data){
  d = JSON.parse(data);
  let no = 1;
  let table = ''
  $.each(d, function(k, v){
   let s = JSON.parse(d[k].sub_category);
   let id_sc = JSON.parse(d[k].sub_cat_id);
           // $.each(d, function(k, v){
        let rowspan = JSON.parse(d[k].sub_category).length;
         

        $.each(s, function(m, l){
          if(s[m] !=null){
            sub_cat = s[m]
          }else{
            sub_cat = '-'
          };

            table+=     `<tr>`;
              if (m==0) {
              table+=   `<td rowspan = "${rowspan}">${no++}</td>`;
              table+=   `<td rowspan = "${rowspan}">${d[k].category}</td>`;
              table+=   `<td rowspan = "${rowspan}"><a href="javascript:void(0);" class="btn btn-success btn-sm tambahSub"  id="${d[k].cat_id}" page_id = "${d[k].page_id}" nama = "${d[k].category}" >Tambah Sub</a> <a href="javascript:void(0);" class="btn btn-warning btn-sm editCat"  id="${d[k].cat_id}" page_id = "${d[k].page_id}" nama = "${d[k].category}">Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteCat"  id="${d[k].cat_id}" page_id = "${d[k].page_id}" nama = "${d[k].category}" >Delete</a>`;

                }
          table+=   `<td >${sub_cat}</td>`;
          if(s[m] !=null){
           table+=   `<td><a href="javascript:void(0);" class="btn btn-warning btn-sm editSubcat" page_id = "${d[k].page_id}" nama = "${sub_cat}"  id="${id_sc[m]}" >Edit</a> <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteSubCat"  page_id = "${d[k].page_id}" nama = "${sub_cat}" id="${id_sc[m]}">Delete</a></td>`;
          }
          table+=   `</tr>`

        })

   })
 $('#isiCat').html(table)
}
$('.tambahKategori').on('click',function(){
  let id = $(this).attr('id'); //id halaman
  let nama = $(this).attr('nama'); //nama halaman
  Swal.fire({
    title: `Tambah kategori pada ${nama} `,
    html: `<input type="text" id="cat" class="swal2-input" placeholder="Kategori">`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const cat = Swal.getPopup().querySelector('#cat').value
      if (!cat) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {cat: cat }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'admin/page/tambah_cat',
      async : false,
      // dataType : "JSON",
      data : {nama:nama,id:id,cat:result.value.cat},
      success: function(data){
        dataCat(id)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Kategori <strong>${result.value.cat}</strong> berhasil ditambahkan pada halaman <strong>${nama}</strong>.`,
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
$('#isiCat').on('click','.editCat',function(){
  let id = $(this).attr('id');
  let page_id = $(this).attr('page_id');
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
      url  : base_url+'/admin/page/update_cat',
      async : false,
      // dataType : "JSON",
      data : {catBefore:nama,id:id,category:result.value.category},
      success: function(data){
        dataCat(page_id);
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
$('#isiCat').on('click','.tambahSub',function(){
  let id = $(this).attr('id');
  let page_id = $(this).attr('page_id');
  let nama = $(this).attr('nama');

  Swal.fire({
    title: `Tambah sub kategori pada ${nama} `,
    html: `<input type="text" id="sub_cat" class="swal2-input" placeholder="Sub Kategori">`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const sub_cat = Swal.getPopup().querySelector('#sub_cat').value
      if (!sub_cat) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {sub_cat: sub_cat }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'admin/page/tambah_subcat',
      async : false,
      // dataType : "JSON",
      data : {page_id:page_id,id:id,sub_cat:result.value.sub_cat},
      success: function(data){
        dataCat(page_id)
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Sub Kategori <strong>${result.value.sub_cat}</strong> berhasil ditambahkan pada kategori <strong>${nama}</strong>.`,
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
  let page_id = $(this).attr('page_id');
  let nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Kategori "+nama+" akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus kategori!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/page/hapus_cat',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          dataCat(page_id)
          Swal.fire(
            'Deleted!',
            'Kategori '+nama+' telah dihapus.',
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
$('#isiCat').on('click','.deleteSubCat',function(){
  let id = $(this).attr('id');
  let page_id = $(this).attr('page_id');
  let nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Sub kategori "+nama+" akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus sub kategori!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/page/hapus_subcat',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          dataCat(page_id)
          Swal.fire(
            'Deleted!',
            'Sub kategori '+nama+' telah dihapus.',
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
// $('#isiCat').on('click','.view_data_menu',function(){
//   let id = $(this).attr('id');

//     $.ajax({
//       type : "POST",
//       url  : base_url+'/admin/page/detail',
//       async : false,
//       dataType : "JSON",
//       data : {id:id},
//       success: function(d){
//         data = d['page']
//         // $('#tabel_serverside').DataTable().ajax.reload();
//         dataCat = d['category']
//         tabelCat = ''
//          $.each(dataCat, function(k, v){
//           tabelCat +=  `<tr><td> ${dataCat[k].category} </td><td> <a href="javascript:void(0);" class="btn btn-info btn-sm showSub" onclick ="showSubTable(${dataCat[k].id})" >lihat sub kategori</a></td></tr>`
//         })
//         Swal.fire({
//   title: `<strong>${data[0].page}</strong>`,
//   icon: 'info',
//     inputAttributes: {
//           id: "tabelInfoHalaman",
//         },
//   html:
//     `<table class="table">
//   <tbody>
//     <tr>
//       <th scope="row">1</th>
//       <td>Link</td>
//       <td><a href = "${base_url+'page/'+data[0].slug}" target="_blank">${base_url+'page/'+data[0].slug}</a></td>
//     </tr>
//     <tr>
//       <th scope="row">2</th>
//       <td>Dibuat</td>
//       <td>${data[0].created_at}</td>
//     </tr>
//     <tr>
//       <th scope="row">3</th>
//       <td>Halaman</td>
//       <td>
//                 <table class="table" border="2" width="100%"  bordercolor="blue">
//                     <tr class="table-info">
//                         <td>Category</td>
//                         <td>Action</td>
//                     </tr>
//                     ${tabelCat}
                   
//                 </table>
//       </td>
    
//     </tr>
//        <tr id = "showSubCat">
//        </tr>
//   </tbody>
// </table>`,
//   showCloseButton: true,
//   // confirmButtonText:
//   //   '<i class="fa fa-thumbs-up"></i> Great!',
// })
//       },
//       error: function(xhr){
//         let d = JSON.parse(xhr.responseText);
//         Swal.fire({
//           icon: 'error',
//           title: 'Oops...',
//           text: `${d.message}`,
//           footer: '<a href="">Why do I have this issue?</a>'
//         })
//       }
//     });
//     });
// function showSubTable(id){
//    $.ajax({
//     type : "POST",
//     url  : base_url+"admin/page/subcat_list",
//     async : false,
//     dataType : "JSON",
//     data:{id:id},
//     success: function(data){
//        kolom = ' <th scope="row" ></th><td>Sub kategori</td><td><table class="table" width="100%"  bordercolor="blue"><tr class="table-info"><td>Sub Kategori</td></tr>'
//       $.each(data, function(k, v){

//        kolom += `<tr><td>${data[k].sub_category}</td></tr>`
//      })
//       kolom += ` </table></td>`
//       if (data.length == 0) {
//       $('#showSubCat').html(`<table class="table" width="100%"  bordercolor="blue"><tr><td colspan="4">Belum ada data</td></tr></table>`)

//       }else{
//       $('#showSubCat').html(kolom)
//       }
//     },
//     error: function(xhr){
//       let d = JSON.parse(xhr.responseText);
//       Swal.fire({
//         icon: 'error',
//         title: 'Oops...',
//         text: `${d.message}`,
//         footer: '<a href="">Why do I have this issue?</a>'
//       })
//     }
//   });

// }

$('#tabel_serverside').on('click','.aktifkanstatus',function(){
  let id = $(this).attr('id');
  let status = 1;
  $.ajax({
    type : "POST",
    url  : base_url+"admin/user/ubah_status_user",
    async : false,
    data:{id:id,status:status},
    success: function(data){
      $('#tabel_serverside').DataTable().ajax.reload();
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
});
$('#tabel_serverside').on('click','.nonaktifkanstatus',function(){
  let id = $(this).attr('id');
  let status = 0;
  $.ajax({
    type : "POST",
    url  : base_url+"admin/user/ubah_status_user",
    async : false,
    data:{id:id,status:status},
    success: function(data){
      $('#tabel_serverside').DataTable().ajax.reload();
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
});
function valueChecked(a){
  if (a == 1) {
    $('#valueChecked').html("Administrator");
  }else if (a == 2) {
    $('#valueChecked').html("Operator");
  }else{
    $('#valueChecked').html("");
  }

}
$('#tabel_serverside').on('click','.editPage',function(){
  let id = $(this).attr('id');
  let nama = $(this).attr('nama');

  Swal.fire({
    title: `Set Nama Halaman `,
    html: `<input type="text" id="page" class="swal2-input" placeholder="nama halaman baru" value= "${nama}">`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const page = Swal.getPopup().querySelector('#page').value
      if (!page) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {page: page }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/page/update_page',
      async : false,
      // dataType : "JSON",
      data : {nama:nama,id:id,page:result.value.page},
      success: function(data){
        $('#tabel_serverside').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Halaman ${nama} berhasil diubah menjadi ${result.value.page}.`,
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
$('#tabel_serverside').on('click','.btn_hapus_menu',function(){
  id = $(this).attr('id');
  nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Halaman "+nama+" akan dihapus!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, hapus halaman!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/page/hapus_page',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          $('#tabel_serverside').DataTable().ajax.reload();
          Swal.fire(
            'Deleted!',
            'Halaman '+nama+' telah dihapus.',
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
$('.tambah_data').on('click',function(){

  Swal.fire({
    title: `Tambah Page `,
    // html: `<input type="text" id="password" class="swal2-input" placeholder="Password baru">`,
    html:`<form id="form_add_data">
    <div class="form-group">
    <label for="page">Nama</label>
    <input type="text" class="form-control" id="page" placeholder="Enter Nama Halaman">
    </div>
    </form>`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const page = Swal.getPopup().querySelector('#page').value
      if (!page) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {page:page}
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/page/tambah_page',
      async : false,
      // dataType : "JSON",
      data : {page:result.value.page},
      success: function(data){
        $('#tabel_serverside').DataTable().ajax.reload();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Halaman berhasil ditambahkan.`,
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
$('.restore_data').on('click',function(){
tableRestoreData()
$('.modal_restore').modal('show')


})

function tableRestoreData(){
$('#tabelRestore').trigger("reset");
let isi = '' 
$.ajax({
    type : "POST",
    url  : base_url+"admin/page/deleted_page",
    async : false,
    dataType : 'json',
    data:{},
    success: function(data){
      let no = 1;
      isi+='<thead>'+
      '<tr>'+
      '<th scope="col" align="center" width="5%">#</th>'+
      '<th scope="col" align="center">Halaman</th>'+
      '<th scope="col" align="center">Action</th>'+
      '</tr>'+
      '</thead>'+
      '<tbody>';
      $.each(data, function(k, v)
      {
        console.log(data[k].page)
        isi +=  '<tr>'+
        '<td scope="row" align="center">'+ no++ +'</td>'+
        '<td align="left">'+data[k].page+'</td>'+
        '<td align="left"><a href="javascript:void(0);" class="btn btn-info btn-sm restore_page"  id="'+data[k].id+'" nama = "'+data[k].page+'"  >Restore</a></td>'+
        '</tr>';

      });
      isi+='</tbody>'

    }
  })
$('#tabelRestore').html(isi)
}
$('#tabelRestore').on('click','.restore_page',function(){
  id = $(this).attr('id');
  nama = $(this).attr('nama');
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "Halaman "+nama+" akan dikembalikan!",
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, restore halaman!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type  : 'post',
        url   : base_url+'/admin/page/restore_page',
        async : false,
        // dataType : 'json',
        data:{id:id, nama:nama},
        success : function(data){
          //reload table
          tableRestoreData()
          $('#tabel_serverside').DataTable().ajax.reload();
          Swal.fire(
            'Restored!',
            'Halaman '+nama+' telah dikembalikan.',
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

$('#isiCat').on('click','.editSubcat',function(){
  let id = $(this).attr('id');
  let page_id = $(this).attr('page_id');
  let nama = $(this).attr('nama');

  Swal.fire({
    title: `Edit kategori ${nama} `,
    html: `<input type="text" id="subCategory" class="swal2-input" placeholder="" value= "${nama}">`,
    confirmButtonText: 'Confirm',
    focusConfirm: false,
    preConfirm: () => {
      const subCategory = Swal.getPopup().querySelector('#subCategory').value
      if (!subCategory) {
        Swal.showValidationMessage('Silakan lengkapi data')
      }
      return {subCategory: subCategory }
    }
  }).then((result) => {
    $.ajax({
      type : "POST",
      url  : base_url+'/admin/page/update_subcat',
      async : false,
      // dataType : "JSON",
      data : {catBefore:nama,id:id,subCategory:result.value.subCategory},
      success: function(data){
        dataCat(page_id);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: `Kategori ${nama} berhasil diubah menjadi ${result.value.subCategory}.`,
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