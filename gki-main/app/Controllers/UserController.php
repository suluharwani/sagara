<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
            public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'users.username','users.email','users.id');
    $column_search = array('users.username');
    $order = array('users.id' => 'desc');
    $list = $list_data->get_datatables('users', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->username;
      $row[] = $lists->email;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('users', $where),
      "recordsFiltered" => $list_data->count_filtered('users', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }


    // Menambahkan user baru
    public function add()
    {
        $userModel = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ];

        $userModel->insert($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    // Mengambil data user berdasarkan ID
    public function get($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        return $this->response->setJSON($user);
    }

    // Memperbarui data user
    public function update()
    {
        $userModel = new UserModel();
        $id = $this->request->getPost('id');
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $userModel->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }

    // Menghapus user berdasarkan ID
    public function delete($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Fungsi Login
    public function login()
    {
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->checkLogin($email, $password);

        if ($user) {
            // Simpan sesi login
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'email'     => $user['email'],
                'logged_in' => true
            ]);
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email atau Password salah']);
        }
    }

    // Fungsi Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
