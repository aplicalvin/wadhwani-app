<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Manajemen Kategori</h1>
        <a href="<?= site_url('admin/categories/new') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
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
                            <th style="width: 50px;">Gambar</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                            <tr>    
                                <td>
                                    <?php if ($category->image): // <-- Ganti $item jadi $category ?>
                                        <img src="<?= base_url('uploads/categories/' . $category->image) ?>" alt="<?= esc($category->name) ?>" width="50" class="img-thumbnail">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/50" alt="no image" width="50" class="img-thumbnail">
                                    <?php endif; ?>
                                    </td>
                                <td><?= esc($category->name) ?></td>
                                <td><?= esc($category->description) ?></td>
                                <td>
                                    <a href="<?= site_url('admin/categories/edit/' . $category->id) ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= site_url('admin/categories/delete/' . $category->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus?')">
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
            <?= ($showModal == 'edit') ? 'Edit Kategori' : 'Tambah Kategori' ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <?php if ($showModal == 'edit') : ?>
        <form action="<?= site_url('admin/categories/update/' . $modalData->id) ?>" method="POST" enctype="multipart/form-data">
      <?php else : ?>
        <form action="<?= site_url('admin/categories/save') ?>" method="POST" enctype="multipart/form-data">
      <?php endif; ?>

        <div class="modal-body">
            <?= csrf_field() ?>
            
            <?php 
                $name_value = old('name', $modalData->name ?? '');
                $desc_value = old('description', $modalData->description ?? '');
            ?>

            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                       id="name" name="name" value="<?= esc($name_value) ?>">
                <?php if(isset($errors['name'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>" 
                          id="description" name="description" rows="3"><?= esc($desc_value) ?></textarea>
                <?php if(isset($errors['description'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['description']) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Kategori</label>
                <input type="file" class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>" 
                       id="image" name="image">
                <?php if(isset($errors['image'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['image']) ?></div>
                <?php endif; ?>
                
                <?php if ($showModal == 'edit' && $modalData->image): ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/categories/' . $modalData->image) ?>" alt="Current Image" width="100" class="img-thumbnail">
                        <small class="d-block text-muted">Gambar saat ini. Upload file baru untuk mengganti.</small>
                    </div>
                <?php endif; ?>
            </div>
            </div>
        
        <div class="modal-footer">
          <a href="<?= site_url('admin/categories') ?>" class="btn btn-secondary">Batal</a>
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
        <?php if (isset($showModal) || session()->has('errors')): ?>
            const myModal = new bootstrap.Modal(document.getElementById('crud-modal'));
            myModal.show();
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>