<?php

namespace App\Controllers;

use App\Models\KeuanganModel;
use CodeIgniter\Controller;

class KeuanganController extends Controller
{


     public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(NULL,'keuangan.tanggal','keuangan.tipe','keuangan.deskripsi','keuangan.jumlah','keuangan.id');
    $column_search = array('keuangan.deskripsi');
    $order = array('keuangan.id' => 'desc');
    $list = $list_data->get_datatables('keuangan', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->tanggal;
      $row[] = $lists->tipe;
      $row[] = $lists->deskripsi;
      $row[] = $lists->jumlah;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('keuangan', $where),
      "recordsFiltered" => $list_data->count_filtered('keuangan', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }
    // Menambahkan data keuangan baru
    public function add()
    {
        $model = new KeuanganModel();
        $data = [
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jumlah' => $this->request->getPost('jumlah'),
            'tipe' => $this->request->getPost('tipe'),  // Tipe: Pemasukan atau Pengeluaran
            'tanggal' => $this->request->getPost('tanggal')
        ];

        $model->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Mengambil data keuangan berdasarkan ID
    public function get($id)
    {
        $model = new KeuanganModel();
        $keuangan = $model->find($id);
        return $this->response->setJSON($keuangan);
    }
    public function getAll()
    {
        $model = new KeuanganModel();
        $keuangan = $model->findAll();
        return $this->response->setJSON($keuangan);
    }
    // Memperbarui data keuangan
    public function update()
    {
        $model = new KeuanganModel();
        $id = $this->request->getPost('id');
        $data = [
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jumlah' => $this->request->getPost('jumlah'),
            'tipe' => $this->request->getPost('tipe'),  // Tipe: Pemasukan atau Pengeluaran
            'tanggal' => $this->request->getPost('tanggal')
        ];

        $model->update($id, $data);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Menghapus data keuangan berdasarkan ID
    public function delete($id)
    {
        $model = new KeuanganModel();
        $model->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}
