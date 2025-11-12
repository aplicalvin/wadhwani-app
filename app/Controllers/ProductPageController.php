<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SettingModel;

class ProductPageController extends BaseController
{
    /**
     * Menampilkan halaman showcase produk
     */
    public function index()
    {
        $productModel = new ProductModel();
        $settingModel = new SettingModel(); // <-- Sudah benar

        // 1. Ambil semua produk (dengan nama kategori)
        $data['products'] = $productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->findAll();

        // === PERBAIKAN 1: Ambil SEMUA data settings, bukan cuma WA ===
        $allSettings = $settingModel->findAll();
        $data['settings'] = [];
        foreach ($allSettings as $setting) {
            $data['settings'][$setting->key] = $setting->value;
        }

        // Ambil no WA (masih diperlukan untuk tombol CTA)
        $data['wa_number'] = $data['settings']['telepon'] ?? '';
        // ==========================================================
        
        // 3. Kirim ke view
        return view('public/products', $data);
    }

    /**
     * Mengembalikan data detail produk sebagai JSON
     */
    public function detail($id)
    {
        $productModel = new ProductModel();
        
        // === PERBAIKAN 2: Ganti find($id) menjadi where(...)->first() ===
        // Method 'find()' mengabaikan 'join()'. 'where()->first()' akan menjalankannya.
        $product = $productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->where('products.id', $id) // <-- Ganti baris ini
            ->first();                 // <-- Ganti baris ini

        if (!$product) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Produk tidak ditemukan']);
        }
        // =============================================================

        // 4. Ubah path gambar menjadi URL lengkap
        if ($product->image) {
            $product->image_url = base_url('uploads/products/' . $product->image);
        } else {
            $product->image_url = 'https://via.placeholder.com/400';
        }

        // 5. Kembalikan data sebagai JSON
        return $this->response->setJSON($product);
    }
}