<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\TestimonialModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // 1. Inisialisasi semua model yang dibutuhkan
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();
        $testimonialModel = new TestimonialModel();

        // 2. Ambil data
        
        // Jumlah Kategori
        $data['totalCategories'] = $categoryModel->countAllResults();

        // Jumlah Produk (countAllResults otomatis menghormati $useSoftDeletes)
        $data['totalProducts'] = $productModel->countAllResults();

        // Ambil data testimoni yang sudah di-'approve' saja
        $approvedTestimonials = $testimonialModel->where('status', 'approved');

        // Jumlah Review (approved)
        $data['totalTestimonials'] = $approvedTestimonials->countAllResults();

        // Rata-rata Rating (approved)
        // Kita gunakan selectAvg() dari Query Builder
        $avgResult = $testimonialModel->where('status', 'approved')
                                      ->selectAvg('rating', 'averageRating') // 'averageRating' adalah alias
                                      ->first();

        // Jika tidak ada rating, set ke 0
        $data['averageRating'] = $avgResult->averageRating ?? 0;
        
        // 3. Kirim data ke view
        return view('admin/dashboard', $data);
    }
}