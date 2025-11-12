<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\SettingModel;
use App\Models\TestimonialModel;

class HomeController extends BaseController
{
    public function index()
    {
        $settingModel = new SettingModel();
        $categoryModel = new CategoryModel();
        $testimonialModel = new TestimonialModel();

        // 1. Ambil semua data settings
        $allSettings = $settingModel->findAll();
        $data['settings'] = [];
        foreach ($allSettings as $setting) {
            $data['settings'][$setting->key] = $setting->value;
        }

        // 2. Ambil kategori (misal: 6 teratas)
        $data['categories'] = $categoryModel->findAll(6);

        // 3. Ambil testimoni yang sudah 'approved'
        $data['testimonials'] = $testimonialModel
                                ->where('status', 'approved')
                                ->orderBy('created_at', 'DESC')
                                ->limit(3)
                                ->findAll();

        // 4. Kirim ke view
        return view('public/home', $data);
    }
}