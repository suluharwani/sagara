<?php

namespace App\Controllers;

use App\Models\PengisiAcaraModel;
use CodeIgniter\Controller;

class PengisiAcaraController extends Controller
{
         public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'pengisi_acara.nama_pengisi','pengisi_acara.acara','pengisi_acara.tanggal');
    $column_search = array('pengisi_acara.nama_pengisi','pengisi_acara.acara');
    $order = array('pengisi_acara.id' => 'desc');
    $list = $list_data->get_datatables('pengisi_acara', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->nama_pengisi;
      $row[] = $lists->acara;
      $row[] = $lists->tanggal;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('pengisi_acara', $where),
      "recordsFiltered" => $list_data->count_filtered('pengisi_acara', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }



    // Menambahkan pengisi acara baru
    public function add()
    {
        $model = new PengisiAcaraModel();
        $data = [
            'nama_pengisi' => $this->request->getPost('nama_pengisi'),
            'acara' => $this->request->getPost('acara'),
            'tanggal' => $this->request->getPost('tanggal')  // Tanggal dan waktu
        ];

        $model->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Mengambil data pengisi acara berdasarkan ID
    public function get($id)
    {
        $model = new PengisiAcaraModel();
        $pengisi = $model->find($id);
        return $this->response->setJSON($pengisi);
    }

    // Memperbarui pengisi acara
    public function update()
    {
        $model = new PengisiAcaraModel();
        $id = $this->request->getPost('id');
        $data = [
            'nama_pengisi' => $this->request->getPost('nama_pengisi'),
            'acara' => $this->request->getPost('acara'),
            'tanggal' => $this->request->getPost('tanggal')  // Tanggal dan waktu
        ];

        $model->update($id, $data);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Menghapus pengisi acara berdasarkan ID
    public function delete($id)
    {
        $model = new PengisiAcaraModel();
        $model->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}
