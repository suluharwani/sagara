<?php

namespace App\Controllers;

//untuk dynamic properties php 8.2 ke atas
use AllowDynamicProperties;

use google\apiclient;
use Bcrypt\Bcrypt;

class Login extends BaseController
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
  }
  public function index()
  {
    $userModel = new \App\Models\MdlUser();
    $banyak_user = 0;
    $data['title'] = "da";
    //login dengan input
    //Register
    if ($this->request->getPost("submit") == "submit") {

      $token_generate = $this->request->getPost("token_generate");
      if ($this->userValidation->recaptchaValidation($token_generate)->success) {
        // validation ok

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
                                'status'=>1,
                                'password'=>$this->bcrypt->encrypt($_POST['password'] , $this->bcrypt_version)
                              );
          $userModel->insert($newUserData);
          if ($userModel->affectedRows() > 0) {
            $riwayat = "User {$_POST['nama_depan']} {$_POST['nama_belakang']} berhasil mendaftar sebagai admin";
            $this->changelog->riwayat($riwayat);
            return redirect()->to('admin');
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
    //end register
    //login
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

          if ($user >0 && $user['status'] == 1) {
            if ($user['level'] >= 2) {
              $this->session->setFlashdata('login_error', array("not_admin"=>"Anda bukan Administrator, silakan hubungi Administrator untuk meminta halaman login"));
            }
            if ($user['password'] != NULL || $user['password'] != '' ) {


              if ($this->bcrypt->verify($password, $user['password'])) {

                $data_user = [
                  'id' => $user['id'],
                  'nama_depan'=> $user['nama_depan'],
                  'level'=> $user['level'],
                  'nama_belakang'=> $user['nama_belakang'],
                  'name'=> $user['nama_depan']." ".$user['nama_belakang'],
                  'email'=> $user['email'],
                  'picture'=> $user['profile_picture'],
                ];
    
                $userModel->where("email", $email);
                $profile = $userModel->get()->getResultArray();
                $this->session->set('profile', $profile);
                $this->session->set('logged', true);
                $this->session->set('auth', $data_user);

                return redirect()->to('/admin');
              }else{
                $this->session->setFlashdata('login_error',  array("failed"=>"Login Failed: Incorrect username or password"));
              }
            }else{
              $this->session->setFlashdata('login_error', array("failed"=>"Password tidak ada: Silakan login dengan google account"));
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

        $this->session->setFlashdata('login_error',  array('recaptcha' => "Recaptcha not valid, silakan login lagi!" ));

      }
    }
    //end login
    //login & sign up with google
    $data['error'] = "";
    $google_client = new \Google_Client();
      //isi
      
      $google_client->setClientId($_ENV['ClientID']); //Define ClientID
      $google_client->setClientSecret($_ENV['ClientSecret']); //Define Client Secret Key
      $google_client->setRedirectUri(site_url('admin/login')); //Define Redirect Uri
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
              //login
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
              $this->session->set('profile', $profile);
              $this->session->set('logged', true);
              $this->session->set('auth', $data_user_select);

            }else{
              //register
              if ($userModel->countAllResults() == 0) {
                $data_baru['email'] = $userInfo['email'];
                $data_baru['nama_depan'] = $userInfo['givenName'];
                $data_baru['nama_belakang'] = $userInfo['familyName'];
                $data_baru['profile_picture'] = $userInfo['picture'];
                $data_baru['status'] = 1;
                $data_baru['level'] = 1;
                $userModel->insert($data_baru);
              if ($userModel->affectedRows() > 0) {
                $riwayat = "User " . $userInfo['name'] . " berhasil terdaftar sebagai Administrator";
                $this->changelog->riwayat($riwayat);
                $profile = $userModel->where(array('email' => $userInfo['email'], 'deleted_at'=>NULL))->get()->getResultArray();
                $this->session->set('profile', $profile);
                $this->session->set('logged', true);
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
                $this->session->setFlashdata('login_error', array('notValid'=>"unauthorized google account."));
                return redirect()->to('/admin/login');

              }
            }
          }

          return redirect()->to('/admin');
        }
      }
    //end login & sign up with google
    //view page login register
    if ($userModel->countAllResults() == 0) {
      return view('register/index', $data);
    } else {
      return view('login/index', $data);

    }


  }

  function logout()
  {
    Session()->destroy();
    return Redirect()->to(base_url('admin'));
  }
  function altlogin(){
    if ($_ENV['altLogin'] == "ok") {
    // Session()->destroy();
    $userModel = new \App\Models\MdlUser();
    $user = $userModel->first('*');
                $data_user = [
                  'id' => $user['id'],
                  'nama_depan'=> $user['nama_depan'],
                  'level'=> $user['level'],
                  'nama_belakang'=> $user['nama_belakang'],
                  'name'=> $user['nama_depan']." ".$user['nama_belakang'],
                  'email'=> $user['email'],
                  'picture'=> $user['profile_picture'],
                ];
    
                $userModel->where("email", $user['email']);
                $profile = $userModel->get()->getResultArray();
                $this->session->set('profile', $profile);
                $this->session->set('logged', true);
                $this->session->set('auth', $data_user);
                return redirect()->to('/admin');
    }else{
      echo('alt login not true');
    }
  }
  function altloginuser(){
    if ($_ENV['altLogin'] == "ok") {
    // Session()->destroy();
    $userModel = new \App\Models\MdlClient();
    $user = $userModel->first('*');
                $data_user = [
                  'id' => $user['id'],
                  'nama_depan'=> $user['nama_depan'],
                  'nama_belakang'=> $user['nama_belakang'],
                  'name'=> $user['nama_depan']." ".$user['nama_belakang'],
                  'email'=> $user['email'],
                  'picture'=> $user['profile_picture'],
                ];
    
                $userModel->where("email", $user['email']);
                $profile = $userModel->get()->getResultArray();
                $this->session->set('c_profile', $profile);
                $this->session->set('c_logged', true);
                $this->session->set('auth', $data_user);
                return redirect()->to('/client');
    }else{
      echo('alt login not true');
    }
  }

}