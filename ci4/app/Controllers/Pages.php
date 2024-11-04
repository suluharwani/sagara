<?php
namespace App\Controllers;
use AllowDynamicProperties; 
use CodeIgniter\Controller;
use Bcrypt\Bcrypt;
use google\apiclient;
class Pages extends BaseController
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
   $data['content']=view('admin/content/page');
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
  function tambah_page(){
      $this->access('operator');
      $userInfo = $_SESSION['auth'];
      $model = new \App\Models\MdlPages();
      $userdata = [
        "page" =>  $_POST["page"],
        "slug" => $model->slugify($_POST["page"], "-")
      ];
      if ($model->insert($userdata)) {
        $riwayat = "User ".$userInfo['nama_depan']." ".$userInfo['nama_depan']." menambahkan halaman: ".$_POST['page']."";
        header('HTTP/1.1 200 OK');
      }else{
        $riwayat = "User ".$userInfo['name']." gagal menambahkan halaman: ".$_POST['page'];
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'User exist, gagal menambahkan data.', 'code' => 3)));
      }
      $this->changelog->riwayat($riwayat);
  }
    function detail(){
      $this->access('operator');
      $userInfo = $_SESSION['auth'];
      $id = $_POST['id'];
      $modelPage = new \App\Models\MdlPages();
      $modelCat = new \App\Models\MdlCategory();
      $modelSubCat = new \App\Models\MdlSubCategory();
      $data['page'] = $modelPage->where('id',$id)->get()->getResultArray();
      $data['category'] = $modelCat->where('page_id',$id)->get()->getResultArray();
      // $data['subCategory'] = $modelSubCat->where('page_id',$id)->get()->getResultArray();
      return json_encode($data);
  }
    function hapus_page(){
      $this->access('operator');
      $id = $_POST['id'];
      $nama = $_POST['nama'];
      $mdl = new \App\Models\MdlPages();
      $mdl->where('id',$id);
      $mdl->delete();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Menghapus halaman $nama";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
      function deleted_page(){
      $model = new \App\Models\MdlPages();
      $where = ['id !=' => 0, 'deleted_at !='=>NULL];
      return json_encode($model->where($where)->get()->getResult());
    }
    function restore_page(){
      $this->access('operator');
      $id = $_POST['id'];
      $nama = $_POST['nama'];
      $mdl = new \App\Models\MdlPages();
      $mdl->set('deleted_at',NULL);
      $mdl->where('id',$id);
      $mdl->update();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Mengembalikan halaman $nama";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
    function update_page(){
      $this->access('operator');
      $id = $_POST['id'];
      $page = $_POST['page'];
      $nama_awal = $_POST['nama'];
      $mdl = new \App\Models\MdlPages();
         $data = [
        "page" =>  $_POST["page"],
        "slug" => $mdl->slugify($_POST["page"], "-")
      ];
      $mdl->set($data);
      $mdl->where('id',$id);
      $mdl->update();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Mengubah halaman {$nama_awal} menjadi {$page}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
     function cat_list(){
      $this->access('operator');
      $page_id = $_POST['id'];
      $mdl = new \App\Models\MdlCategory();
      $data = $mdl->select('category.id as cat_id,category.page_id as page_id, category.category as category, JSON_ARRAYAGG(sub_category.id) as sub_cat_id, JSON_ARRAYAGG(sub_category.sub_category)  as sub_category')
              ->join('sub_category','category.id =sub_category.category_id', 'left')
              ->where('page_id', $page_id)
              ->groupBy('category.category')
              ->get()
              ->getResultArray();
      return json_encode($data);
     }
          function subcat_list(){
      $this->access('operator');
      $cat_id = $_POST['id'];
      $mdl = new \App\Models\MdlSubCategory();
      $data = $mdl->select('sub_category')
              ->where('category_id', $cat_id)
              ->get()
              ->getResultArray();
      return json_encode($data);
     }
      function tambah_cat(){
      $this->access('operator');
      $id = $_POST['id'];
      $nama_page = $_POST['nama'];
      $cat = $_POST['cat'];
      $mdl = new \App\Models\MdlCategory();
      //'category_id','sub_category','slug'
      $data = [
        "page_id" =>  $id,
        "category" =>  $cat,
        "slug" => $mdl->slugify($cat, "-")
      ];
      $mdl->insert($data);
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Menambahkan sub kategori {$cat} pada halaman {$nama_page}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     }
    function update_cat(){
      $this->access('operator');
      $id = $_POST['id'];
      $category = $_POST['category'];
      $catBefore = $_POST['catBefore'];
      $mdl = new \App\Models\MdlCategory();
      $data = [
        "category" =>  $_POST["category"],
        "slug" => $mdl->slugify($_POST["category"], "-")
      ];
      $mdl->set($data);
      $mdl->where('id',$id);
      $mdl->update();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Mengubah kategori {$catBefore} menjadi {$category}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
     function tambah_subcat(){
      $this->access('operator');
      $cat_id = $_POST['id'];
      $page_id = $_POST['page_id'];
      $sub_cat = $_POST['sub_cat'];
      $mdl = new \App\Models\MdlSubCategory();
      //'category_id','sub_category','slug'
      $data = [
        "category_id" =>  $cat_id,
        "sub_category" =>  $sub_cat,
        "slug" => $mdl->slugify($sub_cat, "-")
      ];
      $mdl->insert($data);
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Menambahkan sub kategori {$sub_cat} pada page id = {$page_id}, kategori id = {$cat_id}";
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
      $mdl = new \App\Models\MdlCategory();
      $mdl->where('id',$id);
      $mdl->delete();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Menghapus kategori $nama";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
      function update_subcat(){
      $this->access('operator');
      $id = $_POST['id'];
      $subCategory = $_POST['subCategory'];
      $catBefore = $_POST['catBefore'];
      $mdl = new \App\Models\MdlSubCategory();
      $data = [
        "sub_category" =>  $_POST["subCategory"],
        "slug" => $mdl->slugify($_POST["subCategory"], "-")
      ];
      $mdl->set($data);
      $mdl->where('id',$id);
      $mdl->update();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Mengubah sub kategori {$catBefore} menjadi {$subCategory}";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 
      function hapus_subcat(){
      $this->access('operator');
      $id = $_POST['id'];
      $nama = $_POST['nama'];
      $mdl = new \App\Models\MdlSubCategory();
      $mdl->where('id',$id);
      $mdl->delete();
      if ($mdl->affectedRows()!=0) {
        $riwayat = "Menghapus sub kategori $nama";
        $this->changelog->riwayat($riwayat);
        header('HTTP/1.1 200 OK');
      }else {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'Tidak ada perubahan pada data', 'code' => 1)));
      }
     } 

}
