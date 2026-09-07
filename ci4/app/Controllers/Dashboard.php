<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $orderModel = new \App\Models\MdlOrder();
        $customerId = session()->get('customer')['id'];
        
        $data['totalOrders'] = $orderModel->where('customer_id', $customerId)->countAllResults();
        $data['activeOrders'] = $orderModel->where('customer_id', $customerId)->whereIn('status', ['pending', 'processing', 'shipped'])->countAllResults();
        $data['totalSpent'] = $orderModel->selectSum('grand_total')->where('customer_id', $customerId)->where('status', 'completed')->first();
        $data['recentOrders'] = $orderModel->where('customer_id', $customerId)->orderBy('created_at', 'DESC')->limit(5)->findAll();
        
        $data['content'] = view('home/content/dashboard', $data);
        return view('home/layout', $data);
    }

    public function orders()
    {
        $this->checkAuth();
        
        $orderModel = new \App\Models\MdlOrder();
        $customerId = session()->get('customer')['id'];
        
        $data['orders'] = $orderModel->where('customer_id', $customerId)->orderBy('created_at', 'DESC')->findAll();
        
        $data['content'] = view('home/content/dashboard-orders', $data);
        return view('home/layout', $data);
    }

    public function orderDetail($id)
    {
        $this->checkAuth();
        
        $orderModel = new \App\Models\MdlOrder();
        $orderListModel = new \App\Models\MdlOrderList();
        $customerId = session()->get('customer')['id'];
        
        $data['order'] = $orderModel->where('id', $id)->where('customer_id', $customerId)->first();
        
        if (!$data['order']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data['items'] = $orderListModel->where('id_order', $id)->findAll();
        
        $data['content'] = view('home/content/dashboard-order-detail', $data);
        return view('home/layout', $data);
    }

    public function profile()
    {
        $this->checkAuth();
        
        $data['customer'] = session()->get('customer');
        
        $data['content'] = view('home/content/dashboard-profile', $data);
        return view('home/layout', $data);
    }

    public function updateProfile()
    {
        $this->checkAuth();
        
        $rules = [
            'name' => 'required|min_length[3]',
            'phone' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $customerId = session()->get('customer')['id'];
        $clientModel = new \App\Models\MdlClient();
        
        $updateData = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
        ];

        // Update password if provided
        $password = $this->request->getPost('password');
        if ($password) {
            $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $clientModel->update($customerId, $updateData);

        // Update session
        $client = $clientModel->find($customerId);
        session()->set('customer', $client);

        return redirect()->back()->with('success', 'Profil berhasil diupdate.');
    }

    private function checkAuth()
    {
        if (!session()->get('customer')) {
            return redirect()->to('login');
        }
    }
}


