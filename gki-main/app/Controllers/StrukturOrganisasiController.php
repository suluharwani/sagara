<?php

namespace App\Controllers;

use App\Models\StrukturOrganisasiModel;
use CodeIgniter\Controller;

class StrukturOrganisasiController extends Controller
{
        public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'struktur_organisasi.nama','struktur_organisasi.jabatan','struktur_organisasi.id');
    $column_search = array('struktur_organisasi.nama');
    $order = array('struktur_organisasi.id' => 'desc');
    $list = $list_data->get_datatables('struktur_organisasi', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->nama;
      $row[] = $lists->jabatan;
      $row[] = $lists->foto;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('struktur_organisasi', $where),
      "recordsFiltered" => $list_data->count_filtered('struktur_organisasi', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }
    // Tambah struktur organisasi dengan foto
    public function add()
    {
        $model = new StrukturOrganisasiModel();
        
        // Validasi input
        if (!$this->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Foto wajib diunggah',
                    'max_size' => 'Ukuran foto maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Hanya format JPG, JPEG, PNG yang diperbolehkan'
                ]
            ]
        ])) {
            return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
        }

        // Ambil file foto
        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();  // Beri nama acak
            $file->move(FCPATH . 'assets/img/struktur_organisasi', $newName);  // Simpan foto di folder
        }

        // Simpan data ke database
        $data = [
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'foto' => $newName,  // Nama file yang disimpan
        ];

        $model->insert($data);
        // $hasil = $model->getLastQuery();

        return $this->response->setJSON(['status' => 'success']);
    }

    // Update struktur organisasi
    public function update($id)
    {
        $model = new StrukturOrganisasiModel();
        $existingData = $model->find($id);

        // Validasi input
        $rules = [
            'nama' => 'required',
            'jabatan' => 'required',
        ];

        // Jika file diunggah saat update
        if ($this->request->getFile('foto')->isValid()) {
            $rules['foto'] = 'uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'errors' => $this->validator->getErrors()]);
        }

        // Jika ada file baru, hapus yang lama dan simpan yang baru
        $file = $this->request->getFile('foto');
        if ($file->isValid() && !$file->hasMoved()) {
            // Hapus foto lama jika ada
            if ($existingData['foto'] && file_exists(FCPATH . 'assets/img/struktur_organisasi/' . $existingData['foto'])) {
                unlink(FCPATH . 'assets/img/struktur_organisasi/' . $existingData['foto']);
            }

            $newName = $file->getRandomName();
            $file->move(FCPATH . 'assets/img/struktur_organisasi', $newName);
            $data['foto'] = $newName;
        }

        // Data yang akan di-update
        $data['nama'] = $this->request->getPost('nama');
        $data['jabatan'] = $this->request->getPost('jabatan');

        $model->update($id, $data);

        return $this->response->setJSON(['status' => 'success']);
    }
    public function get($id)
    {
        $SejarahModel = new StrukturOrganisasiModel();
        $konten = $SejarahModel->find($id);
        return $this->response->setJSON($konten);
    }
    // Hapus struktur organisasi beserta fotonya
    public function delete($id)
    {
        $model = new StrukturOrganisasiModel();
        $data = $model->find($id);

        // Hapus file foto dari folder jika ada
        if ($data['foto'] && file_exists(FCPATH . 'assets/img/struktur_organisasi/' . $data['foto'])) {
            unlink(FCPATH . 'assets/img/struktur_organisasi/' . $data['foto']);
        }

        $model->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}
