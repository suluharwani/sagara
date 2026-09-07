<?php

namespace App\Controllers;

class Checkout extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        
        if (count($cart) == 0) {
            return redirect()->to('cart')->with('error', 'Keranjang belanja kosong');
        }

        $data['cart'] = $cart;
        $data['total'] = $this->calculateTotal($cart);
        $data['content'] = view('home/content/checkout', $data);
        return view('home/layout', $data);
    }

    public function process()
    {
        $cart = session()->get('cart') ?? [];
        
        if (count($cart) == 0) {
            return redirect()->to('cart')->with('error', 'Keranjang belanja kosong');
        }

        // Validation rules
        $rules = [
            'name' => 'required|min_length[3]',
            'phone' => 'required|min_length[10]',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'courier' => 'required',
            'payment_method' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $orderData = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'province' => $this->request->getPost('province'),
            'city' => $this->request->getPost('city'),
            'postal_code' => $this->request->getPost('postal_code'),
            'courier' => $this->request->getPost('courier'),
            'payment_method' => $this->request->getPost('payment_method'),
            'note' => $this->request->getPost('note'),
            'total' => $this->calculateTotal($cart),
            'shipping_cost' => 0,
            'grand_total' => $this->calculateTotal($cart),
            'status' => 'pending',
            'order_number' => 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5(time()), 0, 6)),
        ];

        // Save order to database
        $orderModel = new \App\Models\MdlOrder();
        $orderId = $orderModel->insert($orderData);

        // Save order items
        $orderListModel = new \App\Models\MdlOrderList();
        foreach ($cart as $item) {
            $orderListModel->insert([
                'id_order' => $orderId,
                'id_product' => $item['id'],
                'size' => $item['size'],
                'price' => $item['price'],
                'quantity' => $item['qty'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Clear cart
        session()->remove('cart');

        return redirect()->to('checkout/success/' . $orderData['order_number']);
    }

    public function success($orderNumber)
    {
        $orderModel = new \App\Models\MdlOrder();
        $data['order'] = $orderModel->where('order_number', $orderNumber)->first();

        if (!$data['order']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['content'] = view('home/content/checkout-success', $data);
        return view('home/layout', $data);
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['subtotal'];
        }
        return $total;
    }
}


