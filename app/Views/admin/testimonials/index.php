<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Manajemen Testimoni</h1>
        <a href="<?= site_url('admin/testimonials/new') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Testimoni
        </a>
    </div>

    <?php if (session()->get('message')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->get('message') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testimonials as $item) : ?>
                            <tr>
                                <td><?= esc($item->customer_name) ?></td>
                                <td><i class="bi bi-star-fill text-warning"></i> <?= esc($item->rating) ?></td>
                                <td>
                                    <span class="badge <?= ($item->status == 'approved') ? 'bg-success' : 'bg-warning text-dark' ?>">
                                        <?= esc($item->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= site_url('admin/testimonials/edit/' . $item->id) ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= site_url('admin/testimonials/delete/' . $item->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<div class="modal fade" id="crud-modal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">
             <?= ($showModal == 'edit') ? 'Edit Testimoni' : 'Tambah Testimoni' ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <?php if ($showModal == 'edit') : ?>
        <form action="<?= site_url('admin/testimonials/update/' . $modalData->id) ?>" method="POST">
      <?php else : ?>
        <form action="<?= site_url('admin/testimonials/save') ?>" method="POST">
      <?php endif; ?>

        <div class="modal-body">
            <?= csrf_field() ?>
            
            <?php
                $name_val = old('customer_name', $modalData->customer_name ?? '');
                $rating_val = old('rating', $modalData->rating ?? '');
                $status_val = old('status', $modalData->status ?? 'pending');
                $body_val = old('body', $modalData->body ?? '');
            ?>

            <div class="mb-3">
                <label for="customer_name" class="form-label">Nama Pelanggan</label>
                <input type="text" class="form-control <?= isset($errors['customer_name']) ? 'is-invalid' : '' ?>" 
                       id="customer_name" name="customer_name" value="<?= esc($name_val) ?>">
                <?php if(isset($errors['customer_name'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['customer_name']) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" class="form-control <?= isset($errors['rating']) ? 'is-invalid' : '' ?>" 
                           id="rating" name="rating" min="1" max="5" value="<?= esc($rating_val) ?>">
                    <?php if(isset($errors['rating'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['rating']) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>" id="status" name="status">
                        <option value="pending" <?= ($status_val == 'pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= ($status_val == 'approved') ? 'selected' : '' ?>>Approved</option>
                    </select>
                    <?php if(isset($errors['status'])): ?>
                        <div class="invalid-feedback"><?= esc($errors['status']) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Isi Testimoni</label>
                <textarea class="form-control <?= isset($errors['body']) ? 'is-invalid' : '' ?>" 
                          id="body" name="body" rows="3"><?= esc($body_val) ?></textarea>
                <?php if(isset($errors['body'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['body']) ?></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="modal-footer">
          <a href="<?= site_url('admin/testimonials') ?>" class="btn btn-secondary">Batal</a>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Buka modal jika ada flag $showModal ATAU ada error validasi
        <?php if (isset($showModal) || session()->has('errors')): ?>
            const myModal = new bootstrap.Modal(document.getElementById('crud-modal'));
            myModal.show();
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>