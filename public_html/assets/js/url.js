function getBreadCrumb() {
let loc = window.location;
let base_url = loc.protocol + "//" + loc.hostname + (loc.port? ":"+loc.port : "");
array = window.location.pathname.split("/")
array[0] = base_url;
breadCrumb = '';
link = '';
array.forEach(function(v,k){
    if (array.length -1 == k) {
    link += array[k]
      breadCrumb +=  `<li class="breadcrumb-item active" aria-current="page"><a href="${link}" style="color:black;">${capitalize(array[k])}</a></li>`
    }else{
        link += array[k] +'/'

        if (k == 0) {
        // breadCrumb +=`<li class="breadcrumb-item"><a href="${link}">Dashboard</a></li>`;
        }else{
        breadCrumb +=`<li class="breadcrumb-item"><a href="${link}">${capitalize(array[k])}</a></li>`;
        }
    }
 // 

 })
return breadCrumb;

}
function capitalize(string) {
    a =  string.split('-').join(' ')
    b =  a.split('_').join(' ')
    return b.charAt(0).toUpperCase() + b.slice(1);
}
document.getElementById("breadcrumb").innerHTML += getBreadCrumb();