<?php

namespace App\Controllers;

use App\Models\MdlProduct;
use App\Models\MdlReseller;

class AdminReseller extends BaseController
{
    public function __construct()
    {
        helper('form');
        (new CheckAccess())->logged();
    }

    public function index()
    {
        $database = \Config\Database::connect();
        $data['resellers'] = $database->table('resellers')
            ->select('resellers.*, client.email')
            ->join('client', 'client.id = resellers.client_id', 'left')
            ->orderBy('resellers.created_at', 'DESC')
            ->get()->getResultArray();
        $data['counts'] = [];
        foreach (['pending', 'approved', 'rejected', 'suspended'] as $status) {
            $data['counts'][$status] = (new MdlReseller())->where('status', $status)->countAllResults();
        }
        $data['content'] = view('admin/content/resellers', $data);

        return view('admin/layout', $data);
    }

    public function updateStatus(int $id)
    {
        $status = (string) $this->request->getPost('status');
        if (!in_array($status, ['pending', 'approved', 'rejected', 'suspended'], true)) {
            return redirect()->back()->with('error', 'Status reseller tidak valid.');
        }

        $resellerModel = new MdlReseller();
        if (!$resellerModel->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $resellerModel->update($id, [
            'status' => $status,
            'admin_note' => trim((string) $this->request->getPost('admin_note')),
            'approved_at' => $status === 'approved' ? date('Y-m-d H:i:s') : null,
        ]);

        return redirect()->back()->with('success', 'Status reseller berhasil diperbarui.');
    }

    public function products(?int $editId = null)
    {
        $productModel = new MdlProduct();
        $data['products'] = $productModel->where('product_type', 'reseller')->where('deleted_at', null)->orderBy('id', 'DESC')->findAll();
        $data['editingProduct'] = $editId ? $productModel->where('product_type', 'reseller')->find($editId) : null;
        $data['imageOptions'] = $this->imageOptions();
        $data['content'] = view('admin/content/reseller-products', $data);

        return view('admin/layout', $data);
    }

    public function productStore()
    {
        if (!$this->validateProduct()) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $sku = strtoupper(trim((string) $this->request->getPost('sku')));
        if ((new MdlProduct())->where('sku', $sku)->where('deleted_at', null)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'SKU sudah digunakan.');
        }

        (new MdlProduct())->insert($this->productPayload($sku));
        return redirect()->to('admin/reseller-products')->with('success', 'Produk reseller berhasil ditambahkan.');
    }

    public function productUpdate(int $id)
    {
        $productModel = new MdlProduct();
        $product = $productModel->where('product_type', 'reseller')->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if (!$this->validateProduct()) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $sku = strtoupper(trim((string) $this->request->getPost('sku')));
        if ($productModel->where('sku', $sku)->where('id !=', $id)->where('deleted_at', null)->countAllResults() > 0) {
            return redirect()->back()->withInput()->with('error', 'SKU sudah digunakan produk lain.');
        }

        $productModel->update($id, $this->productPayload($sku, $id));
        return redirect()->to('admin/reseller-products')->with('success', 'Produk reseller berhasil diperbarui.');
    }

    public function productDelete(int $id)
    {
        $productModel = new MdlProduct();
        $product = $productModel->where('product_type', 'reseller')->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $productModel->delete($id);
        return redirect()->back()->with('success', 'Produk reseller dinonaktifkan dan tetap tersimpan pada riwayat nota.');
    }

    private function validateProduct(): bool
    {
        return $this->validate([
            'nama' => 'required|min_length[3]|max_length[500]',
            'sku' => 'required|min_length[3]|max_length[100]|alpha_dash',
            'model_name' => 'required|max_length[150]',
            'material' => 'required|max_length[100]',
            'base_price' => 'required|decimal|greater_than[0]',
            'min_order' => 'required|integer|greater_than[0]',
            'lead_time_days' => 'required|integer|greater_than[0]',
            'available_colors' => 'required|max_length[1000]',
            'available_sizes' => 'required|max_length[1000]',
        ]);
    }

    private function productPayload(string $sku, ?int $id = null): array
    {
        $image = basename(trim((string) $this->request->getPost('reseller_image')));
        if ($image !== '' && !is_file(FCPATH . 'assets/images/reseller/' . $image)) {
            $image = '';
        }

        $slugBase = url_title(trim((string) $this->request->getPost('nama')), '-', true);

        return [
            'product_type' => 'reseller',
            'nama' => trim((string) $this->request->getPost('nama')),
            'judul' => trim((string) $this->request->getPost('nama')),
            'sku' => $sku,
            'model_name' => trim((string) $this->request->getPost('model_name')),
            'material' => trim((string) $this->request->getPost('material')),
            'base_price' => (float) $this->request->getPost('base_price'),
            'price' => 0,
            'min_order' => (int) $this->request->getPost('min_order'),
            'lead_time_days' => (int) $this->request->getPost('lead_time_days'),
            'available_colors' => $this->normalizeCsv((string) $this->request->getPost('available_colors')),
            'available_sizes' => $this->normalizeCsv((string) $this->request->getPost('available_sizes')),
            'reseller_image' => $image,
            'description' => trim((string) $this->request->getPost('description')),
            'slug' => $slugBase . ($id ? '-' . $id : '-' . strtolower($sku)),
            'status' => $this->request->getPost('status') === '1' ? 1 : 0,
        ];
    }

    private function normalizeCsv(string $value): string
    {
        $items = array_values(array_unique(array_filter(array_map('trim', explode(',', $value)))));
        return implode(', ', $items);
    }

    private function imageOptions(): array
    {
        $files = glob(FCPATH . 'assets/images/reseller/*.{webp,jpg,jpeg,png}', GLOB_BRACE) ?: [];
        return array_map('basename', $files);
    }
}
