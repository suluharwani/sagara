<?php

namespace App\Controllers;

class Report extends BaseController
{
    public function index()
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $orderModel = new \App\Models\MdlOrder();
        
        $revenueResult = $orderModel->selectSum('grand_total')->where('status', 2)->first();
        $data['totalRevenue'] = $revenueResult['grand_total'] ?? 0;
        $data['totalOrders'] = $orderModel->countAllResults();
        $data['pendingOrders'] = $orderModel->where('status', 0)->countAllResults();
        $data['processingOrders'] = $orderModel->where('status', 1)->countAllResults();
        $data['completedOrders'] = $orderModel->where('status', 2)->countAllResults();
        $data['processOrders'] = $orderModel->where('status', 1)->countAllResults();
        
        $data['orders'] = $orderModel->orderBy('created_at', 'DESC')->limit(50)->findAll();
        
        $data['content'] = view('admin/content/report', $data);
        return view('admin/layout', $data);
    }

    public function product()
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $productModel = new \App\Models\MdlProduct();
        $data['products'] = $productModel->where('deleted_at', null)->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/report-product', $data);
        return view('admin/layout', $data);
    }

    public function order()
    {
        $check = new \App\Controllers\CheckAccess();
        $check->logged();
        
        $orderModel = new \App\Models\MdlOrder();
        $data['orders'] = $orderModel->orderBy('created_at', 'DESC')->findAll();
        $data['content'] = view('admin/content/report-order', $data);
        return view('admin/layout', $data);
    }

    public function exportExcel()
    {
        $orderModel = new \App\Models\MdlOrder();
        $orders = $orderModel->orderBy('created_at', 'DESC')->findAll();
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Order');
        $sheet->setCellValue('C1', 'Tanggal');
        $sheet->setCellValue('D1', 'Nama Tim');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Total');
        
        $row = 2;
        foreach ($orders as $i => $order) {
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $order['kode'] ?? '-');
            $sheet->setCellValue('C' . $row, $order['created_at'] ?? '-');
            $sheet->setCellValue('D' . $row, $order['nama_tim'] ?? '-');
            $sheet->setCellValue('E' . $row, $order['status'] ?? '-');
            $sheet->setCellValue('F' . $row, $order['total'] ?? 0);
            $row++;
        }
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laporan-order.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}