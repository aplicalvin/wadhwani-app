<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait; // <-- PENTING untuk respons JSON

class CategoryController extends BaseController
{
    use ResponseTrait; // <-- Gunakan Trait

    public function index()
    {
        // Fungsi ini HANYA memuat halaman utama
        // Logika tabel akan kita buat di view dengan AJAX
        // atau bisa juga kita kirim data awalnya
        $model = new CategoryModel();
        $data['categories'] = $model->orderBy('name', 'ASC')->findAll();
        
        return view('admin/categories/index', $data); // Asumsi nama view-nya
    }

    public function store()
    {
        // Validasi
        $rules = [
            'name' => 'required|max_length[100]',
            'description' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            // Kirim error validasi sebagai JSON
            return $this->fail($this->validator->getErrors());
        }

        // Simpan data
        $model = new CategoryModel();
        $model->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        // Kirim respons sukses sebagai JSON
        return $this->respondCreated(['status' => 'success', 'message' => 'Kategori berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        // Ambil data by ID
        $model = new CategoryModel();
        $data = $model->find($id);

        if ($data) {
            // Kirim data kategori sebagai JSON
            return $this->respond($data);
        }

        return $this->failNotFound('Data kategori tidak ditemukan.');
    }

    public function update($id)
    {
        // Validasi
        $rules = [
            'name' => 'required|max_length[100]',
            'description' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        // Update data
        $model = new CategoryModel();
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return $this->respondUpdated(['status' => 'success', 'message' => 'Kategori berhasil diperbarui.']);
    }

    public function delete($id)
    {
        $model = new CategoryModel();
        $model->delete($id);

        return $this->respondDeleted(['status' => 'success', 'message' => 'Kategori berhasil dihapus.']);
    }
}