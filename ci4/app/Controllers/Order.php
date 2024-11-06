<?php
 
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use AllowDynamicProperties; 
use Bcrypt\Bcrypt;
use google\apiclient;

class Order extends BaseController
{
      protected $bcrypt;
  protected $userValidation;
  protected $bcrypt_version;
  protected $session;
  protected $db;
  protected $uri;
  protected $form_validation;
  protected $changelog;

  public function __construct()
  {
  //   parent::__construct();
    $this->db      = \Config\Database::connect();
    $this->session = session();
    $this->bcrypt = new Bcrypt();
    $this->bcrypt_version = '2a';
    $this->uri = service('uri');
    helper('form');
    $this->form_validation = \Config\Services::validation();
    $this->userValidation = new \App\Controllers\LoginValidation();
    $this->changelog = new \App\Controllers\Changelog();

    //if sesion habis

    $check = new \App\Controllers\CheckAccess();
    $check->logged();  
  }
    function access($page){
    $check = new \App\Controllers\CheckAccess();
    $check->access($_SESSION['auth']['id'],$page);
  }

    public function index()
    {
        $this->access('administrator');
          $data['content']=view('admin/content/order');
    return view('admin/index', $data);
    }

          public function getOrder()
      {
          $this->access('operator');
          $serverside_model = new \App\Models\MdlDatatableJoin();
          $request = \Config\Services::request();
          
          // Define the columns to select
          $select_columns = 'order.*, order.kode as kode, order.id_client as id_client, order.deadline as deadline, order.id_order_list as id_order_list, order.status as status, order.updated_at as updated_at, order.deleted_at as deleted_at, order.link as link, order.created_at as created_at, client.nama_depan as nama_depan, client.nama_belakang as nama_belakang';
          
          // Define the joins (you can add more joins as needed)
          $joins = [
              ['client', 'order.id_client = client.id', 'left'],


          ];
  
          $where = ['order.id !=' => 0, 'order.deleted_at' => NULL];
  
          // Column Order Must Match Header Columns in View
          $column_order = array(NULL,'order.kode','order.id_client','order.deadline','order.link','order.status'
          );
          $column_search = array(
              'order.kode', 
              'client.nama_depan', 
              'client.nama_belakang', 
          );
          $order = array('order.id' => 'desc');
  
          // Call the method to get data with dynamic joins and select fields
          $list = $serverside_model->get_datatables('order', $select_columns, $joins, $column_order, $column_search, $order, $where);
          
          $data = array();
          $no = $request->getPost("start");
          foreach ($list as $lists) {
              $no++;
          $row    = array();
          $row[] = $no;
          $row[] = $lists->id;
          $row[] = $lists->kode;
          $row[] = $lists->id_client;
          $row[] = $lists->deadline;
          $row[] = $lists->id_order_list;
          $row[] = $lists->status;
          $row[] = $lists->link;
          $row[] = $lists->created_at;
          $row[] = $lists->deleted_at;
          $row[] = $lists->nama_depan;
          $row[] = $lists->nama_belakang;

              $data[] = $row;
          }
  
          $output = array(
              "draw" => $request->getPost("draw"),
              "recordsTotal" => $serverside_model->count_all('order', $where),
              "recordsFiltered" => $serverside_model->count_filtered('order', $select_columns, $joins, $column_order, $column_search, $order, $where),
              "data" => $data,
          );
  
        //   return $this->response->setJSON($output);
        
          return json_encode($output);
      }

public function tambahOrder()
{
    $userInfo = $_SESSION['auth'];
    $orderModel = new \App\Models\MdlOrder();

    // Validasi input
    $validation = \Config\Services::validation();
    $validation->setRules([
        'id_client' => 'required|integer',
        'deadline' => 'required|valid_date',
        'nama_tim' => 'required|string|max_length[100]',
        'brand' => 'required|string|max_length[100]',
        'logo_tim' => 'if_exist|is_image[logo_tim]|max_size[logo_tim,2048]|mime_in[logo_tim,image/jpg,image/jpeg,image/png]', // Logo opsional
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->fail($validation->getErrors());
    }

    // Proses upload logo tim jika ada
    $logoTim = $this->request->getFile('logo_tim');
    $logoPath = '';
    if ($logoTim && $logoTim->isValid() && !$logoTim->hasMoved()) {
        // Tentukan direktori penyimpanan baru
        $uploadPath = FCPATH . 'assets/logotim/';

        // Cek jika folder tidak ada, buat folder
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Pindahkan file dengan nama acak
        $logoPath = $logoTim->getRandomName();
        $logoTim->move($uploadPath, $logoPath);
        $logoPath = 'assets/logotim/' . $logoPath; // Path untuk disimpan di database
    }

    // Data order yang akan disimpan
    $data = [
        'kode'       => $this->request->getPost('kode'),
        'id_client'  => $this->request->getPost('id_client'),
        'deadline'   => $this->request->getPost('deadline'),
        'nama_tim'   => $this->request->getPost('nama_tim'),
        'brand'      => $this->request->getPost('brand'),
        'logo_tim'  => $logoPath, // Menyimpan path logo jika ada
        'link'       => base_url('order/' . $this->request->getPost('kode')), // Link otomatis berdasarkan kode
    ];

    // Simpan data ke database
    if ($orderModel->insert($data)) {
        $riwayat = "User " . $userInfo['nama_depan'] . " " . $userInfo['nama_belakang'] . " menambahkan order: " . $data['kode'];
        header('HTTP/1.1 200 OK');
        return $this->response->setJSON(['message' => 'Order berhasil ditambahkan.', 'riwayat' => $riwayat]);
    } else {
        $riwayat = "User " . $userInfo['nama_depan'] . " gagal menambahkan order: " . $data['kode'];
        return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal menambahkan data']);
    }
}


public function ubahStatus()
    {
        // Ambil data dari permintaan
        $orderId = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        // Periksa apakah data valid
        if (!$orderId || !$status) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Data tidak valid']);
        }

        // Ambil model order dan ubah statusnya
        $orderModel =new \App\Models\MdlOrder();
        $orderModel->update($orderId, ['status' => $status]);

        // Berikan respons sukses
        return $this->response->setJSON(['message' => 'Status berhasil diubah']);
    }


