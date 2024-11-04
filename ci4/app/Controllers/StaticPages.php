<?php
namespace App\Controllers;
use AllowDynamicProperties; 
use CodeIgniter\Controller;
use Bcrypt\Bcrypt;
use google\apiclient;
class StaticPages extends BaseController
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
      // echo"ok";
      // $data['content']=view('admin/content/page');
      // return view('admin/index', $data);
  }
  public function manage(){
    $this->access('operator');
    $data['content']=view('admin/content/static_page');
    return view('admin/index', $data);
  }
  // function logoutAdmin(){
  //     return "adad";
  // }
  function access($page){
    $check = new \App\Controllers\CheckAccess();
    $check->access($_SESSION['auth']['id'],$page);
  }
  public function listdata_pages(){
    $this->access('operator');
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
        //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
        //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'page.page','page.id');
    $column_search = array('page.page','page.id');
    $order = array('page.id' => 'desc');
    $list = $list_data->get_datatables('page', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->page;
      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('page', $where),
      "recordsFiltered" => $list_data->count_filtered('page', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }
  function crud($action = null){
    $this->access('operator');
    if ($action != null) {

      $page = $_POST['page'];
      $data = $_POST['data'];
      $param = $_POST['param'];
      if ($page == 'contact-us') {
        $mdl = new \App\Models\MdlContactUs();
      }else  if ($page == 'slider') {
        $mdl = new \App\Models\MdlSlider();
      }else  if ($page == 'service') {
        $mdl = new \App\Models\MdlService();
      }else  if ($page == 'portfolio') {
        $mdl = new \App\Models\MdlPortfolio();
      }else  if ($page == 'testimonial') {
        $mdl = new \App\Models\MdlTestimonial();
      }else  if ($page == 'partner') {
        $mdl = new \App\Models\MdlPartner();
      }else  if ($page == 'offer') {
        $mdl = new \App\Models\MdlOffer();
      }else{
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'page not found', 'code' => 3)));
      }
      if ($action == 'create') {
        $mdl->insert($data);
        if ($mdl->affectedRows()>0) {
          $riwayat = "insert halaman statis {$page}";
          $this->changelog->riwayat($riwayat);
          header('HTTP/1.1 200 OK');
        }else {
          header('HTTP/1.1 500 Internal Server Error');
          header('Content-Type: application/json; charset=UTF-8');
          die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
        }
      }else  if ($action == 'read') {
       $mdl->where('deleted_at', null);
       if ($param != '') {
         $mdl->where($param);
       } 
       return json_encode($mdl->get()->getResultArray());
     }else  if ($action == 'read_deleted') {
       $mdl->onlyDeleted();
       if ($param != '') {
         $mdl->where($param);
       } 
       return json_encode($mdl->get()->getResultArray());
     }else  if ($action == 'update') {
      $mdl->set($data);
      $mdl->where($param);
      $mdl->update();
      if ($mdl->affectedRows()>0) {
        $riwayat = "Mengubah halaman statis {$page}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
    }else  if ($action == 'restore') {
      $mdl->set('deleted_at',null);
      $mdl->where($param);
      $mdl->update();
      if ($mdl->affectedRows()>0) {
        $riwayat = "Restore halaman statis {$page}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
    }else  if ($action == 'delete') {
      $mdl->where($param);
      $mdl->delete();
      if ($mdl->affectedRows()>0) {
        $riwayat = "Menghapus halaman statis {$page}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
    }else  if ($action == 'purge') {
      $record = $mdl->where($param)->onlyDeleted()->get()->getResultArray()[0];

      $filepath = []; 
      $filepath[0] = FCPATH . "assets/upload/1000/{$record['picture']}";
      $filepath[1] = FCPATH . "assets/upload/image/{$record['picture']}";
      $filepath[2] = FCPATH . "assets/upload/low/{$record['picture']}";
      $filepath[3] = FCPATH . "assets/upload/thumb/{$record['picture']}";

      if ($record['picture'] != null){
        if (file_exists($filepath[0])) {
          unlink( $filepath[0]); 
        }
        if (file_exists($filepath[1])) {
          unlink( $filepath[1]); 
        }
        if (file_exists($filepath[2])) {
          unlink( $filepath[2]); 
        }
        if (file_exists($filepath[3])) {
          unlink( $filepath[3]); 
        }
      }
      if ($mdl->where($param)->purgeDeleted()) {
        $riwayat = "Menghapus permanen halaman statis {$page} data: ".json_encode($record)."";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else{
       header('HTTP/1.1 500 Internal Server Error');
       header('Content-Type: application/json; charset=UTF-8');
       die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
     }

   }else if ($action == 'upload'){
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
      $filepath = site_url('assets/upload/image');
          // manipulatoin
      $image = \Config\Services::image();
          //thumbnail
      $image->withFile($imageFile)
      ->resize(100, 100, true, 'height')
      ->save(FCPATH . '/assets/upload/thumb/'. $fileName);
      $image->withFile($imageFile)
      ->resize(1000, 1000, true, 'height')
      ->save(FCPATH . '/assets/upload/1000/'. $fileName);
          //quality
      $image->withFile($imageFile)
      ->withResource()
      ->save(FCPATH . '/assets/upload/low/'. $fileName, 80);
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
          $riwayat = "Mengubah picture {$page}";
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
  }else{
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => "Tidak ada aksi", 'code' => 1)));
  }
}else{
  $mdl = new \App\Models\MdlStaticPage();
  $output = $mdl->get()->getResultArray();
  return json_encode($output);
}
}

