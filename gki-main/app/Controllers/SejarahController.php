<?php

namespace App\Controllers;

use App\Models\SejarahModel;
use CodeIgniter\Controller;

class SejarahController extends Controller
{


    public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'sejarah.title','sejarah.id');
    $column_search = array('sejarah.title');
    $order = array('sejarah.id' => 'desc');
    $list = $list_data->get_datatables('sejarah', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->title;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('sejarah', $where),
      "recordsFiltered" => $list_data->count_filtered('sejarah', $column_order, $column_search, $order, $where),
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
        $SejarahModel = new SejarahModel();
        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('body'),  // Konten dengan HTML TinyMCE
        ];
        $SejarahModel->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function get($id)
    {
        $SejarahModel = new SejarahModel();
        $konten = $SejarahModel->find($id);
        return $this->response->setJSON($konten);
    }

public function update()
{
    $SejarahModel = new SejarahModel();

    // Dapatkan data dari request POST
    $id = $this->request->getPost('id');
    $title = $this->request->getPost('title');
    $body = $this->request->getPost('body');

    // Validasi input jika diperlukan
    if (!$id || !$title || !$body) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }

    // Update data konten di database
    $data = [
        'title' => $title,
        'content' => $body
    ];

    $SejarahModel->update($id, $data);

    // Kirimkan respons sukses
    return $this->response->setJSON(['status' => 'success', 'message' => 'Konten berhasil diperbarui']);
}


    public function delete($id)
    {
        $SejarahModel = new SejarahModel();
        $SejarahModel->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}