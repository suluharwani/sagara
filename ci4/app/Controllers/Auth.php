<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        $data['content'] = view('home/content/login');
        return view('home/layout', $data);
    }

    public function process()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $clientModel = new \App\Models\MdlClient();
        $client = $clientModel->where('email', $this->request->getPost('email'))->first();

        if (!$client || !password_verify($this->request->getPost('password'), $client['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        if ((int) $client['status'] !== 1) {
            return redirect()->back()->withInput()->with('error', 'Akun belum diverifikasi. Silakan cek email.');
        }

        // Set session
        session()->set('customer', $client);

        return redirect()->to(($client['account_type'] ?? 'customer') === 'reseller' ? 'reseller/dashboard' : 'dashboard');
    }

    public function logout()
    {
        session()->remove('customer');
        return redirect()->to('login')->with('success', 'Berhasil logout.');
    }

    public function forgot()
    {
        $data['content'] = view('home/content/forgot-password');
        return view('home/layout', $data);
    }

    public function forgotProcess()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $clientModel = new \App\Models\MdlClient();
        $client = $clientModel->where('email', $this->request->getPost('email'))->first();

        if (!$client) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        $token = bin2hex(random_bytes(32));
        $clientModel->update($client['id'], ['reset_token' => $token]);

        // Send reset email
        $this->sendResetEmail($client['email'], $token);

        return redirect()->to('login')->with('success', 'Link reset password telah dikirim ke email.');
    }

    public function reset($token)
    {
        $clientModel = new \App\Models\MdlClient();
        $client = $clientModel->where('reset_token', $token)->first();

        if (!$client) {
            return redirect()->to('login')->with('error', 'Token reset tidak valid.');
        }

        $data['token'] = $token;
        $data['content'] = view('home/content/reset-password', $data);
        return view('home/layout', $data);
    }

    private function sendResetEmail($email, $token)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Reset Password - Sagara Jersey');
        $emailService->setMessage(view('emails/reset-password', ['token' => $token]));
        $emailService->send();
    }

    public function google()
    {
        $google_client = new \Google_Client();
        $google_client->setClientId($_ENV['ClientID']);
        $google_client->setClientSecret($_ENV['ClientSecret']);
        $google_client->setRedirectUri(site_url('login/google'));
        $google_client->addScope('email');
        $google_client->addScope('profile');
        
        $login_link = $google_client->createAuthUrl();
        return redirect()->to($login_link);
    }

    public function googleCallback()
    {
        $google_client = new \Google_Client();
        $google_client->setClientId($_ENV['ClientID']);
        $google_client->setClientSecret($_ENV['ClientSecret']);
        $google_client->setRedirectUri(site_url('login/google'));
        
        $code = $this->request->getGet('code');
        if (!$code) {
            return redirect()->to('login')->with('error', 'Login dengan Google gagal.');
        }
        
        $token = $google_client->fetchAccessTokenWithAuthCode($code);
        if (isset($token['error'])) {
            return redirect()->to('login')->with('error', 'Login dengan Google gagal: ' . $token['error']);
        }
        
        $google_client->setAccessToken($token['access_token']);
        $Oauth = new \Google_Service_Oauth2($google_client);
        $userInfo = $Oauth->userinfo->get();
        
        if (!$userInfo) {
            return redirect()->to('login')->with('error', 'Gagal mendapatkan info user Google.');
        }
        
        $clientModel = new \App\Models\MdlClient();
        $client = $clientModel->where('email', $userInfo->email)->first();
        
        if (!$client) {
            // Register new client
            $clientData = [
                'name' => $userInfo->givenName . ' ' . $userInfo->familyName,
                'nama_depan' => $userInfo->givenName,
                'nama_belakang' => $userInfo->familyName,
                'email' => $userInfo->email,
                'password' => password_hash(bin2hex(random_bytes(8)), PASSWORD_BCRYPT),
                'phone' => '',
                'account_type' => 'customer',
                'status' => 1,
                'profile_picture' => $userInfo->picture,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $clientModel->insert($clientData);
            $client = $clientModel->where('email', $userInfo->email)->first();
        }
        
        // Set session
        session()->set('customer', $client);
        return redirect()->to(($client['account_type'] ?? 'customer') === 'reseller' ? 'reseller/dashboard' : 'dashboard');
    }
}


