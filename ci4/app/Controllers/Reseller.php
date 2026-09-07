<?php

namespace App\Controllers;

use App\Models\MdlClient;
use App\Models\MdlProduct;
use App\Models\MdlReseller;
use App\Models\MdlResellerQuote;
use App\Models\MdlResellerQuoteItem;
use CodeIgniter\HTTP\RedirectResponse;

class Reseller extends BaseController
{
    public function index()
    {
        $data['featuredProducts'] = (new MdlProduct())
            ->where('product_type', 'reseller')
            ->where('status', 1)
            ->where('deleted_at', null)
            ->limit(4)
            ->findAll();
        $data['content'] = view('home/content/reseller/landing', $data);

        return view('home/layout', $data);
    }

    public function register()
    {
        if (session()->get('customer')) {
            return redirect()->to('reseller/dashboard');
        }

        $data['content'] = view('home/content/reseller/register');
        return view('home/layout', $data);
    }

    public function registerStore()
    {
        $rules = [
            'owner_name' => 'required|min_length[3]|max_length[150]',
            'business_name' => 'required|min_length[3]|max_length[150]',
            'email' => 'required|valid_email|is_unique[client.email]',
            'whatsapp' => 'required|min_length[9]|max_length[30]',
            'city' => 'required|max_length[100]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'terms' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $ownerName = trim((string) $this->request->getPost('owner_name'));
        $nameParts = preg_split('/\s+/', $ownerName, 2) ?: [$ownerName];
        $clientModel = new MdlClient();
        $resellerModel = new MdlReseller();
        $database = \Config\Database::connect();
        $database->transStart();

        $clientId = $clientModel->insert([
            'name' => $ownerName,
            'nama_depan' => $nameParts[0] ?? $ownerName,
            'nama_belakang' => $nameParts[1] ?? '',
            'email' => strtolower(trim((string) $this->request->getPost('email'))),
            'phone' => trim((string) $this->request->getPost('whatsapp')),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'account_type' => 'reseller',
            'status' => 1,
        ], true);

        $resellerModel->insert([
            'client_id' => $clientId,
            'code' => $this->generateResellerCode(),
            'business_name' => trim((string) $this->request->getPost('business_name')),
            'owner_name' => $ownerName,
            'whatsapp' => trim((string) $this->request->getPost('whatsapp')),
            'city' => trim((string) $this->request->getPost('city')),
            'address' => trim((string) $this->request->getPost('address')),
            'sales_channel' => trim((string) $this->request->getPost('sales_channel')),
            'status' => 'pending',
        ]);

        $database->transComplete();
        if (!$database->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'Pendaftaran belum dapat disimpan. Silakan coba kembali.');
        }

        $client = $clientModel->find($clientId);
        session()->set('customer', $client);

        return redirect()->to('reseller/dashboard')->with('success', 'Pendaftaran diterima dan sedang menunggu persetujuan admin.');
    }

    public function dashboard()
    {
        $access = $this->resellerAccess();
        if ($access instanceof RedirectResponse) {
            return $access;
        }

        $quoteModel = new MdlResellerQuote();
        $resellerId = (int) $access['reseller']['id'];
        $data = $access;
        $data['quoteCount'] = $quoteModel->where('reseller_id', $resellerId)->countAllResults();
        $data['acceptedCount'] = $quoteModel->where('reseller_id', $resellerId)->whereIn('status', ['accepted', 'ordered'])->countAllResults();
        $data['sellingTotal'] = (float) (($quoteModel->selectSum('selling_total')->where('reseller_id', $resellerId)->whereIn('status', ['accepted', 'ordered'])->first()['selling_total'] ?? 0));
        $data['recentQuotes'] = $quoteModel->where('reseller_id', $resellerId)->orderBy('created_at', 'DESC')->limit(5)->findAll();
        $data['content'] = view('home/content/reseller/dashboard', $data);

        return view('home/layout', $data);
    }

