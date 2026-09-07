<?php

namespace App\Controllers;

class Tracking extends BaseController
{
    public function index()
    {
        $data['content'] = view('home/content/tracking');
        return view('home/layout', $data);
    }

    public function search()
    {
        $rules = [
            'order_number' => 'required',
            'email' => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $orderModel = new \App\Models\MdlOrder();
        $order = $orderModel->where('order_number', $this->request->getPost('order_number'))
                            ->where('email', $this->request->getPost('email'))
                            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan. Pastikan nomor order dan email benar.');
        }

        $historyModel = new \App\Models\MdlOrderStatusHistory();
        $data['order'] = $order;
        $data['history'] = $historyModel->where('order_id', $order['id'])->orderBy('created_at', 'DESC')->findAll();

        $data['content'] = view('home/content/tracking-result', $data);
        return view('home/layout', $data);
    }
}


