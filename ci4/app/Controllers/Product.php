<?php
namespace App\Controllers;
use AllowDynamicProperties; 
use CodeIgniter\Controller;
use Bcrypt\Bcrypt;
use google\apiclient;
class Product extends BaseController
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
  public function index()
  {
      $this->access('operator');
    $data['content']=view('admin/content/product');
    return view('admin/index', $data);
  }
  public function manage(){
    
  }
  // function logoutAdmin(){
  //     return "adad";
  // }
  function access($page){
    $check = new \App\Controllers\CheckAccess();
    $check->access($_SESSION['auth']['id'],$page);
  }
  public function listdataProductCat(){
  $this->access('operator');
  $serverside_model = new \App\Models\Mdl_datatables();
  $request = \Config\Services::request();
  $list_data = $serverside_model;
  $where = ['id !=' => 0, 'deleted_at'=>NULL];
          //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
          //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
  $column_order = array(NULL,'product_group.group','product_group.id');
  $column_search = array('product_group.group');
  $order = array('product_group.id' => 'desc');
  $list = $list_data->get_datatables('product_group', $column_order, $column_search, $order, $where);
  $data = array();
  $no = $request->getPost("start");
  foreach ($list as $lists) {
    $no++;
    $row    = array();
    $row[] = $no;
    $row[] = $lists->id;
    $row[] = $lists->group;
    $data[] = $row;
}
$output = array(
    "draw" => $request->getPost("draw"),
    "recordsTotal" => $list_data->count_all('product_group', $where),
    "recordsFiltered" => $list_data->count_filtered('product_group', $column_order, $column_search, $order, $where),
    "data" => $data,
);

return json_encode($output);
}
  public function listdataProduct(){
  $this->access('operator');
  $serverside_model = new \App\Models\Mdl_datatables();
  $request = \Config\Services::request();
  $list_data = $serverside_model;
  $where = ['id !=' => 0, 'deleted_at'=>NULL];
          //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
          //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
  $column_order = array(NULL,'product.nama','product.status','product.id');
  $column_search = array('product.nama','product.judul');
  $order = array('product.id' => 'desc');
  $list = $list_data->get_datatables('product', $column_order, $column_search, $order, $where);
  $data = array();
  $no = $request->getPost("start");
  foreach ($list as $lists) {
    $no++;
    $row    = array();
    $row[] = $no;
    $row[] = $lists->id;
    $row[] = $lists->nama;
    $row[] = $lists->status;
    $data[] = $row;
}
$output = array(
    "draw" => $request->getPost("draw"),
    "recordsTotal" => $list_data->count_all('product', $where),
    "recordsFiltered" => $list_data->count_filtered('product', $column_order, $column_search, $order, $where),
    "data" => $data,
);

return json_encode($output);
}
  function tambah_group(){
      $this->access('operator');
      $userInfo = $_SESSION['auth'];
      $userModel = new \App\Models\MdlProductGroup();
      $userdata = [
        "group" =>  $_POST["group"],

      ];
      if ($userModel->insert($userdata)) {
        $riwayat = "User ".$userInfo['nama_depan']." ".$userInfo['nama_depan']." menambahkan group: ".$_POST['group']."Untuk produk";
        header('HTTP/1.1 200 OK');
      }else{
        $riwayat = "User ".$userInfo['name']." gagal menambahkan user: ".$_POST['group'];
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'User exist, gagal menambahkan data.', 'code' => 3)));
      }
      $this->changelog->riwayat($riwayat);
    
  }
  function select_group(){
  $this->access('operator');
  $mdl = new \App\Models\MdlProductGroup();
  $data = $mdl->where('deleted_at',null)->get()->getResult();
  return json_encode($data);
}
  function deleted_group(){
  $this->access('operator');
  $mdl = new \App\Models\MdlProductGroup();
  $data = $mdl->where('deleted_at!=',null)->get()->getResult();
  return json_encode($data);
}

