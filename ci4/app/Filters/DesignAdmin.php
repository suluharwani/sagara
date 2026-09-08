<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DesignAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = session()->get('auth');
        if (!session()->get('logged') || !is_array($auth) || empty($auth['id'])) {
            if ($request->isAJAX()) {
                return service('response')->setStatusCode(401)->setJSON(['error' => 'Sesi admin berakhir. Silakan masuk kembali.']);
            }
            return redirect()->to('admin/login');
        }
        // Follow the application's administrator role; a customer login is not admin access.
        if ((int) ($auth['level'] ?? 0) !== 1 || \Config\Database::connect()->table('user')->where('id', $auth['id'])->where('level', 1)->where('status', 1)->where('deleted_at', null)->countAllResults() !== 1) {
            return service('response')->setStatusCode(403)->setJSON(['error' => 'Halaman ini khusus administrator aktif.']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $response->setHeader('Cache-Control', 'no-store, private');
    }
}
