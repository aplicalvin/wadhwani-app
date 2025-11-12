<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    /**
     * Menampilkan halaman form login
     */
    public function login()
    {
        // Jika user sudah login, tendang ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(site_url('admin/dashboard'));
        }

        return view('admin/auth/login');
    }

    /**
     * Memproses upaya login
     */
    public function attemptLogin()
    {
        // 1. Validasi input
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Cek kredensial
        $model = new UserModel();
        $user = $model->where('email', $this->request->getPost('email'))->first();

        // 3. Cek user ada & password cocok
        if (!$user || !password_verify($this->request->getPost('password'), $user->password)) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        // 4. Cek jika dia adalah admin
        if ($user->role !== 'admin') {
            return redirect()->back()->withInput()->with('error', 'Anda tidak memiliki hak akses admin.');
        }

        // 5. Set Session
        $sessionData = [
            'user_id'    => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'role'       => $user->role,
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        // 6. Redirect ke dashboard
        return redirect()->to(site_url('admin/dashboard'));
    }

    /**
     * Memproses logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'));
    }
}