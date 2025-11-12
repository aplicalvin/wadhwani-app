<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController; // <-- Pastikan extends BaseController
use App\Models\SettingModel;

class SettingController extends BaseController // <-- Pastikan ini
{
    // === 1. TENTUKAN PATH UPLOAD ===
    private $uploadPath = 'uploads/settings';

    // --- FUNGSI INDEX (Tidak Berubah, Sudah Benar) ---
    public function index()
    {
        $model = new SettingModel();
        $allSettings = $model->findAll();

        // Ubah array of objects jadi array key-value agar mudah di view
        $data['settings'] = [];
        foreach ($allSettings as $setting) {
            $data['settings'][$setting->key] = $setting->value;
        }

        return view('admin/settings/index', $data);
    }

    // === 2. FUNGSI UPDATE (INI YANG SEHARUSNYA ANDA GUNAKAN) ===
    public function update()
    {
        // Validasi untuk SEMUA field (termasuk hero & sosmed)
        $rules = [
            'telepon'     => 'required|string',
            'alamat'      => 'required|string',
            'maps_url'    => 'permit_empty|valid_url_strict',
            'ig_link'     => 'permit_empty|valid_url_strict', // Validasi Sosmed
            'tiktok_link' => 'permit_empty|valid_url_strict', // Validasi Sosmed
            'hero_image'  => 'permit_empty|uploaded[hero_image]|max_size[hero_image,2048]|is_image[hero_image]', // Validasi Gambar Hero
        ];

        if (!$this->validate($rules)) {
            // Jika gagal, kembali ke form dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new SettingModel();

        // --- 3. LOGIKA UPLOAD GAMBAR HERO (INI YANG HILANG) ---
        
        // Ambil data gambar hero lama (jika ada)
        $oldHero = $model->where('key', 'hero_image')->first();
        $oldHeroName = $oldHero ? $oldHero->value : null;

        // Panggil helper upload dari BaseController
        $newHeroName = $this->handleImageUpload('hero_image', $this->uploadPath, $oldHeroName);
        
        if ($newHeroName) {
            // Jika ada gambar baru diupload, simpan/update ke DB
            $model->replace([
                'key'   => 'hero_image',
                'value' => $newHeroName
            ]);
        }
        
        // --- 4. LOGIKA SIMPAN DATA TEKS (YANG BENAR) ---
        // Kita buat daftar field yang diizinkan agar aman (tidak menyimpan token CSRF)
        $postData = $this->request->getPost();
        $allowedTextKeys = ['telepon', 'alamat', 'maps_url', 'ig_link', 'tiktok_link'];

        foreach ($allowedTextKeys as $key) {
            // Cek apakah data dikirim dari form
            if (isset($postData[$key])) {
                // Gunakan replace() untuk UPDATE atau INSERT jika key belum ada
                $model->replace([
                    'key'   => $key,
                    'value' => $postData[$key]
                ]);
            }
        }

        // Kembali ke form dengan pesan sukses
        return redirect()->back()->with('message', 'Pengaturan berhasil diperbarui.');
    }
}