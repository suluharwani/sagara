<?php

namespace App\Controllers;

class Cart extends BaseController
{
    public function index()
    {
        $cart = session()->get('cart') ?? [];
        $data['cart'] = $cart;
        $data['total'] = $this->calculateTotal($cart);
        $data['content'] = view('home/content/cart', $data);
        return view('home/layout', $data);
    }

    public function add()
    {
        $productId = $this->request->getPost('product_id');
        $size = $this->request->getPost('size');
        $color = $this->request->getPost('color');
        $qty = $this->request->getPost('quantity') ?? 1;

        $productModel = new \App\Models\MdlProduct();
        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $cart = session()->get('cart') ?? [];
        $rowid = md5($productId . $size . $color);

        if (isset($cart[$rowid])) {
            $cart[$rowid]['qty'] += $qty;
            $cart[$rowid]['subtotal'] = $cart[$rowid]['qty'] * $cart[$rowid]['price'];
        } else {
            $cart[$rowid] = [
                'id' => $product['id'],
                'name' => $product['nama'],
                'price' => $product['sale_price'] > 0 ? $product['sale_price'] : $product['price'],
                'qty' => $qty,
                'size' => $size,
                'color' => $color,
                'image' => $product['picture'],
                'subtotal' => $qty * ($product['sale_price'] > 0 ? $product['sale_price'] : $product['price']),
            ];
        }

        session()->set('cart', $cart);
        return redirect()->to('cart')->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update()
    {
        $rowid = $this->request->getPost('rowid');
        $qty = $this->request->getPost('quantity');

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$rowid])) {
            $cart[$rowid]['qty'] = $qty;
            $cart[$rowid]['subtotal'] = $cart[$rowid]['qty'] * $cart[$rowid]['price'];
        }

        session()->set('cart', $cart);
        return redirect()->to('cart');
    }

    public function remove($rowid)
    {
        $cart = session()->get('cart') ?? [];
        unset($cart[$rowid]);
        session()->set('cart', $cart);
        return redirect()->to('cart');
    }

    public function count()
    {
        $cart = session()->get('cart') ?? [];
        return $this->response->setJSON(['count' => count($cart)]);
    }

    public function clear()
    {
        session()->remove('cart');
        return redirect()->to('cart');
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