function upload(){
  $mdl = new \App\Models\MdlProduct();
  helper(['form', 'url']);

    $validateImage =  $this->form_validation->setRules([
      'file' => [
        'label'  => 'File',
        'rules'  => 'max_size[file, 40960000]|mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
        'errors' => [
          'max_size' => 'Ukuran terlalu besar',
          'mime_in' => 'Extensi harus jpg/jpeg/gif/png ',
        ],
      ],
    ]);
      // exit();
    if ($validateImage->withRequest($this->request)->run()) {
      $imageFile = $this->request->getFile('file');

      $fileName = $imageFile->getRandomName();
      $filepath =  FCPATH .'assets/upload/image';
          // manipulatoin
      $image = \Config\Services::image();
          //thumbnail
      $image->withFile($imageFile)
      ->resize(100, 100, true, 'height')
      ->save( FCPATH .'assets/upload/thumb/'. $fileName);
      $image->withFile($imageFile)
      ->resize(1000, 1000, true, 'height')
      ->save(FCPATH .'assets/upload/1000/'. $fileName);
          //quality
      $image->withFile($imageFile)
      ->withResource()
      ->save(FCPATH .'assets/upload/low/'. $fileName, 80);
            //manipulation
            //original image
      $imageFile->move('assets/upload/image', $fileName);
            // original image
      $data = [
        'img_name' => $imageFile->getClientName(),
        'file'  => $imageFile->getClientMimeType()
      ];
          // $save = $builder->insert($data);
      $response = [
        'success' => true,
        'picture' => $fileName,
        'msg' => "Gambar: {$imageFile->getClientName()} berhasil diupload"
      ];
      if (isset($_POST['id'])) {
        $param = array('id'=>$_POST['id']);
      // var_dump($param);
      // die();
        $oldRecord = $mdl->where($param)->get()->getResultArray()[0];
        
        $OldFilepath = [];
        $OldFilepath[0] = FCPATH . "assets/upload/1000/{$oldRecord['picture']}";
        $OldFilepath[1] = FCPATH . "assets/upload/image/{$oldRecord['picture']}";
        $OldFilepath[2] = FCPATH . "assets/upload/low/{$oldRecord['picture']}";
        $OldFilepath[3] = FCPATH . "assets/upload/thumb/{$oldRecord['picture']}";
        if (file_exists($OldFilepath[0])) {
          unlink( $OldFilepath[0]); 
        }
        if (file_exists($OldFilepath[1])) {
          unlink( $OldFilepath[1]); 
        }
        if (file_exists($OldFilepath[2])) {
          unlink( $OldFilepath[2]); 
        }
        if (file_exists($OldFilepath[3])) {
          unlink( $OldFilepath[3]); 
        }
        $mdl->set('picture',$fileName);
        $mdl->where($param);
        $mdl->update();
        if ($mdl->affectedRows()>0) {
          $riwayat = "Mengubah picture produk";
          $this->changelog->riwayat($riwayat);
          header('HTTP/1.1 200 OK');
        }else {
          header('HTTP/1.1 500 Internal Server Error');
          header('Content-Type: application/json; charset=UTF-8');
          die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
        }
      }
    }else{
      $response = [
        'success' => false,
        'data' => '',
        'msg' => $validateImage->getError('file')
      ];
    }


    return $this->response->setJSON($response);
}
    function update_cat(){
      $this->access('operator');
      $id = $_POST['id'];
      $category = $_POST['category'];
      $catBefore = $_POST['catBefore'];
      $mdl = new \App\Models\MdlProductGroup();
      $data = [
        "group" =>  $_POST["category"],
      ];
      $mdl->set($data);
      $mdl->where('id',$id);
      $mdl->update();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Mengubah group produk {$catBefore} menjadi {$category}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
        function hapus_cat(){
      $this->access('operator');
      $id = $_POST['id'];
      $nama = $_POST['nama'];
      $mdl = new \App\Models\MdlProductGroup();
      $mdl->where('id',$id);
      $mdl->delete();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Menghapus group produk $nama";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
      function restore_cat(){
      $this->access('operator');
      $id = $_POST['id'];
      $nama = $_POST['nama'];
      $mdl = new \App\Models\MdlProductGroup();
      $mdl->where('id',$id);
      $mdl->set('deleted_at',null);
      $mdl->update();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Mengembalikan group produk $nama";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
             function purge_group(){
      $this->access('operator');
      $id = $_POST['id'];
      $nama = $_POST['nama'];
      $mdl = new \App\Models\MdlProductGroup();
      $mdl->where('id',$id);
      $mdl->purgeDeleted();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Menghapus group produk $nama";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
     function create(){
      $mdl = new \App\Models\MdlProduct();
      $data = $_POST['data'];
       $mdl->insert($data);
        if ($mdl->affectedRows()>0) {
          $riwayat = "insert produk {$data['nama']}";
          $this->changelog->riwayat($riwayat);
          header('HTTP/1.1 200 OK');
        }else {
          header('HTTP/1.1 500 Internal Server Error');
          header('Content-Type: application/json; charset=UTF-8');
          die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
        }
     }
       function tambahSize(){
      $this->access('operator');
      $userInfo = $_SESSION['auth'];
      $userModel = new \App\Models\MdlSize();
      $userdata = [
        "kategori" =>  $_POST["kategori"],
        "ukuran" =>  $_POST["ukuran"],

      ];
      if ($userModel->insert($userdata)) {
        $riwayat = "User menambahkan ukuran ".$_POST['kategori']."-".$_POST['ukuran']." Untuk produk";
        header('HTTP/1.1 200 OK');
      }else{
        $riwayat = "User ".$userInfo['name']." gagal menambahkan ukuran";
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'User exist, gagal menambahkan data.', 'code' => 3)));
      }
      $this->changelog->riwayat($riwayat);
    
  }
  function selectSize(){
  $this->access('operator');
  $mdl = new \App\Models\MdlSize();
  $data = $mdl->get()->getResult();
  return json_encode($data);
}

  function purgeSize(){
      $this->access('operator');

      $params = $_POST['params'];
      $id = $params['id'];
      $kategori = $params['kategori'];
      $ukuran = $params['ukuran'];


      $mdl = new \App\Models\MdlSize();
      $mdl->where('id',$id);
      $mdl->delete();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Menghapus ukuran";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
       function updateSize(){
      $this->access('operator');

      $params = $_POST['params'];
      $id = $params['id'];
      $kategori = $params["kategori"];
      $ukuran = $params["ukuran"];
      $mdl = new \App\Models\MdlSize();
      $data = [
        "kategori" =>  $kategori,
        "ukuran" =>  $ukuran,
      ];
      $mdl->set($data);
      $mdl->where('id',$id);
      $mdl->update();
      if ($mdl->affectedRows()!=0) {
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
}
