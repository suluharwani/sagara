<?php

namespace App\Controllers;

class Home extends BaseController
{
    //   public function index()
    // {
    //     return view('welcome_message');
    // }
    public function index()
    {
        $data['content']=view('home/content/homepage');
        return view('home/index', $data);
    }
  function menu(){
      $model = new \App\Models\MdlPages();
      $where = ['id !=' => 0, 'deleted_at'=>NULL];
      return json_encode($model->where($where)->get()->getResult());
    }
  function menu_cat(){
      $model = new \App\Models\MdlCategory();
      $page_id = $_POST['page_id'];
      return json_encode($model->select('id, category')->where('page_id',$page_id)->get()->getResult());
    }
  function menu_sub_cat(){
      $model = new \App\Models\MdlSubCategory();
      $category_id = $_POST['category_id'];
      return json_encode($model->select('sub_category')->where('category_id',$category_id)->get()->getResult());
    }
  function page($page=null, $slug1=null, $slug2=null, $slug3=null, $slug4=null){
    
      if ($page == null) {
        //list menu
       $data['content']=view('home/content/page_default');
      }else{
        //content
       $data['content']=view('home/content/single_page');
      }
        return view('home/index', $data);
    }
  function get_menu_array(){
      $pages = new \App\Models\MdlPages();
      $pages->select('page.id as page_id, page.page as page, page.slug as page_slug, category.id as category_id, category.slug as category_slug');
      $pages->join('category', 'category.id = page.id');
       return json_encode($pages->get()->getResultArray());
  }
  function getContactUs(){
      $data = new \App\Models\MdlContactUs();
      $data->where(array('status' =>1 ,'deleted_at'=>null ));
      return json_encode($data->get()->getResultArray());
  }
  function getSlider(){
      $data = new \App\Models\MdlSlider();
      $data->where(array('status' =>1 ,'deleted_at'=>null ));
      return json_encode($data->get()->getResultArray());
  }
  function getService(){
      $data = new \App\Models\MdlService();
      $data->where(array('status' =>1 ,'deleted_at'=>null ));
      return json_encode($data->get()->getResultArray());
  }
  function getPortfolio(){
      $data = new \App\Models\MdlPortfolio();
      $data->where(array('status' =>1 ,'deleted_at'=>null ));
      return json_encode($data->get()->getResultArray());
  }
  function getTestimonial(){
      $data = new \App\Models\MdlTestimonial();
      $data->where(array('status' =>1 ,'deleted_at'=>null ));
      return json_encode($data->get()->getResultArray());
  }
  function getPartner(){
      $data = new \App\Models\MdlPartner();
      $data->where(array('status' =>1 ,'deleted_at'=>null ));
      return json_encode($data->get()->getResultArray());
  }
  function getOffer(){
      $data = new \App\Models\MdlOffer();
      $data->where(array('status' =>1 ,'deleted_at'=>null ));
      return json_encode($data->get()->getResultArray());
  }
  function getGroupProduct(){
      $mdl = new \App\Models\MdlProductGroup();
      $data = $mdl->where('deleted_at',null)->get()->getResult();
      return json_encode($data);
  }
    public function client($orderId){
     { 
        $orderModel = new \App\Models\MdlOrderTable();
        $Mdl = new \App\Models\MdlOrder();
        $MdlSize = new \App\Models\MdlSize();

        
        // Ambil data order yang terkait dengan orderId
       // $orders = $orderModel->getOrdersWithParent($orderId);
        $orders = $orderModel->select('ordertable.id as id,ordertable.id_order,ordertable.id_product,ordertable.id_size,ordertable.nama,ordertable.ukuran,ordertable.nomor_punggung,ordertable.keterangan, product.judul,product.id_group,product.nama as nama_produk,product.picture,product.slug,product.text,order_list.price')
        ->join('product','product.id = ordertable.id_product')
        ->join('order_list','product.id = order_list.id_product')
                    ->where('ordertable.id_order',$orderId)
                    ->findAll();
        // var_dump($orders);
        // die();
        $pesanan = $Mdl->where('kode',$orderId)->find();
        $ukuran = $MdlSize->findAll();
        $orderDetail = $Mdl->getOrderDetail($orderId);

        return view('admin/content/order_form', ['ukuran'=>$ukuran,'orderDetail' => $orderDetail,'orders' => $orders, 'id_order' => $orderId, 'pesanan'=>$pesanan[0]]);
  }
}
    public function save()
    {
        $orderModel = new \App\Models\MdlOrderTable();

        $data = [
            'id_order'      => $this->request->getPost('id_order'),
            'nama'          => $this->request->getPost('nama'),
            'ukuran'        => $this->getSize($this->request->getPost('size')),
            'id_product'        => $this->request->getPost('product'),
            'id_size'        => $this->request->getPost('size'),
            'nomor_punggung' => $this->request->getPost('nomor_punggung'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ];
        // var_dump($data);
        // die();
        $orderModel->insert($data);

        return redirect()->to('/order/' . $this->request->getPost('id_order'));
    }
        public function showLogo($filename)
{
    $path = WRITEPATH . 'uploads/logo_tim/' . $filename;
    if (file_exists($path)) {
        header('Content-Type: ' . mime_content_type($path));
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    } else {
        // Jika file tidak ditemukan, tampilkan gambar default
        header("Content-Type: image/png");
        readfile(FCPATH . 'images/default-logo.png'); // Tempatkan gambar default di public/images
        exit;
    }
}

   function getSize($id){
         $MdlSize = new \App\Models\MdlSize();
         $ukuran = $MdlSize->where('id',$id)->find();
         $size = $ukuran[0]['kategori']."-".$ukuran[0]['ukuran'];
         return $size;
    }
      public function deleteListOrder()
    {
       $orderId = $this->request->getPost('order_id');

        // Memastikan hanya menerima request POST
        if ($_POST['hapus'] == 'hapus') {
            // Ambil order_id dari form
            $orderId = $this->request->getPost('order_id');

            // Pastikan order_id ada
            if ($orderId) {
                // Load model Order
                $orderModel = new \App\Models\MdlOrderTable();

                // Cek apakah pesanan dengan ID tersebut ada
                $order = $orderModel->where('id',$orderId)->delete();
                
                if ($order) {
                    // Hapus pesanan
                    if ($orderModel->delete($orderId)) {
                        // Set pesan sukses
                        session()->setFlashdata('success', 'Pesanan berhasil dihapus.');
                    } else {
                        // Set pesan error jika gagal menghapus
                        session()->setFlashdata('error', 'Gagal menghapus pesanan.');
                    }
                } else {
                    // Set pesan error jika pesanan tidak ditemukan
                    session()->setFlashdata('error', 'Pesanan tidak ditemukan.');
                }
            } else {
                // Set pesan error jika order_id tidak valid
                session()->setFlashdata('error', 'ID Pesanan tidak valid.');
            }
        }

        // Redirect kembali ke halaman sebelumnya
        return redirect()->to('/order/' . $this->request->getPost('id_order'));
    }
        public function print($orderId)
    {
        $orderModel = new \App\Models\MdlOrder();
        $orderTableModel = new \App\Models\MdlOrderTable();

        // Fetch order details
        $order = $orderModel->getOrderWithPlayers($orderId);
        $orderDetail =$orderModel->getOrderDetailByCode($orderId);
        // Fetch player list for this order
        $players = $orderTableModel->getPlayersByOrderId($orderId);
        // var_dump($orderDetail);
        // die();

        return view('home/content/print', [
            'order' => $order,
            'players' => $players,
            'orderDetail'=> $orderDetail
        ]);
    }

}
 