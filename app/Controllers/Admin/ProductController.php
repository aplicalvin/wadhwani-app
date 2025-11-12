<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel; // <-- Butuh ini untuk dropdown
use CodeIgniter\API\ResponseTrait;

class ProductController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // Ambil data produk dengan JOIN
        $data['products'] = $productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->orderBy('products.name', 'ASC')
            ->findAll();
            
        // Ambil data kategori untuk <select> di modal
        $data['categories'] = $categoryModel->orderBy('name', 'ASC')->findAll();

        return view('admin/products/index', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|max_length[150]',
            'category_id' => 'required|integer',
            'price_per_kg' => 'required|decimal',
            'description' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new ProductModel();
        $model->save($this->request->getPost()); // Langsung simpan dari post

        return $this->respondCreated(['status' => 'success', 'message' => 'Produk berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $model = new ProductModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('Data produk tidak ditemukan.');
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
            return $this->fail($this->validator->getErrors());
        }

        $model = new ProductModel();
        $model->update($id, $this->request->getPost()); // Langsung update dari post

        return $this->respondUpdated(['status' => 'success', 'message' => 'Produk berhasil diperbarui.']);
    }

    public function delete($id)
    {
        $model = new ProductModel();
        // Ini akan soft delete karena kita set di Model
        $model->delete($id); 

        return $this->respondDeleted(['status' => 'success', 'message' => 'Produk berhasil dihapus.']);
    }
}