<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    /**
     * Menampilkan daftar dan menangani modal
     * $showModal = 'new' | 'edit' | null
     * $modalData = data untuk form
     */
    private function showIndex($showModal = null, $modalData = null)
    {
        $model = new CategoryModel();
        
        $data = [
            'categories' => $model->findAll(),
            'showModal'  => $showModal,
            'modalData'  => $modalData,
            'errors'     => session()->get('errors'), // Ambil error validasi dari session
        ];

        return view('admin/categories/index', $data);
    }

    // Menampilkan daftar
    public function index()
    {
        return $this->showIndex();
    }

    // Menyiapkan data untuk modal 'new'
    public function new()
    {
        return $this->showIndex('new', new \App\Entities\Category()); // Kirim entity kosong
    }

    // Menyiapkan data untuk modal 'edit'
    public function edit($id)
    {
        $model = new CategoryModel();
        $data = $model->find($id);
        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }
        return $this->showIndex('edit', $data);
    }

    // Menyimpan data baru
    public function save()
    {
        $rules = [
            'name' => 'required|string|max_length[100]',
            'description' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembali ke form 'new' dengan error
            return redirect()->to(site_url('admin/categories/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new CategoryModel();
        $model->save($this->request->getPost());
        
        return redirect()->to(site_url('admin/categories'))->with('message', 'Kategori berhasil disimpan.');
    }

    // Memperbarui data
    public function update($id)
    {
        $rules = [
            'name' => 'required|string|max_length[100]',
            'description' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembali ke form 'edit' dengan error
            return redirect()->to(site_url("admin/categories/edit/$id"))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new CategoryModel();
        $model->update($id, $this->request->getPost());

        return redirect()->to(site_url('admin/categories'))->with('message', 'Kategori berhasil diperbarui.');
    }

    // Menghapus data
    public function delete($id)
    {
        $model = new CategoryModel();
        $model->delete($id);
        
        return redirect()->to(site_url('admin/categories'))->with('message', 'Kategori berhasil dihapus.');
    }
}