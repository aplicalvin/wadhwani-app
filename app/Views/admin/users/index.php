<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Manajemen User (Admin)</h1>
        <a href="<?= site_url('admin/users/new') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah User
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?= esc($user->name) ?></td>
                                <td><?= esc($user->email) ?></td>
                                <td><?= esc($user->role) ?></td>
                                <td>
                                    <a href="<?= site_url('admin/users/edit/' . $user->id) ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= site_url('admin/users/delete/' . $user->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus?')">
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
            <?= ($showModal == 'edit') ? 'Edit User' : 'Tambah User' ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <?php if ($showModal == 'edit') : ?>
        <form action="<?= site_url('admin/users/update/' . $modalData->id) ?>" method="POST">
      <?php else : ?>
        <form action="<?= site_url('admin/users/save') ?>" method="POST">
      <?php endif; ?>

        <div class="modal-body">
            <?= csrf_field() ?>
            
            <?php 
                $name_val = old('name', $modalData->name ?? '');
                $email_val = old('email', $modalData->email ?? '');
                $role_val = old('role', $modalData->role ?? 'admin');
            ?>

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                       id="name" name="name" value="<?= esc($name_val) ?>">
                <?php if(isset($errors['name'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['name']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                       id="email" name="email" value="<?= esc($email_val) ?>">
                <?php if(isset($errors['email'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['email']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <input type="text" class="form-control <?= isset($errors['role']) ? 'is-invalid' : '' ?>" 
                       id="role" name="role" value="<?= esc($role_val) ?>">
                <?php if(isset($errors['role'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['role']) ?></div>
                <?php endif; ?>
            </div>
            
            <hr>
            
            <?php if ($showModal == 'edit'): ?>
                <small class="text-muted"><i>Kosongkan password jika tidak ingin mengubahnya.</i></small>
            <?php endif; ?>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                       id="password" name="password" value="">
                <?php if(isset($errors['password'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['password']) ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control <?= isset($errors['password_confirmation']) ? 'is-invalid' : '' ?>" 
                       id="password_confirmation" name="password_confirmation" value="">
                <?php if(isset($errors['password_confirmation'])): ?>
                    <div class="invalid-feedback"><?= esc($errors['password_confirmation']) ?></div>
                <?php endif; ?>
            </div>

        </div>
        
        <div class="modal-footer">
          <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary">Batal</a>
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