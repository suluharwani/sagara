<?php

namespace App\Controllers;

class Payment extends BaseController
{
    public function index($orderNumber)
    {
        $orderModel = new \App\Models\MdlOrder();
        $order = $orderModel->where('order_number', $orderNumber)->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['order'] = $order;
        $data['content'] = view('home/content/payment', $data);
        return view('home/layout', $data);
    }

    public function pay()
    {
        $orderId = $this->request->getPost('order_id');
        
        $orderModel = new \App\Models\MdlOrder();
        $order = $orderModel->find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan');
        }

        // Midtrans configuration
        $midtransConfig = new \Config\Payment();
        
        // Create transaction
        $transactionDetails = [
            'order_id' => $order['order_number'],
            'gross_amount' => (int) $order['grand_total'],
        ];

        $customerDetails = [
            'first_name' => $order['name'],
            'phone' => $order['phone'],
        ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            $data['snapToken'] = $snapToken;
            $data['order'] = $order;
            $data['content'] = view('home/content/payment', $data);
            return view('home/layout', $data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    public function notification()
    {
        // Handle Midtrans notification
        $notif = new \Midtrans\Notification();
        
        $orderModel = new \App\Models\MdlOrder();
        $order = $orderModel->where('order_number', $notif->order_id)->first();

        if ($order) {
            $transactionStatus = $notif->transaction_status;
            
            $status = match($transactionStatus) {
                'settlement', 'capture' => 'paid',
                'pending' => 'pending',
                'expire' => 'expired',
                'cancel', 'deny' => 'cancelled',
                default => 'pending',
            };

            $orderModel->update($order['id'], ['status' => $status]);
        }

        return $this->response->setJSON(['status' => 'ok']);
    }

    public function finish()
    {
        return redirect()->to('tracking')->with('success', 'Pembayaran berhasil!');
    }

    public function unfailed()
    {
        return redirect()->to('tracking')->with('warning', 'Pembayaran pending. Silakan selesaikan pembayaran.');
    }

    public function error()
    {
        return redirect()->to('tracking')->with('error', 'Pembayaran gagal. Silakan coba lagi.');
    }
}


