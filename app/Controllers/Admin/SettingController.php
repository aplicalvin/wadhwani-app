<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class SettingController extends BaseController
{
    public function index()
    {
        // Fungsi ini memuat form dan mengisinya dengan data
        $model = new SettingModel();
        $allSettings = $model->findAll();

        // Ubah array of objects jadi array key-value agar mudah di view
        $data['settings'] = [];
        foreach ($allSettings as $setting) {
            $data['settings'][$setting->key] = $setting->value;
        }

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        // Validasi
        $rules = [
            'telepon' => 'required|string',
            'alamat' => 'required|string',
            'maps_url' => 'permit_empty|valid_url',
            // ... (tambahkan semua key settings Anda)
        ];

        if (!$this->validate($rules)) {
            // Jika gagal, kembali ke form dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data (Looping)
        $model = new SettingModel();
        $postData = $this->request->getPost();

        foreach ($postData as $key => $value) {
            // Gunakan replace() untuk UPDATE atau INSERT jika belum ada
            // Ini butuh 'key' sebagai UNIQUE di database (sudah kita set di migrasi)
            $model->replace([
                'key'   => $key,
                'value' => $value
            ]);
        }

        // Kembali ke form dengan pesan sukses
        return redirect()->back()->with('message', 'Pengaturan berhasil diperbarui.');
    }
}