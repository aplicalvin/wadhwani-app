<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TestimonialModel;
use CodeIgniter\API\ResponseTrait;

class TestimonialController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new TestimonialModel();
        $data['testimonials'] = $model->orderBy('created_at', 'DESC')->findAll();
        
        return view('admin/testimonials/index', $data);
    }

    public function store()
    {
        $rules = [
            'customer_name' => 'required|max_length[100]',
            'body' => 'required|string',
            'status' => 'required|in_list[pending,approved]',
            'rating' => 'permit_empty|integer|less_than_equal_to[5]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $model = new TestimonialModel();
        $model->save($this->request->getPost());

        return $this->respondCreated(['status' => 'success', 'message' => 'Testimoni berhasil ditambahkan.']);
    }

    public function edit($id)
    {
        $model = new TestimonialModel();
        $data = $model->find($id);

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('Data testimoni tidak ditemukan.');
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
            return $this->fail($this->validator->getErrors());
        }

        $model = new TestimonialModel();
        $model->update($id, $this->request->getPost());

        return $this->respondUpdated(['status' => 'success', 'message' => 'Testimoni berhasil diperbarui.']);
    }

    public function delete($id)
    {
        $model = new TestimonialModel();
        $model->delete($id);

        return $this->respondDeleted(['status' => 'success', 'message' => 'Testimoni berhasil dihapus.']);
    }
}