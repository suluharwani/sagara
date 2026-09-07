<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;

class Shipping extends Controller
{
    public function provinces()
    {
        $rajaOngkir = new \App\Libraries\RajaOngkir();
        $provinces = $rajaOngkir->getProvinces();
        return $this->response->setJSON($provinces);
    }

    public function cities($provinceId = 0)
    {
        $rajaOngkir = new \App\Libraries\RajaOngkir();
        $cities = $rajaOngkir->getCities($provinceId);
        return $this->response->setJSON($cities);
    }

    public function cost()
    {
        $origin = $this->request->getPost('origin');
        $destination = $this->request->getPost('destination');
        $weight = $this->request->getPost('weight') ?? 1000;
        $courier = $this->request->getPost('courier');

        $rajaOngkir = new \App\Libraries\RajaOngkir();
        $costs = $rajaOngkir->calculateCost($origin, $destination, $weight, $courier);
        return $this->response->setJSON($costs);
    }

    public function track()
    {
        $waybill = $this->request->getPost('waybill');
        $courier = $this->request->getPost('courier');

        $rajaOngkir = new \App\Libraries\RajaOngkir();
        $result = $rajaOngkir->trackWaybill($waybill, $courier);
        return $this->response->setJSON($result);
    }
}
