<?php

namespace App\Controllers;

use App\Models\ContentModel;
use CodeIgniter\Controller;

class ContentController extends Controller
{
    public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'content.title','content.id');
    $column_search = array('content.title');
    $order = array('content.id' => 'desc');
    $list = $list_data->get_datatables('content', $column_order, $column_search, $order, $where);
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
      "recordsTotal" => $list_data->count_all('content', $where),
      "recordsFiltered" => $list_data->count_filtered('content', $column_order, $column_search, $order, $where),
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

    public function add_konten()
    {
        $ContentModel = new ContentModel();
        $data = [
            'title' => $this->request->getPost('title'),
            'body' => $this->request->getPost('body'),  // Konten dengan HTML TinyMCE
        ];
        $ContentModel->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function get_konten($id)
    {
        $ContentModel = new ContentModel();
        $konten = $ContentModel->find($id);
        return $this->response->setJSON($konten);
    }

public function update_konten()
{
    $contentModel = new ContentModel();

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
        'body' => $body
    ];

    $contentModel->update($id, $data);

    // Kirimkan respons sukses
    return $this->response->setJSON(['status' => 'success', 'message' => 'Konten berhasil diperbarui']);
}


    public function delete_konten($id)
    {
        $ContentModel = new ContentModel();
        $ContentModel->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}
