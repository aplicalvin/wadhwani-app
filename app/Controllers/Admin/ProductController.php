<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController extends BaseController
{
    // === 1. UBAH PATH INI ===
    private $uploadPath = 'uploads/products';

    // --- FUNGSI showIndex (Sudah Benar, Tidak Berubah) ---
    private function showIndex($showModal = null, $modalData = null)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $data = [
            'products' => $productModel
                ->select('products.*, categories.name as category_name')
                ->join('categories', 'categories.id = products.category_id', 'left')
                ->findAll(),
            'all_categories' => $categoryModel->findAll(),
            'showModal'  => $showModal,
            'modalData'  => $modalData,
            'errors'     => session()->get('errors'),
        ];

        return view('admin/products/index', $data);
    }

    // --- FUNGSI index, new, edit (Sudah Benar, Tidak Berubah) ---
    public function index()
    {
        return $this->showIndex();
    }
    public function new()
    {
        return $this->showIndex('new', new \App\Entities\Product());
    }
    public function edit($id)
    {
        $model = new ProductModel();
        $data = $model->find($id);
        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan');
        }
        return $this->showIndex('edit', $data);
    }


    // === 2. FUNGSI SAVE (REVISI TOTAL) ===
    public function save()
    {
        $rules = [
            'name' => 'required|max_length[150]',
            'category_id' => 'required|integer',
            'price_per_kg' => 'required|decimal',
            'description' => 'permit_empty|string',
            'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]', // Validasi gambar
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('admin/products/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ProductModel();
        $data = $this->request->getPost(); // Ambil data teks

        // Panggil helper upload
        $imageName = $this->handleImageUpload('image', $this->uploadPath);
        if ($imageName) {
            $data['image'] = $imageName; // Tambahkan nama file gambar ke data
        }

        $model->save($data); // Simpan semua data (teks + gambar)
        
        return redirect()->to(site_url('admin/products'))->with('message', 'Produk berhasil disimpan.');
    }

    // === 3. FUNGSI UPDATE (REVISI TOTAL) ===
    public function update($id)
    {
         $rules = [
            'name' => 'required|max_length[150]',
            'category_id' => 'required|integer',
            'price_per_kg' => 'required|decimal',
            'description' => 'permit_empty|string',
            'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]', // Tambah validasi gambar
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url("admin/products/edit/$id"))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ProductModel();
        $data = $this->request->getPost(); // Ambil data teks

        // Ambil data lama untuk cek gambar
        $oldProduct = $model->find($id);

        // Panggil helper upload (dengan nama file lama)
        $newImageName = $this->handleImageUpload('image', $this->uploadPath, $oldProduct->image);
        if ($newImageName) {
            $data['image'] = $newImageName; // Tambahkan nama file gambar baru
        }

        $model->update($id, $data); // Update data

        return redirect()->to(site_url('admin/products'))->with('message', 'Produk berhasil diperbarui.');
    }

    // === 4. FUNGSI DELETE (REVISI TOTAL) ===
    public function delete($id)
    {
        $model = new ProductModel();
        
        // Ambil data sebelum dihapus
        $product = $model->find($id);
        if (!$product) {
            return redirect()->to(site_url('admin/products'))->with('error', 'Produk tidak ditemukan.');
        }

        // Hapus file gambar
        $this->deleteImage($this->uploadPath, $product->image);

        // Hapus data dari DB
        $model->delete($id);
        
        return redirect()->to(site_url('admin/products'))->with('message', 'Produk berhasil dihapus.');
    }
}