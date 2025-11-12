<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            // Jika belum, tendang ke halaman login
            return redirect()->to(site_url('login'));
        }

        // Cek apakah rolenya 'admin'
        if (session()->get('role') !== 'admin') {
            // Jika bukan admin, hancurkan session dan tendang ke login
            session()->destroy();
            return redirect()->to(site_url('login'))->with('error', 'Anda tidak memiliki hak akses.');
        }

        // Jika lolos semua, lanjutkan
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah request
    }
}