    public function products()
    {
        $access = $this->resellerAccess(true);
        if ($access instanceof RedirectResponse) {
            return $access;
        }

        $productModel = new MdlProduct();
        $search = trim((string) $this->request->getGet('search'));
        $productModel->where('product_type', 'reseller')->where('status', 1)->where('deleted_at', null);
        if ($search !== '') {
            $productModel->groupStart()->like('nama', $search)->orLike('sku', $search)->orLike('material', $search)->groupEnd();
        }

        $data = $access;
        $data['products'] = $productModel->orderBy('nama', 'ASC')->paginate(12);
        $data['pager'] = $productModel->pager;
        $data['search'] = $search;
        $data['content'] = view('home/content/reseller/products', $data);

        return view('home/layout', $data);
    }

    public function quotes()
    {
        $access = $this->resellerAccess(true);
        if ($access instanceof RedirectResponse) {
            return $access;
        }

        $quoteModel = new MdlResellerQuote();
        $data = $access;
        $data['quotes'] = $quoteModel->where('reseller_id', $access['reseller']['id'])->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('home/content/reseller/quotes', $data);

        return view('home/layout', $data);
    }

    public function quoteCreate()
    {
        $access = $this->resellerAccess(true);
        if ($access instanceof RedirectResponse) {
            return $access;
        }

        $data = $access;
        $data['products'] = (new MdlProduct())
            ->where('product_type', 'reseller')
            ->where('status', 1)
            ->where('deleted_at', null)
            ->where('base_price >', 0)
            ->orderBy('nama', 'ASC')
            ->findAll();
        $data['content'] = view('home/content/reseller/quote-form', $data);

        return view('home/layout', $data);
    }

