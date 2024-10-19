<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use CodeIgniter\Controller;

class KegiatanController extends Controller
{


     public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'kegiatan.nama_kegiatan','kegiatan.tanggal','kegiatan.lokasi');
    $column_search = array('kegiatan.nama_kegiatan');
    $order = array('kegiatan.id' => 'desc');
    $list = $list_data->get_datatables('kegiatan', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->nama_kegiatan;
      $row[] = $lists->deskripsi;
      $row[] = $lists->tanggal;
      $row[] = $lists->lokasi;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('kegiatan', $where),
      "recordsFiltered" => $list_data->count_filtered('kegiatan', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }

    public function upload_image()
    {
        $file = $this->request->getFile('file');  // Nama file berasal dari FormData

        if ($file->isValid() && !$file->hasMoved()) {
            // Beri nama acak pada file
            $newName = $file->getRandomName();

            // Pindahkan file ke folder assets/img
            $file->move(FCPATH . 'assets/img', $newName);

            // Kembalikan URL gambar ke TinyMCE
            $response = [
                'location' => base_url('assets/img/' . $newName),
            ];

            return $this->response->setJSON($response);
        }

        // Jika terjadi kesalahan, kirim respons gagal
        return $this->response->setJSON(['error' => 'Gagal mengunggah gambar']);
    }

    public function add()
    {
        $KegiatanModel = new KegiatanModel();
        $data = [
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'deskripsi' => $this->request->getPost('deskripsi'),  
            'tanggal' => $this->request->getPost('tanggal'),  
            'lokasi' => $this->request->getPost('lokasi') 
        ];
        $KegiatanModel->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function get($id)
    {
        $KegiatanModel = new KegiatanModel();
        $konten = $KegiatanModel->find($id);
        return $this->response->setJSON($konten);
    }

public function update()
{
    $KegiatanModel = new KegiatanModel();

    // Dapatkan data dari request POST
    $id = $this->request->getPost('id');
    $nama_kegiatan = $this->request->getPost('nama_kegiatan');
    $lokasi = $this->request->getPost('lokasi');
    $tanggal = $this->request->getPost('tanggal');
    $deskripsi = $this->request->getPost('deskripsi');

    // Validasi input jika diperlukan
    if (!$id || !$nama_kegiatan || !$lokasi || !$tanggal || !$deskripsi) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }

    // Update data kegiatan di database
    $data = [
        'nama_kegiatan' => $nama_kegiatan,
        'lokasi' => $lokasi,
        'tanggal' => $tanggal,
        'deskripsi' => $deskripsi
    ];

    $KegiatanModel->update($id, $data);  // Update data di database

    // Kirimkan respons sukses
    return $this->response->setJSON(['status' => 'success', 'message' => 'Kegiatan berhasil diperbarui']);
}


    public function delete($id)
    {
        $KegiatanModel = new KegiatanModel();
        $KegiatanModel->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}