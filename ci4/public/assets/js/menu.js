let loc = window.location;
let base_url =
  loc.protocol + "//" + loc.hostname + (loc.port ? ":" + loc.port : "") + "/";

list_menu();
function list_menu() {
  $.ajax({
    type: "POST",
    url: base_url + `home/menu`,
    async: false,
    dataType: "json",
    data: {},
    success: function (data) {
      let menu = `<li class="order-1 dropdown dropdown-mega">
                        <a class="dropdown-item dropdown-toggle active" href="${base_url}layanan">
                            Layanan
                        </a>           
                    </li>
                    <li class="order-1 dropdown dropdown-mega">
                        <a class="dropdown-item dropdown-toggle active" href="${base_url}tentang-kami">
                            Tentang Kami
                        </a>           
                    </li>`;
      no = 2;
      $.each(data, function (k, v) {
        menu += `<li class="order-${no++} " >`;
        menu += `<a class="dropdown-item dropdown-toggle active" href="${
          base_url + "page/" + data[k].slug
        }">
					${data[k].page}
					</a>
                        <ul class="dropdown-menu">
            <li>
                <div class="dropdown-mega-content container">
                    <div class="row">`;
        menu += `</div>
                </div>
            </li>
        </ul>
`;
      });
      menu += `</li>`;
      $("#mainNav").html(menu);
    },
  });
}
