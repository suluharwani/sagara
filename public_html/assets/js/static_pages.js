var loc = window.location;
var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";
tabel();
function tabel(){
  $.ajax({
    type : "GET",
    url  : base_url+"admin/static_page",
    async : false,
    // data:{page:page, data:data, param:param},
    success: function(data){
       d = JSON.parse(data);
        let no = 1;
        let table = ''
        let status = ''
        let button = ''
  $.each(d, function(k, v){
      if (d[k].status == 1) {
        status = `<p class="text-success">ACTIVE</p>`
        button = `<a href="javascript:void(0);" class="btn btn-primary btn-sm manage" slug="${d[k].slug}" id="${d[k].id}"  >Manage</a> <a href="javascript:void(0);" class="btn btn-warning btn-sm ubahstatus" status = "${d[k].status}" id="${d[k].id}"  >Nonaktifkan</a>`
      }else{
        status = `<p class="text-danger">NON ACTIVE</p>`
        button = `<a href="javascript:void(0);" class="btn btn-primary btn-sm manage" slug="${d[k].slug}"   id="${d[k].id}"  >Manage</a> <a href="javascript:void(0);" class="btn btn-success btn-sm ubahstatus" status = "${d[k].status}" id="${d[k].id}"  >Aktifkan</a>`
      }
      table += `<tr><th style = "text-align: center">${no++}</th><th>${d[k].page}</th><th  style = "text-align: center">${status}</th><th  style = "text-align: center">${button}</th></tr>`
     
    })
   $('#tabel').html(table);
    }
  });
};
// data()
$('#tabel').on('click','.ubahstatus',function(){
  let id = $(this).attr('id');
  let status = $(this).attr('status');
  $.ajax({
    type : "POST",
    url  : base_url+"admin/static/ubah_status",
    async : false,
    data:{status,id},
    success: function(data){
    tabel();
  
    }
  });
})
$('#tabel').on('click','.manage',function(){
  let slug = $(this).attr('slug');
  window.location.href = base_url+"admin/manage/static_pages/"+slug
})
