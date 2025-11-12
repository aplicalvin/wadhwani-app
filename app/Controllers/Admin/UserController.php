<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    /**
     * Menampilkan daftar dan menangani modal
     */
    private function showIndex($showModal = null, $modalData = null)
    {
        $model = new UserModel();
        
        $data = [
            'users'      => $model->findAll(),
            'showModal'  => $showModal,
            'modalData'  => $modalData,
            'errors'     => session()->get('errors'),
        ];

        return view('admin/users/index', $data);
    }

    public function index()
    {
        return $this->showIndex();
    }

    public function new()
    {
        return $this->showIndex('new', new \App\Entities\User());
    }

    public function edit($id)
    {
        $model = new UserModel();
        $data = $model->find($id);
        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }
        return $this->showIndex('edit', $data);
    }

    /**
     * Menyimpan data BARU (Create)
     * Password WAJIB diisi dan di-hash
     */
    public function save()
    {
        $rules = [
            'name'     => 'required|string|max_length[100]',
            'email'    => 'required|valid_email|is_unique[users.email]', // Cek unik
            'role'     => 'required|string|max_length[50]',
            'password' => 'required|min_length[8]',
            'password_confirmation' => 'required|matches[password]', // Cek konfirmasi
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('admin/users/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        $data = $this->request->getPost();

        // --- PENTING: HASH PASSWORD ---
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Hapus konfirmasi password, tidak perlu disimpan
        unset($data['password_confirmation']); 

        $model->save($data);
        
        return redirect()->to(site_url('admin/users'))->with('message', 'User berhasil disimpan.');
    }

    /**
     * Memperbarui data (Update)
     * Password OPSIONAL. Hanya di-update jika diisi.
     */
    public function update($id)
    {
        // Validasi email unik, tapi abaikan ID user ini sendiri
        $rules = [
            'name'  => 'required|string|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'  => 'required|string|max_length[50]',
        ];

        // --- Validasi Password Opsional ---
        $password = $this->request->getPost('password');
        if ($password) {
            // Jika password diisi, validasi
            $rules['password'] = 'min_length[8]';
            $rules['password_confirmation'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->to(site_url("admin/users/edit/$id"))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new UserModel();
        
        // Ambil data dasar
        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        // --- PENTING: HASH PASSWORD JIKA DIISI ---
        if ($password) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        // Jika $password kosong, field password di DB tidak akan di-update

        $model->update($id, $data);

        return redirect()->to(site_url('admin/users'))->with('message', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Anda mungkin tidak ingin user bisa menghapus admin/dirinya sendiri
        // Tapi untuk CRUD standar:
        $model = new UserModel();
        $model->delete($id);
        
        return redirect()->to(site_url('admin/users'))->with('message', 'User berhasil dihapus.');
    }
}