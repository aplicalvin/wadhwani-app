<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    private $uploadPath = 'uploads/categories';
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
            'errors'     => session()->get('errors'),
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
            'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]', // Validasi gambar
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('admin/categories/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new CategoryModel();
        $data = $this->request->getPost();

        // Panggil helper upload
        $imageName = $this->handleImageUpload('image', $this->uploadPath);
        if ($imageName) {
            $data['image'] = $imageName;
        }

        $model->save($data);
        
        return redirect()->to(site_url('admin/categories'))->with('message', 'Kategori berhasil disimpan.');
    }  

    // Memperbarui data
    public function update($id)
    {
        $rules = [
            'name' => 'required|string|max_length[100]',
            'description' => 'permit_empty|string',
            'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]', // Validasi gambar
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url("admin/categories/edit/$id"))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new CategoryModel();
        $data = $this->request->getPost();
        
        // Ambil data lama untuk cek gambar
        $oldCategory = $model->find($id);

        // Panggil helper upload (dengan nama file lama)
        $newImageName = $this->handleImageUpload('image', $this->uploadPath, $oldCategory->image);
        if ($newImageName) {
            $data['image'] = $newImageName;
        }

        $model->update($id, $data);

        return redirect()->to(site_url('admin/categories'))->with('message', 'Kategori berhasil diperbarui.');
    }

    // Menghapus data
    public function delete($id)
    {
        $model = new CategoryModel();
        
        // Ambil data sebelum dihapus
        $category = $model->find($id);
        if (!$category) {
            return redirect()->to(site_url('admin/categories'))->with('error', 'Kategori tidak ditemukan.');
        }

        // Hapus file gambar
        $this->deleteImage($this->uploadPath, $category->image);

        // Hapus data dari DB
        $model->delete($id);
        
        return redirect()->to(site_url('admin/categories'))->with('message', 'Kategori berhasil dihapus.');
    }
}