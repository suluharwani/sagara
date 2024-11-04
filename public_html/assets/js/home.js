// var loc = window.location;
// var base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "") + "/";

(()=>{ 
$.ajax({
    type : "POST",
    url  : base_url+"home/getSlider",
    async : false,
    success: function(data){
     d = JSON.parse(data);
     view = ''
     urutan = 0
     $.each(d, function(k, v){
     if (((urutan++) % 2) == 0) {
     view += `<li data-transition="slidingoverlayhorizontal" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default" data-rotate="0" data-saveperformance="off">
					<img src="${base_url}assets/upload/1000/${d[k].picture}" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">

					<div class="tp-caption layer-border-1" data-x="center" data-y="center" data-width="['780','780','650','500']" data-height="200" data-start="1900" data-transform_in="opacity:0;s:500;" data-transform_out="opacity:0;s:500;"></div>

					<div class="tp-caption text-color-dark font-primary font-weight-bold" data-frames='[{"from":"y:[-50%];opacity:0;","speed":1500,"to":"o:1;","delay":1100,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"x:left(R);","ease":"Power3.easeIn"}]' data-x="center" data-hoffset="['-225','-225','-172','-120']" data-y="center" data-voffset="['-30','-30','-30','-30']" data-fontsize="['23','23','23','23']">${d[k].text}</div>

					<div class="tp-caption text-color-dark font-primary font-weight-bold" data-frames='[{"from":"y:[-50%];opacity:0;","speed":1500,"to":"o:1;","delay":1100,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"x:left(R);","ease":"Power3.easeIn"}]' data-x="center" data-y="center" data-voffset="['20','20','20','20']" data-fontsize="['40','40','30','20']"  data-lineheight="['65','65','55','45']" data-mask_in="x:0px;y:0px;">${d[k].judul}</div>

					<div class="tp-caption text-color-primary layer-bg-color-1 font-quaternary" data-frames='[{"from":"y:[-50%];opacity:0;","speed":1500,"to":"o:1;","delay":1100,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"x:left(R);","ease":"Power3.easeIn"}]' data-x="center" data-hoffset="['190','190','158','130']" data-y="center" data-voffset="['95','95','95','95']" data-fontsize="['45','45','37','27']" data-paddingtop="0" data-paddingbottom="0" data-paddingleft="16" data-paddingright="16">${d[k].text_footer}</div>

				</li>`
			}else{
      view += `<li data-transition="slidingoverlayhorizontal" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default" data-rotate="0" data-saveperformance="off">
					<img src="${base_url}assets/upload/1000/${d[k].picture}" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg">

					<div class="tp-caption text-color-primary font-primary font-weight-bold" data-frames='[{"from":"y:[-50%];opacity:0;","speed":1500,"to":"o:1;","delay":1100,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"x:left(R);","ease":"Power3.easeIn"}]' data-x="['52','2','2','22']" data-y="center" data-voffset="['-50','-50','-50','-50']" data-fontsize="['23','23','23','23']">${d[k].text}</div>

					<h1 class="tp-caption text-color-dark font-weight-bold" data-frames='[{"from":"y:[-20%];opacity:0;","speed":1500,"to":"o:1;","delay":1200,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"x:left(R);","ease":"Power3.easeIn"}]' data-x="['50','0','0','20']" data-y="center" data-fontsize="['40','40','30','20']" data-lineheight="['65','65','55','45']">${d[k].judul}</h1>

					<div class="tp-caption text-color-dark font-weight-light font-primary" data-frames='[{"from":"y:[-50%];opacity:0;","speed":1500,"to":"o:1;","delay":1300,"ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"to":"x:left(R);","ease":"Power3.easeIn"}]' data-x="['338','338','225','22']" data-y="center" data-voffset="['60','60','60','50']" data-fontsize="['28','28','28','28']">${d[k].text_footer}</div>

				</li>`
			}
    })
     $('.sliderView').html(view);
   }
 });

})();

(() => {
	try {
  $.ajax({
    type: "POST",
    url: base_url + "home/getGroupProduct",
    async: false,
    success: function (data) {
      let d = JSON.parse(data);
      let view = '<li class="nav-item" data-option-value="*"><a href="#" class="nav-link active">SHOW ALL</a></li>';
      $.each(d, function (k, v) {
        view += `<li class="nav-item" data-option-value=".brands"><a class="nav-link text-uppercase" href="#">${d[k].group}</a></li>`;
      });
      $('.groupProductList').html(view);
    }
  });
}catch (error) {
    console.error('Error occurred:', error);
  }
})();