<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    public function index()
    {
        $data['content']=view('admin/content/dashboard');
        return view('admin/index', $data);
    }
    public function login(){
        $userModel = new UserModel();
        if ($userModel->countAll()>0) {
            return view('login/login_view');

        }else{
            return view('login/register_view');
        }
    }
    // public function register(){
    //     return view('login/register_view');
    // }
    public function sejarah(){
        $data['content']=view('admin/content/sejarah');
        return view('admin/index', $data);
    }
    public function visimisi(){
        $data['content']=view('admin/content/visimisi');
        return view('admin/index', $data);
    }
    public function informasi(){
        $data['content']=view('admin/content/informasi');
        return view('admin/index', $data);
    }
    public function kegiatan(){
        $data['content']=view('admin/content/kegiatan');
        return view('admin/index', $data);
    }
    public function pengisiacara(){
        $data['content']=view('admin/content/pengisiacara');
        return view('admin/index', $data);
    }
    public function jadwal(){
        $data['content']=view('admin/content/jadwal');
        return view('admin/index', $data);
    }
    public function keuangan(){
        $data['content']=view('admin/content/keuangan');
        return view('admin/index', $data);
    }
    public function struktur(){
        $data['content']=view('admin/content/struktur');
        return view('admin/index', $data);
    }
     public function content(){
        $data['content']=view('admin/content/content');
        return view('admin/index', $data);
    }
    public function user(){
        $data['content']=view('admin/content/user');
        return view('admin/index', $data);
    }
}
