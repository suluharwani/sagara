<?php

namespace App\Controllers;

//untuk dynamic properties php 8.2 ke atas
use AllowDynamicProperties;

use google\apiclient;
use Bcrypt\Bcrypt;

class Client extends BaseController
{
  protected $google_client;
  protected $bcrypt;
  protected $userValidation;
  protected $changelog;
  protected $bcrypt_version;
  protected $session;
  protected $db;
  protected $uri;
  protected $form_validation;
  public function __construct()
  {
    $this->db = \Config\Database::connect();
    $this->session = session();
    $this->bcrypt = new Bcrypt();
    $this->bcrypt_version = '2a';
    $this->uri = service('uri');
    $this->form_validation = \Config\Services::validation();
    $this->userValidation = new \App\Controllers\LoginValidation();
    $this->changelog = new \App\Controllers\Changelog();
    helper('form');
    if (isset($_SESSION['auth'])) {
      $this->session->set('logoutButton', '
 <div class="dropdown">
  <button class="btn btn-outline btn-rounded btn-primary btn-4 btn-icon-effect-1 dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    Cliet Area
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" disabled">'.$_SESSION['auth']['nama_depan']." ".$_SESSION['auth']['nama_belakang'].'</a></li>
    <li><a class="btn btn-outline btn-rounded btn-primary dropdown-item" href="'.base_url("client").'">Dashboard</a></li>
    <li><a class="btn btn-outline btn-rounded btn-primary dropdown-item" href="'.base_url("client/services").'">Services</a></li>
    <li><a class="btn btn-outline btn-rounded btn-primary dropdown-item" href="'.base_url("client/billing").'">Billing</a></li>
    <li><a class="btn btn-outline btn-rounded btn-primary dropdown-item" href="'.base_url("client/support").'">Support</a></li>
    <li><a class="btn btn-outline btn-rounded btn-primary dropdown-item" href="'.base_url("client/promotion").'">Promotion</a></li>
    <li><a class="btn btn-outline btn-rounded btn-primary dropdown-item" href="'.base_url("client/program").'">Program</a></li>
    <li><a class="btn btn-outline btn-rounded btn-primary dropdown-item" href="'.base_url("clientlogout").'">Log out</a></li>
  </ul>
</div>
');
    }
    
  }
  function access(){
    if ($check = new \App\Controllers\CheckAccess()) {
      return $check->clientAccess();
    }
  }
  
  public function index()
  {
    if ($this->access()) {
      $data['content'] = view('home/content/dashboard');
      $view = view('home/index', $data);
    }else{
    $view = $this->loginForm();
    }
    return $view;
  }
  
  function loginForm(){
      $mdlValidasi = new \App\Models\MdlValidasi();
      
      $userModel = new \App\Models\MdlClient();
      $banyak_user = 0;
      $data['title'] = "Client Area Login";
      
      if ($this->request->getPost("submit") == "submit") {
        
        $token_generate = $this->request->getPost("token_generate");
        if ($this->userValidation->recaptchaValidation($token_generate)->success) {
          
          $this->form_validation->setRules(
            [
              'email' => [
                'label' => 'Email',
                'rules' => 'required|min_length[4]|max_length[39]'
              ],
              'nama_depan' => [
                'label' => 'Nama Depan',
                'rules' => 'required|min_length[4]|max_length[39]'
              ],
              'nama_belakang' => [
                'label' => 'Nama Belakang',
                'rules' => 'required|min_length[4]|max_length[39]'
              ],
              'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[4]|max_length[39]'
              ]
            ] 
          );
          if ($this->form_validation->withRequest($this->request)->run()) {
            $newUserData =  array(
              'email'=>$_POST['email'],
              'nama_depan'=>$_POST['nama_depan'],
              'nama_belakang'=>$_POST['nama_belakang'],
              'level'=>1,
              'status'=>0,
              'password'=>$this->bcrypt->encrypt($_POST['password'] , $this->bcrypt_version)
            );
            $userModel->insert($newUserData);
            if ($userModel->affectedRows() > 0) {
              $newHash = md5($_POST['email'].idate("U"));
              $mdlValidasi->insert(array('email'=>$_POST['email'], 'hash'=>$newHash));
              $this->sendEmail($_POST['email']);
              $riwayat = "User {$_POST['nama_depan']} {$_POST['nama_belakang']} berhasil mendaftar sebagai client";
              $this->changelog->riwayat($riwayat);
              $this->session->setFlashdata('message', "Email verifikasi telah dikirim ke {$_POST['email']}");
              
              return redirect()->to('client');
            }
          } else {
          //  validation not ok
            
            $this->session->setFlashdata('login_error', $this->form_validation->getErrors());
          }
        
        } else {
        //  validation recaptcha not ok
          
          $this->session->setFlashdata('login_error',  array('recaptcha' => "Recaptcha not valid" ));
        
        }
      }
  
      if ($this->request->getPost("submit") == "login") {
        
        $token_generate = $this->request->getPost("token_generate");
        if ($this->userValidation->recaptchaValidation($token_generate)->success) {
        // validation ok
        //password
          
          $this->form_validation->setRules(
            [
              'email' => [
                'label' => 'Email',
                'rules' => 'required|min_length[4]|max_length[39]'
              ],
              'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[4]|max_length[39]'
              ]
            ]
          );
          if ($this->form_validation->withRequest($this->request)->run()) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $user = $userModel->get_cipherpass($email);
  
            if ($user >0) {
              if ($user['status'] == 0) {
                $this->session->setFlashdata('login_error', array('notValid'=>"Akun belum aktif, verifikasi akun anda melalaui email"));
                $this->session->setFlashdata('buttonVerify', "<a href='".base_url('client/verifikasi/').$user['email']."' class='btn btn-primary'>Kirim ulang verifikasi</a>");
              }else{
                if ($user['password'] != NULL || $user['password'] != '' ) {
                  if ($this->bcrypt->verify($password, $user['password'])) {
  
                    $data_user = [
                      'id' => $user['id'],
                      'nama_depan'=> $user['nama_depan'],
                      'nama_belakang'=> $user['nama_belakang'],
                      'name'=> $user['nama_depan']." ".$user['nama_belakang'],
                      'email'=> $user['email'],
                      'picture'=> $user['profile_picture'],
                    ];
                    
                    $userModel->where("email", $email);
                    $profile = $userModel->get()->getResultArray();
                    $this->session->set('c_profile', $profile);
                    $this->session->set('c_logged', true);
                    $this->session->set('auth', $data_user);
                    
                    return redirect()->to('/client');
                  }else{
                    $this->session->setFlashdata('login_error',  array("failed"=>"Login Failed: Incorrect username or password"));
                  }
                }else{
                  $this->session->setFlashdata('login_error', array("failed"=>"Password tidak ada: Silakan login dengan google account"));
                }
              }
            
            }else{
              $this->session->setFlashdata('login_error', array("notActive"=>"User tidak ada/tidakaktif, silakan hubungi Administrator"));
            }
          } else {
          //  validation not ok
            $this->session->setFlashdata('login_error', $this->form_validation->getErrors());
          }
  
        } else {
        //  validation recaptcha not ok
  
          $this->session->setFlashdata('login_error',  array('recaptcha' => "Recaptcha not valid" ));
  
        }
      }
      
      $data['error'] = "";
      $google_client = new \Google_Client();
      //isi
      
      $google_client->setClientId($_ENV['ClientID']); //Define ClientID
      $google_client->setClientSecret($_ENV['ClientSecret']); //Define Client Secret Key
      $google_client->setRedirectUri(site_url('client')); //Define Redirect Uri
      $google_client->addScope('email');
      
      $google_client->addScope('profile');
      //link buat login
      $data['login_link'] = $google_client->createAuthUrl();
      
      if (isset($_GET['code'])) {
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);
        if(isset($token['access_token'])){
          $google_client->setAccessToken($token['access_token']);
          $Oauth = new \Google_Service_Oauth2($google_client);
          $userInfo = $Oauth->userinfo->get();
          Session()->auth = $userInfo;
          
  
          if ($userInfo) {
  
            if ($userModel->where(array('email' => $userInfo['email'],'deleted_at'=>NULL))->countAllResults() > 0) {
  
              if ($userModel->where(array('email' => $userInfo['email'],'deleted_at'=>NULL, 'status'=>0))->countAllResults()==0 ) {
                $data_user_select = $userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL))->get()->getResultArray()[0];
                if (($data_user_select['nama_depan'] != $userInfo['givenName']) or ($data_user_select['profile_picture'] != $userInfo['picture'])) {
                  $data_sync['nama_depan'] = $userInfo['givenName'];
                  $data_sync['nama_belakang'] = $userInfo['familyName'];
                  $data_sync['profile_picture'] = $userInfo['picture'];
                  $userModel->set($data_sync);
                  $userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL));
                  $userModel->update();
                }
                $userModel->where(array("email"=> $_SESSION['auth']['email'],'deleted_at'=>NULL));
                $profile = $userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL))->get()->getResultArray();
                
                $riwayat = "User ".$userInfo['name']." berhasil login kembali";
                $this->changelog->riwayat($riwayat);
                $this->session->set('c_profile', $profile);
                $this->session->set('c_logged', true);
                $this->session->set('auth', $data_user_select);
              }else{
                $this->session->setFlashdata('login_error', array('notValid'=>"Akun belum aktif, verifikasi akun anda melalaui email"));
                $this->session->setFlashdata('buttonVerify', "<a href='".base_url('client/verifikasi/').$userInfo['email']."' class='btn btn-primary'>Kirim Verifikasi</a>");
  
              }
              //login
  
            
            }else{
              //register
              if ($userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL))->countAllResults() == 0) {
                $data_baru['email'] = $userInfo['email'];
                $data_baru['nama_depan'] = $userInfo['givenName'];
                $data_baru['nama_belakang'] = $userInfo['familyName'];
                $data_baru['profile_picture'] = $userInfo['picture'];
                $data_baru['status'] = 1;
                // $data_baru['level'] = 1;
                $userModel->insert($data_baru);
                if ($userModel->affectedRows() > 0) {
                  $riwayat = "User " . $userInfo['name'] . " berhasil terdaftar sebagai user(belum aktif)";
                  $this->changelog->riwayat($riwayat);
                  $profile = $userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL))->get()->getResultArray();
                  $this->session->set('c_profile', $profile);
                  $this->session->set('c_logged', true);
                  $datareg = $userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL))->get()->getResultArray()[0];
                  $this->session->set('auth', $datareg);
                }else{
                  $riwayat = "User ".$userInfo['name']." - ".$userInfo['email']." Register gagal, (user tidak terdaftar)";
                  $this->changelog->riwayat($riwayat);
                  $this->session->setFlashdata('login_error', array('notValid'=>"Save data failed."));
                }
              }else{
                $riwayat = "User ".$userInfo['name']." - ".$userInfo['email']." Login gagal, (user tidak terdaftar)";
                $this->changelog->riwayat($riwayat);
                $this->session->setFlashdata('login_error', array('notValid'=>"Sudah memiliki akun, silakan login"));
                return redirect()->to('/client');
              
              }
            }
          }
          
          return redirect()->to('/client');
        }
      }
      if ($this->request->getPost("submit") == "toReg") {
        $view = view('register/clientRegister', $data);
      }else if ($this->request->getPost("submit") == "toLogIn") {
        $view =  view('login/clientLogin', $data);
      } else {
        $view =  view('login/clientLogin', $data);
      }
    
  return $view;
  }

  function clientlogout()
  {
    Session()->destroy();
    return Redirect()->to(base_url());
  }


  function sendEmail($to_email)
  {
    if (filter_var($to_email, FILTER_VALIDATE_EMAIL)) {
    $mdlValidasi = new \App\Models\MdlValidasi();
   $hashVerify = $mdlValidasi->where(array('email'=>$to_email))->get()->getResultArray()[0]['hash'];
    $link = site_url('client/verify/').$hashVerify;
    // $to_email = "suluharwani007@gmail.com";
        $from_email = 'no-reply@cendratama.co.id'; //change this to yours
        $subject = 'Verify Your Email Address';
        $message = "Dear User,<br /><br />Please click on the below activation link to verify your email address.<br /><br /> {$link} <br /><br /><br />Thanks<br />Mydomain Team";
        
        //configure email settings
        $email = \Config\Services::email();

        $email->setFrom($from_email, 'Cendrawasih Digikarya Pertama');
        $email->setTo($to_email);
// $email->setCC('another@another-example.com');
// $email->setBCC('them@their-example.com');

        $email->setSubject( $subject);
        $email->setMessage($message);

        $email->send();
      $this->session->setFlashdata('message', "Silakan cek email masuk untuk verifikasi");

      } else {
        $this->session->setFlashdata('message', "Email tidak valid, mohon login dengan alamat email yang benar");
      }

}
function verify($hash=null){
  if ($hash != null) {
      $mdlValidasi = new \App\Models\MdlValidasi();
      $userModel = new \App\Models\MdlClient();
      $email = $mdlValidasi->where(array('hash'=>$hash))->get()->getResultArray()[0]['email'];
      $userModel->set('status',1);
      $userModel->where('email',$email);
      
      if ($userModel->update()) {
        $this->session->setFlashdata('message', "User telah aktif, silakan login kembali");
      }else{
        $this->session->setFlashdata('message', "Gagal aktivasi, silakan login dengan Gmail");
      }
  }
  $data['content'] = view('home/content/verifikasi');
  return view('home/index', $data);
}
function verifikasi($email = null){
   if ($email != null) {
     $this->sendEmail($email);
   }
   $data['content'] = view('home/content/verifikasi');
   return view('home/index', $data);
 }

    }