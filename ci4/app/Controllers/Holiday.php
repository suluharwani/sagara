<?php

namespace App\Controllers;

class Holiday extends BaseController
{
    public function index()
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $holidayModel = new \App\Models\MdlHoliday();
        $holidays = $holidayModel->where('deleted_at', null)->orderBy('holiday_date', 'ASC')->findAll();
        
        $data['holidays'] = $holidays;
        $data['content'] = view('admin/content/holiday', $data);
        return view('admin/layout', $data);
    }

    public function add()
    {
        $holidayModel = new \App\Models\MdlHoliday();
        
        $type = $this->request->getPost('type');
        $color = '#dc3545'; // Default red
        
        if ($type === 'national') {
            $color = '#dc3545'; // Red
        } elseif ($type === 'custom') {
            $color = '#28a745'; // Green
        } elseif ($type === 'replacement') {
            $color = '#1976d2'; // Blue
        }
        
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'holiday_date' => $this->request->getPost('holiday_date'),
            'type' => $type,
            'color' => $this->request->getPost('color') ?? $color,
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];
        
        $holidayModel->insert($data);
        return redirect()->to('admin/holiday')->with('success', 'Hari libur berhasil ditambahkan');
    }

    public function update($id)
    {
        $holidayModel = new \App\Models\MdlHoliday();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'holiday_date' => $this->request->getPost('holiday_date'),
            'type' => $this->request->getPost('type'),
            'color' => $this->request->getPost('color'),
            'is_active' => $this->request->getPost('is_active') ?? 1,
        ];
        
        $holidayModel->update($id, $data);
        return redirect()->to('admin/holiday')->with('success', 'Hari libur berhasil diupdate');
    }

    public function delete($id)
    {
        $holidayModel = new \App\Models\MdlHoliday();
        $holidayModel->delete($id);
        return redirect()->to('admin/holiday')->with('success', 'Hari libur berhasil dihapus');
    }
}