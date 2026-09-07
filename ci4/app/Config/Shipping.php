<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Shipping extends BaseConfig
{
    public string $apiKey = '';
    public string $type = 'starter'; // starter, basic, pro
    public int $originCity = 0; // ID kota asal
    public array $couriers = ['jne', 'tiki', 'pos', 'jnt', 'sicepat', 'anteraja', 'ninja', 'lion', 'rex', 'wahana', 'first', 'ide', 'spx', 'sapa', 'ncs', 'rex', 'sentral', 'pahala', 'cahaya', 'dse', 'slis', 'jtl', 'pemilu', 'ray', 'trawlbens', 'jet', 'pickup', 'paxel', 'kurir'];
    
    public function __construct()
    {
        parent::__construct();
        
        $this->apiKey = env('RAJAONGKIR_API_KEY', '');
        $this->type = env('RAJAONGKIR_TYPE', 'starter');
        $this->originCity = (int) env('RAJAONGKIR_ORIGIN_CITY', 0);
    }
    
    public function getBaseUrl(): string
    {
        return match($this->type) {
            'pro' => 'https://pro.rajaongkir.com/api',
            'basic' => 'https://api.rajaongkir.com/basic',
            default => 'https://api.rajaongkir.com/starter',
        };
    }
}
