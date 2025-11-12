<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel; // <-- Tambahkan ini

class ProductController extends BaseController
{
    private function showIndex($showModal = null, $modalData = null)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel(); // <-- Perlu ini

        $data = [
            // Join untuk menampilkan nama kategori di tabel
            'products' => $productModel
                ->select('products.*, categories.name as category_name')
                ->join('categories', 'categories.id = products.category_id', 'left')
                ->findAll(),
            'all_categories' => $categoryModel->findAll(), // <-- Kirim ini untuk <select>
            'showModal'  => $showModal,
            'modalData'  => $modalData,
            'errors'     => session()->get('errors'),
        ];

        return view('admin/products/index', $data);
    }

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

    public function save()
    {
        $rules = [
            'name' => 'required|max_length[150]',
            'category_id' => 'required|integer',
            'price_per_kg' => 'required|decimal',
            'description' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('admin/products/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ProductModel();
        $model->save($this->request->getPost());
        
        return redirect()->to(site_url('admin/products'))->with('message', 'Produk berhasil disimpan.');
    }

    public function update($id)
    {
         $rules = [
            'name' => 'required|max_length[150]',
            'category_id' => 'required|integer',
            'price_per_kg' => 'required|decimal',
            'description' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url("admin/products/edit/$id"))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new ProductModel();
        $model->update($id, $this->request->getPost());

        return redirect()->to(site_url('admin/products'))->with('message', 'Produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new ProductModel();
        $model->delete($id); // Ini akan soft-delete jika Anda setting di Model
        
        return redirect()->to(site_url('admin/products'))->with('message', 'Produk berhasil dihapus.');
    }
}