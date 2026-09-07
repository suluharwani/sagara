<?php

namespace App\Libraries;

use Config\Shipping as ShippingConfig;

class RajaOngkir
{
    protected string $apiKey;
    protected string $baseUrl;
    protected array $headers;

    public function __construct()
    {
        $config = new ShippingConfig();
        $this->apiKey = $config->apiKey;
        $this->baseUrl = $config->getBaseUrl();
        $this->headers = [
            'key: ' . $this->apiKey,
            'Content-Type: application/x-www-form-urlencoded',
        ];
    }

    public function getProvinces(): array
    {
        $response = $this->request('GET', '/province');
        return $response['rajaongkir']['results'] ?? [];
    }

    public function getCities(int $provinceId = 0): array
    {
        $url = '/city';
        if ($provinceId > 0) {
            $url .= '?province=' . $provinceId;
        }
        $response = $this->request('GET', $url);
        return $response['rajaongkir']['results'] ?? [];
    }

    public function getSubdistricts(int $cityId = 0): array
    {
        $url = '/subdistrict?city=' . $cityId;
        $response = $this->request('GET', $url);
        return $response['rajaongkir']['results'] ?? [];
    }

    public function calculateCost(int $origin, int $destination, int $weight, string $courier): array
    {
        $data = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ];
        $response = $this->request('POST', '/cost', $data);
        return $response['rajaongkir']['results'] ?? [];
    }

    public function trackWaybill(string $waybill, string $courier): array
    {
        $data = [
            'waybill' => $waybill,
            'courier' => $courier,
        ];
        $response = $this->request('POST', '/waybill', $data);
        return $response['rajaongkir']['result'] ?? [];
    }

    protected function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return ['error' => 'HTTP ' . $httpCode];
        }

        return json_decode($response, true) ?? [];
    }
}
