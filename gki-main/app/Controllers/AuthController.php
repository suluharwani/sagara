<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function register()
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ];

        $userModel->insert($data);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Registration successful']);
    }

    public function login()
    {
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $userModel->checkLogin($email, $password);

        if ($user) {
            // Simpan session
            session()->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'logged_in' => true
            ]);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Login successful']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid credentials']);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
