<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Manajemen Produk</h1>
        <a href="<?= site_url('admin/products/new') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Produk
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
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga (per Kg)</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td>
                                    <?php if ($product->image): ?>
                                        <img src="<?= base_url('uploads/products/' . $product->image) ?>" alt="<?= esc($product->name) ?>" width="50" class="img-thumbnail">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/50" alt="no image" width="50" class="img-thumbnail">
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($product->name) ?></td>
                                <td><?= esc($product->category_name) ?></td>
                                <td>Rp <?= number_format($product->price_per_kg, 0, ',', '.') ?></td>
                                <td>
                                    <a href="<?= site_url('admin/products/edit/' . $product->id) ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= site_url('admin/products/delete/' . $product->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus?')">
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
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">
            <?= ($showModal == 'edit') ? 'Edit Produk' : 'Tambah Produk' ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <?php if ($showModal == 'edit') : ?>
        <form action="<?= site_url('admin/products/update/' . $modalData->id) ?>" method="POST" enctype="multipart/form-data">
      <?php else : ?>
        <form action="<?= site_url('admin/products/save') ?>" method="POST" enctype="multipart/form-data">
      <?php endif; ?>

        <div class="modal-body">
            <?= csrf_field() ?>
            
            <?php 
                $cat_id_val = old('category_id', $modalData->category_id ?? '');
                $name_val = old('name', $modalData->name ?? '');
                $price_val = old('price_per_kg', $modalData->price_per_kg ?? '');
                $desc_val = old('description', $modalData->description ?? '');
            ?>

            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select <?= isset($errors['category_id']) ? 'is-invalid' : '' ?>" id="category_id" name="category_id">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($all_categories as $category) : ?>
                        <option value="<?= $category->id ?>" <?= ($cat_id_val == $category->id) ? 'selected' : '' ?>>
                            <?= esc($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if(isset($errors['category_id'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['category_id']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                       id="name" name="name" value="<?= esc($name_val) ?>">
                <?php if(isset($errors['name'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                <?php endif; ?>
            </div>
            
            <div class="mb-3">
                <label for="price_per_kg" class="form-label">Harga per Kg</label>
                <input type="number" class="form-control <?= isset($errors['price_per_kg']) ? 'is-invalid' : '' ?>" 
                       id="price_per_kg" name="price_per_kg" value="<?= esc($price_val) ?>">
                <?php if(isset($errors['price_per_kg'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['price_per_kg']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>" 
                          id="description" name="description" rows="3"><?= esc($desc_val) ?></textarea>
                <?php if(isset($errors['description'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['description']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Gambar Produk</UBAH>
                <input type="file" class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>" 
                       id="image" name="image">
                <?php if(isset($errors['image'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['image']) ?></div>
                <?php endif; ?>
                
                <?php if ($showModal == 'edit' && $modalData->image): ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/products/' . $modalData->image) ?>" alt="Current Image" width="100" class="img-thumbnail">
                        <small class="d-block text-muted">Gambar saat ini. Upload file baru untuk mengganti.</small>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
        
        <div class="modal-footer">
          <a href="<?= site_url('admin/products') ?>" class="btn btn-secondary">Batal</a>
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