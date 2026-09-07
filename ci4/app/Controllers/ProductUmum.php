<?php

namespace App\Controllers;

class ProductUmum extends BaseController
{
    public function index()
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $data['content'] = view('admin/content/product-umum');
        return view('admin/layout', $data);
    }

    public function listdata()
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $serverside_model = new \App\Models\Mdl_datatables();
        $request = \Config\Services::request();
        $list_data = $serverside_model;
        $where = ['id !=' => 0, 'deleted_at'=>NULL];
        $column_order = array(NULL,'product_umum.nama','product_umum.harga','product_umum.stok','product_umum.status','product_umum.id');
        $column_search = array('product_umum.nama','product_umum.kategori');
        $order = array('product_umum.id' => 'desc');
        $list = $list_data->get_datatables('product_umum', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            $row[] = $no;
            $row[] = $lists->id;
            $row[] = $lists->nama;
            $row[] = 'Rp '.number_format($lists->harga,0,',','.');
            $row[] = $lists->stok;
            $row[] = $lists->status == 1 ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>';
            $row[] = '<button class="btn btn-sm btn-primary" onclick="editData('.$lists->id.')">Edit</button> <button class="btn btn-sm btn-danger" onclick="hapusData('.$lists->id.')">Hapus</button>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('product_umum', $where),
            "recordsFiltered" => $list_data->count_filtered('product_umum', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
        return json_encode($output);
    }

    public function create()
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $rules = [
            'nama' => 'required',
            'harga' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $model = new \App\Models\MdlProductUmum();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'slug' => url_title($this->request->getPost('nama'), '-', TRUE),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'harga_diskon' => $this->request->getPost('harga_diskon') ?: NULL,
            'stok' => $this->request->getPost('stok') ?: 0,
            'kategori' => $this->request->getPost('kategori'),
            'status' => $this->request->getPost('status') ?: 1,
        ];
        // Handle image upload
        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move('assets/upload/image', $newName);
            $data['gambar'] = $newName;
        }
        if ($model->insert($data)) {
            return redirect()->to('admin/product-umum')->with('success', 'Produk berhasil ditambahkan');
        }
        return redirect()->back()->with('error', 'Gagal menambahkan produk');
    }

    public function update($id)
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $rules = [
            'nama' => 'required',
            'harga' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $model = new \App\Models\MdlProductUmum();
        $data = [
            'nama' => $this->request->getPost('nama'),
            'slug' => url_title($this->request->getPost('nama'), '-', TRUE),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'harga_diskon' => $this->request->getPost('harga_diskon') ?: NULL,
            'stok' => $this->request->getPost('stok') ?: 0,
            'kategori' => $this->request->getPost('kategori'),
            'status' => $this->request->getPost('status') ?: 1,
        ];
        // Handle image upload
        $gambar = $this->request->getFile('gambar');
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move('assets/upload/image', $newName);
            $data['gambar'] = $newName;
        }
        if ($model->update($id, $data)) {
            return redirect()->to('admin/product-umum')->with('success', 'Produk berhasil diupdate');
        }
        return redirect()->back()->with('error', 'Gagal update produk');
    }

    public function delete($id)
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $model = new \App\Models\MdlProductUmum();
        $model->delete($id);
        return redirect()->to('admin/product-umum')->with('success', 'Produk berhasil dihapus');
    }

    public function detail($id)
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $model = new \App\Models\MdlProductUmum();
        $data['product'] = $model->find($id);
        return view('admin/content/product-umum-detail', $data);
    }
}