    public function deleteOrder()
    {
        // Ambil ID order dari permintaan
        $orderId = $this->request->getPost('id');

        // Pastikan ID valid
        if (!$orderId) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'ID tidak valid']);
        }

        // Inisialisasi model
        $orderModel = new \App\Models\MdlOrder();

        // Coba hapus order dari database
        if ($orderModel->delete($orderId)) {
            return $this->response->setJSON(['message' => 'Order berhasil dihapus']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal menghapus order']);
        }
    }

    public function addPayment()
    {
        $paymentModel = new \App\Models\MdlPayment();
        $data = $this->request->getPost();

        if ($paymentModel->insert($data)) {
            return $this->response->setJSON(['message' => 'Pembayaran berhasil ditambahkan']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal menambahkan pembayaran']);
        }
    }

    // Mengambil riwayat pembayaran berdasarkan id_order
    public function paymentHistory()
    {
        $orderId = $this->request->getGet('id_order');
        $paymentModel = new \App\Models\MdlPayment();

        $payments = $paymentModel->where('id_order', $orderId)->findAll();

        return $this->response->setJSON(['payments' => $payments]);
    }

    // Menghapus pembayaran berdasarkan id
    public function deletePayment()
    {
        $paymentId = $this->request->getPost('id');
        $paymentModel = new \App\Models\MdlPayment();

        if ($paymentModel->delete($paymentId)) {
            return $this->response->setJSON(['message' => 'Pembayaran berhasil dihapus']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal menghapus pembayaran']);
        }
    }
public function getProducts()
{
    $productModel = new \App\Models\MdlProduct();

    $products = $productModel->findAll();

    return $this->response->setJSON(['products' => $products]);
}
public function saveOrderProducts()
{
    $orderId = $this->request->getPost('id_order');
    $orderData = $this->request->getPost('order_data');
    $orderListModel = new \App\Models\MdlOrderList();

    // Simpan setiap produk yang dipilih ke tabel order_list
    for ($i = 0; $i < count($orderData['id_product']); $i++) {
        $data = [
            'id_order'   => $orderId,
            'id_product' => $orderData['id_product'][$i],
            'price'      => $orderData['price'][$i],  // Menyimpan harga manual
            'status'     => 1
        ];

        $orderListModel->insert($data);
    }

    return $this->response->setJSON(['message' => 'Produk berhasil ditambahkan ke order']);
}

 public function orderDetail($orderId)
    {
        $orderModel = new \App\Models\MdlOrder();
        
        // Ambil detail order beserta produk yang ditambahkan
        $orderDetails = $orderModel->getOrderDetailById($orderId);

        // Kirim data ke view
        return view('admin/content/order_detail', [
            'orderDetails' => $orderDetails
        ]);
    }

  public function deleteProduct()
    {
        $productId = $this->request->getPost('id'); // Ambil ID produk dari permintaan POST

        $orderListModel = new \App\Models\MdlOrderList();

        // Coba hapus produk dari tabel order_list
        if ($orderListModel->delete($productId)) {
            return $this->response->setJSON(['message' => 'Produk berhasil dihapus']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Gagal menghapus produk']);
        }
    }




}

