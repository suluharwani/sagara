<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function index()
    {
        $data['content'] = view('home/content/register');
        return view('home/layout', $data);
    }

    public function process()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[client.email]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'phone' => 'required|min_length[10]',
            'terms' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $clientModel = new \App\Models\MdlClient();
        $token = bin2hex(random_bytes(32));

        $clientData = [
            'name' => $this->request->getPost('name'),
            'nama_depan' => trim(explode(' ', (string) $this->request->getPost('name'), 2)[0]),
            'nama_belakang' => trim(explode(' ', (string) $this->request->getPost('name'), 2)[1] ?? ''),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'phone' => $this->request->getPost('phone'),
            'account_type' => 'customer',
            'status' => 0,
            'verification_token' => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $clientModel->insert($clientData);

        // Send verification email
        $this->sendVerificationEmail($clientData['email'], $token);

        return redirect()->to('login')->with('success', 'Registrasi berhasil! Silakan cek email untuk verifikasi.');
    }

    public function verify($token)
    {
        $clientModel = new \App\Models\MdlClient();
        $client = $clientModel->where('verification_token', $token)->first();

        if (!$client) {
            return redirect()->to('login')->with('error', 'Token verifikasi tidak valid.');
        }

        $clientModel->update($client['id'], [
            'status' => 1,
            'verification_token' => null,
        ]);

        return redirect()->to('login')->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    private function sendVerificationEmail($email, $token)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Verifikasi Email - Sagara Jersey');
        $emailService->setMessage(view('emails/verification', ['token' => $token]));
        $emailService->send();
    }
}


