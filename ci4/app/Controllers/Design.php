<?php

namespace App\Controllers;

class Design extends BaseController
{
    public function studio()
    {
        return view('home/layout', [
            'pageTitle' => 'Desain Custom | Sagara Jersey',
            'pageDescription' => 'Buat desain jersey dan kaos sendiri. Pilih template, ubah warna, tambahkan nama, nomor dan logo, lalu unduh hasil desain Anda.',
            'content' => view('home/content/design-studio', ['studioConfig' => [
                'templatesUrl' => base_url('design/templates'), 'submitUrl' => base_url('design/submit'),
                'csrf' => csrf_hash(), 'csrfHeader' => csrf_header(),
            ]]),
        ]);
    }

    public function index()
    {
        $data['content'] = view('home/content/upload-design');
        return view('home/layout', $data);
    }

    public function upload()
    {
        $file = $this->request->getFile('design');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid.');
        }

        // Validate file type
        $allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'application/pdf', 'image/svg+xml'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Tipe file tidak diizinkan. Gunakan PNG, JPG, PDF, atau SVG.');
        }

        // Validate file size (5MB)
        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimal 5MB.');
        }

        // Create directory if not exists
        $uploadPath = FCPATH . 'writable/uploads/designs/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Generate unique filename
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        return redirect()->to('design/preview/' . $newName)->with('success', 'Desain berhasil diupload.');
    }

    public function preview($filename)
    {
        $data['filename'] = $filename;
        $data['filepath'] = base_url('writable/uploads/designs/' . $filename);
        $data['content'] = view('home/content/design-preview', $data);
        return view('home/layout', $data);
    }
}


