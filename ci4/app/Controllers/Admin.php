<?php
namespace App\Controllers;
use AllowDynamicProperties; 
use CodeIgniter\Controller;
use Bcrypt\Bcrypt;
use google\apiclient;
class Admin extends BaseController
{
    protected $bcrypt;
    protected $userValidation;
    protected $bcrypt_version;
    protected $session;
    protected $db;
    protected $uri;
    protected $form_validation;
    public function __construct()
    {
    //   parent::__construct();
      $this->request = \Config\Services::request();
      $this->db      = \Config\Database::connect();
      $this->session = session();
      $this->bcrypt = new Bcrypt();
      $this->bcrypt_version = '2a';
      $this->uri = service('uri');
      helper('form');
      $this->form_validation = \Config\Services::validation();
      $this->userValidation = new \App\Controllers\LoginValidation();
      //if sesion habis
      //check login
      $check = new \App\Controllers\CheckAccess();
      $check->logged();
 
    }
    public function index()
    {
        // $this->session->set('logged',"session ok");
        $data['content']=view('admin/content/dashboard');
        return view('admin/index', $data);
    }
    public function content($title){
        $data['content']=view('admin/content/contentBlog');
        return view('admin/index', $data);
    }
      function test($table){
    $query = $this->db->query("SELECT * FROM $table");

    foreach ($query->getFieldNames() as $field) {
      echo '"'.$field.'",';
    }
}

}
