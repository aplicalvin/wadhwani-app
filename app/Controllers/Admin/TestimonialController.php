<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;

class TestimonialController extends BaseController
{
    // === 1. TAMBAHKAN PATH UPLOAD ===
    private $uploadPath = 'uploads/testimonials';

    // --- FUNGSI showIndex (Sudah Benar, Tidak Berubah) ---
    private function showIndex($showModal = null, $modalData = null)
    {
        $model = new TestimonialModel();
        
        $data = [
            'testimonials' => $model->findAll(),
            'showModal'  => $showModal,
            'modalData'  => $modalData,
            'errors'     => session()->get('errors'),
        ];

        return view('admin/testimonials/index', $data);
    }

    // --- FUNGSI index, new, edit (Sudah Benar, Tidak Berubah) ---
    public function index()
    {
        return $this->showIndex();
    }

    public function new()
    {
        return $this->showIndex('new', new \App\Entities\Testimonial());
    }

    public function edit($id)
    {
        $model = new TestimonialModel();
        $data = $model->find($id);
        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Testimoni tidak ditemukan');
        }
        return $this->showIndex('edit', $data);
    }

    // === 2. FUNGSI SAVE (REVISI) ===
    public function save()
    {
        $rules = [
            'customer_name' => 'required|max_length[100]',
            'body' => 'required|string',
            'status' => 'required|in_list[pending,approved]',
            'rating' => 'permit_empty|integer|less_than_equal_to[5]',
            'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]', // Tambah validasi gambar
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('admin/testimonials/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new TestimonialModel();
        $data = $this->request->getPost(); // Ambil data teks

        // Panggil helper upload
        $imageName = $this->handleImageUpload('image', $this->uploadPath);
        if ($imageName) {
            $data['image'] = $imageName; // Tambahkan nama file gambar
        }

        $model->save($data); // Simpan semua data
        
        return redirect()->to(site_url('admin/testimonials'))->with('message', 'Testimoni berhasil disimpan.');
    }

    // === 3. FUNGSI UPDATE (REVISI) ===
    public function update($id)
    {
        $rules = [
            'customer_name' => 'required|max_length[100]',
            'body' => 'required|string',
            'status' => 'required|in_list[pending,approved]',
            'rating' => 'permit_empty|integer|less_than_equal_to[5]',
            'image' => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]', // Tambah validasi gambar
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url("admin/testimonials/edit/$id"))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new TestimonialModel();
        $data = $this->request->getPost(); // Ambil data teks

        // Ambil data lama untuk cek gambar
        $oldTestimonial = $model->find($id);

        // Panggil helper upload (dengan nama file lama)
        $newImageName = $this->handleImageUpload('image', $this->uploadPath, $oldTestimonial->image);
        if ($newImageName) {
            $data['image'] = $newImageName; // Tambahkan nama file gambar baru
        }

        $model->update($id, $data); // Update data

        return redirect()->to(site_url('admin/testimonials'))->with('message', 'Testimoni berhasil diperbarui.');
    }

    // === 4. FUNGSI DELETE (REVISI) ===
    public function delete($id)
    {
        $model = new TestimonialModel();
        
        // Ambil data sebelum dihapus
        $testimonial = $model->find($id);
        if (!$testimonial) {
            return redirect()->to(site_url('admin/testimonials'))->with('error', 'Testimoni tidak ditemukan.');
        }

        // Hapus file gambar
        $this->deleteImage($this->uploadPath, $testimonial->image);

        // Hapus data dari DB
        $model->delete($id);
        
        return redirect()->to(site_url('admin/testimonials'))->with('message', 'Testimoni berhasil dihapus.');
    }
}