    public function quoteStore()
    {
        $access = $this->resellerAccess(true);
        if ($access instanceof RedirectResponse) {
            return $access;
        }

        if (!$this->validate([
            'customer_name' => 'required|min_length[3]|max_length[150]',
            'customer_phone' => 'permit_empty|max_length[30]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productIds = (array) $this->request->getPost('product_id');
        $quantities = (array) $this->request->getPost('quantity');
        $sellingPrices = (array) $this->request->getPost('selling_price');
        $colors = (array) $this->request->getPost('color');
        $sizes = (array) $this->request->getPost('size');

        if ($productIds === []) {
            return redirect()->back()->withInput()->with('error', 'Tambahkan minimal satu produk pada nota.');
        }

        $productModel = new MdlProduct();
        $items = [];
        $baseTotal = 0.0;
        $sellingTotal = 0.0;

        foreach ($productIds as $index => $productId) {
            $product = $productModel->where('id', (int) $productId)
                ->where('product_type', 'reseller')->where('status', 1)->where('deleted_at', null)->first();

            if (!$product) {
                return redirect()->back()->withInput()->with('error', 'Salah satu produk tidak tersedia.');
            }

            $quantity = max(1, (int) ($quantities[$index] ?? 1));
            $basePrice = (float) $product['base_price'];
            $sellingPrice = (float) ($sellingPrices[$index] ?? 0);
            if ($basePrice <= 0 || $sellingPrice < $basePrice) {
                return redirect()->back()->withInput()->with('error', 'Harga jual tidak boleh lebih rendah dari harga dasar.');
            }
            if ($quantity < (int) $product['min_order']) {
                return redirect()->back()->withInput()->with('error', 'Jumlah pesanan belum memenuhi minimal order produk ' . $product['nama'] . '.');
            }

            $color = trim((string) ($colors[$index] ?? ''));
            $size = trim((string) ($sizes[$index] ?? ''));
            if (!$this->optionAllowed($color, (string) $product['available_colors']) || !$this->optionAllowed($size, (string) $product['available_sizes'])) {
                return redirect()->back()->withInput()->with('error', 'Pilihan warna atau ukuran tidak valid.');
            }

            $baseTotal += $basePrice * $quantity;
            $sellingTotal += $sellingPrice * $quantity;
            $items[] = [
                'product_id' => (int) $product['id'],
                'product_name' => $product['nama'],
                'material' => $product['material'],
                'model_name' => $product['model_name'],
                'color' => $color,
                'size' => $size,
                'quantity' => $quantity,
                'base_price' => $basePrice,
                'selling_price' => $sellingPrice,
                'subtotal' => $sellingPrice * $quantity,
            ];
        }

        $quoteModel = new MdlResellerQuote();
        $itemModel = new MdlResellerQuoteItem();
        $database = \Config\Database::connect();
        $database->transStart();
        $quoteId = $quoteModel->insert([
            'reseller_id' => $access['reseller']['id'],
            'quote_number' => $this->generateQuoteNumber($access['reseller']['code']),
            'customer_name' => trim((string) $this->request->getPost('customer_name')),
            'customer_phone' => trim((string) $this->request->getPost('customer_phone')),
            'customer_address' => trim((string) $this->request->getPost('customer_address')),
            'notes' => trim((string) $this->request->getPost('notes')),
            'status' => 'draft',
            'base_total' => $baseTotal,
            'selling_total' => $sellingTotal,
        ], true);
        foreach ($items as $item) {
            $item['quote_id'] = $quoteId;
            $itemModel->insert($item);
        }
        $database->transComplete();

        if (!$database->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'Nota gagal disimpan.');
        }

        return redirect()->to('reseller/quotes/' . $quoteId)->with('success', 'Nota berhasil dibuat.');
    }

    public function quoteDetail(int $id)
    {
        $access = $this->resellerAccess(true);
        if ($access instanceof RedirectResponse) {
            return $access;
        }

        $quote = (new MdlResellerQuote())->where('id', $id)->where('reseller_id', $access['reseller']['id'])->first();
        if (!$quote) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = $access;
        $data['quote'] = $quote;
        $data['items'] = (new MdlResellerQuoteItem())->where('quote_id', $id)->findAll();
        $data['content'] = view('home/content/reseller/quote-detail', $data);

        return view('home/layout', $data);
    }

    public function quoteStatus(int $id)
    {
        $access = $this->resellerAccess(true);
        if ($access instanceof RedirectResponse) {
            return $access;
        }

        $quoteModel = new MdlResellerQuote();
        $quote = $quoteModel->where('id', $id)->where('reseller_id', $access['reseller']['id'])->first();
        $status = (string) $this->request->getPost('status');
        if (!$quote || !in_array($status, ['draft', 'sent', 'accepted', 'cancelled'], true)) {
            return redirect()->back()->with('error', 'Status nota tidak valid.');
        }

        $quoteModel->update($id, ['status' => $status]);
        return redirect()->back()->with('success', 'Status nota diperbarui.');
    }

    private function resellerAccess(bool $approvedOnly = false): array|RedirectResponse
    {
        $customer = session()->get('customer');
        if (!$customer) {
            return redirect()->to('login')->with('error', 'Silakan masuk untuk membuka dashboard reseller.');
        }

        $reseller = (new MdlReseller())->where('client_id', $customer['id'])->first();
        if (!$reseller) {
            return redirect()->to('reseller/register')->with('error', 'Akun ini belum terdaftar sebagai reseller.');
        }
        if ($approvedOnly && $reseller['status'] !== 'approved') {
            return redirect()->to('reseller/dashboard')->with('error', 'Fitur ini tersedia setelah akun disetujui admin.');
        }

        return ['customer' => $customer, 'reseller' => $reseller];
    }

    private function generateResellerCode(): string
    {
        do {
            $code = 'RSL-' . date('ym') . '-' . strtoupper(bin2hex(random_bytes(3)));
        } while ((new MdlReseller())->where('code', $code)->countAllResults() > 0);

        return $code;
    }

    private function generateQuoteNumber(string $resellerCode): string
    {
        return 'NT-' . preg_replace('/[^A-Z0-9]/', '', strtoupper($resellerCode)) . '-' . date('ymd-His') . '-' . random_int(10, 99);
    }

    private function optionAllowed(string $selected, string $available): bool
    {
        if ($selected === '' || trim($available) === '') {
            return true;
        }

        $options = array_map('trim', explode(',', mb_strtolower($available)));
        return in_array(mb_strtolower($selected), $options, true);
    }
}
