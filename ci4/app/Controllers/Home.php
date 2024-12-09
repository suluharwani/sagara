<?php

namespace App\Controllers;
use App\Models\MdlSize;
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
        $orders = $orderModel->select('ordertable.id as id,ordertable.id_order,ordertable.id_product,ordertable.id_size,ordertable.nama,ordertable.ukuran,ordertable.nomor_punggung,ordertable.keterangan, product.judul,product.id_group,product.nama as nama_produk,product.picture,product.slug,product.text,order_list.price, order.status as status_pembayaran')
        ->join('product','product.id = ordertable.id_product')
        ->join('order_list','product.id = order_list.id_product')
        ->join('order','order.id = order_list.id_order')
                    ->where('order.kode',$orderId)
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
            'nama'          => strtoupper($this->request->getPost('nama')),
            'ukuran'        => $this->getSize($this->request->getPost('size')),
            'id_product'        => $this->request->getPost('product'),
            'id_size'        => $this->request->getPost('size'),
            'nomor_punggung' => strtoupper($this->request->getPost('nomor_punggung')),
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
    // Load models
    $orderModel = new \App\Models\MdlOrder();
    $orderTableModel = new \App\Models\MdlOrderTable();
    $mdlSize = new MdlSize();
    
    // Fetch sizes from the database
    $sizes = $mdlSize->findAll();
    
    // Initialize the combined size summary array
    $sizeSummary = [];

    // Initialize size categories and counts
    foreach ($sizes as $size) {
        $category = $size['kategori'];
        $sizeValue = $size['ukuran'];

        // Initialize size summary for each product and category
        if (!isset($sizeSummary[$category])) {
            $sizeSummary[$category] = [];
        }

        if (!isset($sizeSummary[$category][$sizeValue])) {
            $sizeSummary[$category][$sizeValue] = [
                'total' => 0,
                'products' => []
            ];
        }
    }
 
    // Fetch order details
    $order = $orderModel->getOrderWithPlayers($orderId);
    $orderDetail = $orderModel->getOrderDetailByCode($orderId); // Order details by product

    // Fetch player list for this order
    $players = $orderTableModel->getPlayersByOrderId($orderId);

    // Process player data and aggregate size information
    // var_dump($players);
    // die();
    foreach ($players as $player) {
        $category = $player['size_category'];
        $size = $player['size_value'];
        $productId = $player['product_id'];
        $productName = $player['nama_product'];

        // Update size summary for category and size value
        if (isset($sizeSummary[$category][$size])) {
            // Increase the total count for the given category and size
            $sizeSummary[$category][$size]['total']++;

            // Update the product-specific size count
            if (!isset($sizeSummary[$category][$size]['products'][$productId])) {
                $sizeSummary[$category][$size]['products'][$productId] = [
                    'nama_product' => $productName,
                    'count' => 0
                ];
            }

            $sizeSummary[$category][$size]['products'][$productId]['count']++;
        }
    }

    // Calculate the total price
    $totalPrice = array_sum(array_column($players, 'price'));

    // Pass data to the view
    return view('home/content/print', [
        'order' => $order,
        'players' => $players,
        'orderDetail' => $orderDetail,
        'sizeSummary' => $sizeSummary, // Send combined size summary
        'totalPrice' => $totalPrice
    ]);
}
public function exportExcel($orderId)
{
    // Load models
    $orderModel = new \App\Models\MdlOrder();
    $orderTableModel = new \App\Models\MdlOrderTable();
    $mdlSize = new \App\Models\MdlSize();

    // Fetch sizes from the database
    $sizes = $mdlSize->findAll();
    $sizeSummary = [];

    foreach ($sizes as $size) {
        $category = $size['kategori'];
        $sizeValue = $size['ukuran'];
        $sizeSummary[$category][$sizeValue] = [
            'total' => 0,
            'products' => []
        ];
    }

    // Fetch order details
    $order = $orderModel->getOrderWithPlayers($orderId);

    $orderDetail = $orderModel->getOrderDetailByCode($orderId);
    $players = $orderTableModel->getPlayersByOrderId($orderId);

    foreach ($players as $player) {
        $category = $player['size_category'];
        $size = $player['size_value'];
        $productId = $player['product_id'];
        $productName = $player['nama_product'];

        if (isset($sizeSummary[$category][$size])) {
            $sizeSummary[$category][$size]['total']++;
            if (!isset($sizeSummary[$category][$size]['products'][$productId])) {
                $sizeSummary[$category][$size]['products'][$productId] = [
                    'nama_product' => $productName,
                    'count' => 0
                ];
            }
            $sizeSummary[$category][$size]['products'][$productId]['count']++;
        }
    }

    $totalPrice = array_sum(array_column($players, 'price'));

    // Generate Excel
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Order Overview');

    // Header
    $sheet->setCellValue('A1', "Order kode: {$orderId}");
    $sheet->mergeCells('A1:E1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

    $sheet->setCellValue('A3', 'Tanggal:');
    $sheet->setCellValue('B3', $order['created_at']);
    $sheet->setCellValue('A4', 'Team:');
    $sheet->setCellValue('B4', $order['nama_tim']);

    // Produk
    $sheet->setCellValue('A6', 'No');
    $sheet->setCellValue('B6', 'Nama Produk');
    // $sheet->setCellValue('C6', 'Harga');
    $sheet->setCellValue('D6', 'Gambar');

    $row = 7;
    foreach ($orderDetail as $index => $detail) {
        $sheet->setCellValue("A{$row}", $index + 1);
        $sheet->setCellValue("B{$row}", $detail['nama_product']);
        // $sheet->setCellValue("C{$row}", $detail['price']);

        // Add image
        $imagePath = FCPATH . 'assets/upload/image/' . $detail['picture'];
        if (file_exists($imagePath)) {
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setPath($imagePath);
            $drawing->setCoordinates("D{$row}");
            $drawing->setHeight(50);
            $drawing->setWorksheet($sheet);
        }
        $row++;
    }

    // Player List
    $sheet->setCellValue("A{$row}", 'Player List');
    $sheet->mergeCells("A{$row}:E{$row}");
    $sheet->getStyle("A{$row}")->getFont()->setBold(true);
    $row++;

    $sheet->setCellValue("A{$row}", 'Role');
    $sheet->setCellValue("B{$row}", 'Size');
    $sheet->setCellValue("C{$row}", 'Nama Punggung');
    $sheet->setCellValue("D{$row}", 'Nomor Punggung');
    $sheet->setCellValue("E{$row}", 'Jersey');
    // $sheet->setCellValue("F{$row}", 'Harga');
    $row++;

    foreach ($players as $player) {
        $sheet->setCellValue("A{$row}", ucfirst($player['keterangan']));
        $sheet->setCellValue("B{$row}", $player['ukuran']);
        $sheet->setCellValue("C{$row}", strtoupper($player['nama_player']));
        $sheet->setCellValue("D{$row}", $player['nomor_punggung']);
        $sheet->setCellValue("E{$row}", $player['nama_product']);
        // $sheet->setCellValue("F{$row}", $player['price']);
        $row++;
    }

    // Total
    $sheet->setCellValue("E{$row}", 'Total:');
    // $sheet->setCellValue("F{$row}", $totalPrice);

    // Save and Download
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$order['nama_tim'].'-'.$orderId.'.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}





}