<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class RateLimit implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $throttle = Services::throttler();
        $ip = $request->getIPAddress();
        
        // Login: 5 requests per minute
        if ($request->getPath() === 'login/process') {
            if ($throttle->check($ip, 60, MINUTE) === false) {
                return Services::response()->setStatusCode(429)->setJSON([
                    'error' => 'Terlalu banyak percobaan. Silakan tunggu sebentar.'
                ]);
            }
        }
        
        // Register: 3 requests per minute
        if ($request->getPath() === 'register/process') {
            if ($throttle->check($ip, 3, MINUTE) === false) {
                return Services::response()->setStatusCode(429)->setJSON([
                    'error' => 'Terlalu banyak percobaan. Silakan tunggu sebentar.'
                ]);
            }
        }
        
        // API: 60 requests per minute
        if (str_starts_with($request->getPath(), 'api/')) {
            if ($throttle->check($ip, 60, MINUTE) === false) {
                return Services::response()->setStatusCode(429)->setJSON([
                    'error' => 'Terlalu banyak request API. Silakan tunggu sebentar.'
                ]);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
