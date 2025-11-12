<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;

class TestimonialController extends BaseController
{
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

    public function save()
    {
        $rules = [
            'customer_name' => 'required|max_length[100]',
            'body' => 'required|string',
            'status' => 'required|in_list[pending,approved]',
            'rating' => 'permit_empty|integer|less_than_equal_to[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('admin/testimonials/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new TestimonialModel();
        $model->save($this->request->getPost());
        
        return redirect()->to(site_url('admin/testimonials'))->with('message', 'Testimoni berhasil disimpan.');
    }

    public function update($id)
    {
        $rules = [
            'customer_name' => 'required|max_length[100]',
            'body' => 'required|string',
            'status' => 'required|in_list[pending,approved]',
            'rating' => 'permit_empty|integer|less_than_equal_to[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url("admin/testimonials/edit/$id"))->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new TestimonialModel();
        $model->update($id, $this->request->getPost());

        return redirect()->to(site_url('admin/testimonials'))->with('message', 'Testimoni berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new TestimonialModel();
        $model->delete($id);
        
        return redirect()->to(site_url('admin/testimonials'))->with('message', 'Testimoni berhasil dihapus.');
    }
}