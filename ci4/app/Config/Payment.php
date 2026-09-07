<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Payment extends BaseConfig
{
    public string $merchantId = '';
    public string $clientKey = '';
    public string $serverKey = '';
    public bool $isProduction = false;
    public bool $isSanitized = true;
    public bool $is3ds = true;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->merchantId = env('MIDTRANS_MERCHANT_ID', '');
        $this->clientKey = env('MIDTRANS_CLIENT_KEY', '');
        $this->serverKey = env('MIDTRANS_SERVER_KEY', '');
        $this->isProduction = env('MIDTRANS_IS_PRODUCTION', false);
    }
}
