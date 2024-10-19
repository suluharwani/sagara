<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use CodeIgniter\Controller;

class JadwalController extends Controller
{
    // Mengambil semua data jadwal untuk DataTables

    public function get_list(){
    $serverside_model = new \App\Models\Mdl_datatables();
    $request = \Config\Services::request();
    $list_data = $serverside_model;
    $where = ['id !=' => 0, 'deleted_at'=>NULL];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
    $column_order = array(null, 'jadwal.nama_kegiatan', 'jadwal.tanggal', 'jadwal.waktu_mulai', 'jadwal.waktu_selesai', 'jadwal.lokasi', 'jadwal.id'); 
        $column_search = array('jadwal.nama_kegiatan', 'jadwal.lokasi');
    $order = array('jadwal.id' => 'desc');
    $list = $list_data->get_datatables('jadwal', $column_order, $column_search, $order, $where);
    $data = array();
    $no = $request->getPost("start");
    foreach ($list as $lists) {
      $no++;
      $row    = array();
      $row[] = $no;
      $row[] = $lists->id;
      $row[] = $lists->nama_kegiatan;
      $row[] = $lists->tanggal;
      $row[] = $lists->waktu_mulai;
      $row[] = $lists->waktu_selesai;
      $row[] = $lists->lokasi;

      $data[] = $row;
    }
    $output = array(
      "draw" => $request->getPost("draw"),
      "recordsTotal" => $list_data->count_all('jadwal', $where),
      "recordsFiltered" => $list_data->count_filtered('jadwal', $column_order, $column_search, $order, $where),
      "data" => $data,
    );

    return json_encode($output);
  }


    // Menambahkan jadwal baru
    public function add()
    {
        $model = new JadwalModel();
        $data = [
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'lokasi' => $this->request->getPost('lokasi')
        ];

        $model->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Mengambil data jadwal berdasarkan ID
    public function get($id)
    {
        $model = new JadwalModel();
        $jadwal = $model->find($id);
        return $this->response->setJSON($jadwal);
    }

    // Memperbarui jadwal
    public function update()
    {
        $model = new JadwalModel();
        $id = $this->request->getPost('id');
        $data = [
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'lokasi' => $this->request->getPost('lokasi'),
        ];

        $model->update($id, $data);

        return $this->response->setJSON(['status' => 'success']);
    }

    // Menghapus jadwal berdasarkan ID
    public function delete($id)
    {
        $model = new JadwalModel();
        $model->delete($id);

        return $this->response->setJSON(['status' => 'success']);
    }
}