function ubah_status(){
  $this->access('operator');
  $mdl = new \App\Models\MdlStaticPage();

  $id = $_POST['id'];
  $status = $_POST['status'];
  if ($status == 1) {
    $data['status'] = 0;
  }else{
    $data['status'] = 1;

  }
  $mdl->set($data);
  $mdl->where('id',$id);
  $mdl->update();
  if ($mdl->affectedRows()>0) {
    $riwayat = "Mengubah status halaman statis id = {$id} ke {$data['status']}" ;
    $this->changelog->riwayat($riwayat);
    header('HTTP/1.1 200 OK');
  }else {
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
  }

}
function manage_static_page($static){
  $this->access('operator');
  if ($static == 'contact-us') {
    $mdl = new \App\Models\MdlContactUs();
    $data['content']=view('admin/content/static/contact_us');
    return view('admin/index', $data);
  }else if ($static == 'slider') {
    $mdl = new \App\Models\MdlSlider();
    $data['content']=view('admin/content/static/slider');
    return view('admin/index', $data);
  }else if ($static == 'service') {
    $mdl = new \App\Models\MdlService();
    $data['content']=view('admin/content/static/service');
    return view('admin/index', $data);
  }else if ($static == 'portfolio') {
    $mdl = new \App\Models\MdlPortfolio();
    $data['content']=view('admin/content/static/portfolio');
    return view('admin/index', $data);
  }else if ($static == 'testimonial') {
    $mdl = new \App\Models\MdlTestimonial();
    $data['content']=view('admin/content/static/testimonial');
    return view('admin/index', $data);
  }else if ($static == 'partner') {
    $mdl = new \App\Models\MdlPartner();
    $data['content']=view('admin/content/static/partner');
    return view('admin/index', $data);
  }else if ($static == 'offer') {
    $mdl = new \App\Models\MdlOffer();
    $data['content']=view('admin/content/static/offer');
    return view('admin/index', $data);
  }else{
   throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
 }

}
function tinymceUpload(){
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
    $filepath = site_url('assets/upload/tinymce/image');
          // manipulatoin
    $image = \Config\Services::image();
    $image->withFile($imageFile)
    ->resize(1000, 1000, true, 'height')
    ->save('../public/assets/upload/tinymce/1000/'. $fileName,80);
          //quality
    $imageFile->move('assets/upload/tinymce/image', $fileName);
    $data = [
      'img_name' => $imageFile->getClientName(),
      'file'  => $imageFile->getClientMimeType()
    ];

          // $save = $builder->insert($data);
    $newPath = site_url('assets/upload/tinymce/image/'.$fileName);
    
  // header('HTTP/1.1 200 OK');
  // header('Content-Type: application/json; charset=UTF-8');
  // return (json_encode(['localtion' => $newPath])  );
    echo base_url("$newPath");
   // return json_encode(['localtion' => $newPath]);
  }else{
    header('HTTP/1.1 500 Internal Server Error');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
  }

}
function listGambar()
{
  $files = array_filter(glob('assets/upload/tinymce/image/*'), 'is_file');
  $response = [];
  foreach ($files as $file) {
    if (strpos($file, "index.html")) {
      continue;
    }
    $response[] = basename($file);
  }
  header("Content-Type:application/json");
  echo json_encode($response);
  die();
}

function deleteGambar()
{
  $src = $this->request->getVar('src');
  if ($src) {
    $file_name = str_replace(base_url() . "/", "", $src);
    if (unlink($file_name)) {
      echo "Berhasil hapus image ";
    }
    $thumb_name = str_replace("assets/upload/tinymce/image/", "assets/upload/tinymce/1000/", $file_name);
    if (unlink($thumb_name)) {
      echo "Berhasil hapus thumbnail";

    }

  }
}
function select_client(){
  $this->access('operator');
  $mdl = new \App\Models\MdlClient();
  $data = $mdl->get()->getResult();
  return json_encode($data);
}
function select_produk(){
  $this->access('operator');
  $mdl = new \App\Models\MdlProduct();
  $data = $mdl->get()->getResult();
  return json_encode($data);
}
}

