<?php

namespace App\Controllers;

use App\Models\VisiMisiModel;
use CodeIgniter\Controller;

class VisiMisiController extends Controller
{


       public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'visi_misi.visi','visi_misi.misi','visi_misi.id');
    $column_search = array('visi_misi.visi','visi_misi.misi',);
    $order = array('visi_misi.id' => 'desc');
    $list = $list_data->get_datatables('visi_misi', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->visi;
      $row[] = $lists->misi;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('visi_misi', $where),
      "recordsFiltered" => $list_data->count_filtered('visi_misi', $column_order, $column_search, $order, $where),
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
        $VisiMisiModel = new VisiMisiModel();
        $data = [
            'visi' => $this->request->getPost('visi'),
            'misi' => $this->request->getPost('misi'),  // Konten dengan HTML TinyMCE
        ];
        $VisiMisiModel->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function get($id)
    {
        $VisiMisiModel = new VisiMisiModel();
        $konten = $VisiMisiModel->find($id);
        return $this->response->setJSON($konten);
    }

public function update()
{
    $VisiMisiModel = new VisiMisiModel();

    // Dapatkan data dari request POST
    $id = $this->request->getPost('id');
    $visi = $this->request->getPost('visi');
    $misi = $this->request->getPost('misi');

    // Validasi input jika diperlukan
    if (!$id || !$visi || !$misi) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }

    // Update data konten di database
    $data = [
        'visi' => $visi,
        'misi' => $misi
    ];

    $VisiMisiModel->update($id, $data);

    // Kirimkan respons sukses
    return $this->response->setJSON(['status' => 'success', 'message' => 'Visi misi berhasil diperbarui']);
}


    public function delete($id)
    {
        $VisiMisiModel = new VisiMisiModel();
        $VisiMisiModel->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}