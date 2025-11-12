<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-3">Pengaturan Informasi Website</h1>

<div class="card shadow-sm">
    <div class="card-body">
        
        <?php if (session()->get('message')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->get('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/settings/update') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control <?= (session()->get('errors.telepon')) ? 'is-invalid' : '' ?>" 
                       id="telepon" name="telepon" value="<?= esc($settings['telepon'] ?? '') ?>">
                <?php if (session()->get('errors.telepon')) : ?>
                    <div class="invalid-feedback"><?= session()->get('errors.telepon') ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control <?= (session()->get('errors.alamat')) ? 'is-invalid' : '' ?>" 
                          id="alamat" name="alamat" rows="3"><?= esc($settings['alamat'] ?? '') ?></textarea>
                <?php if (session()->get('errors.alamat')) : ?>
                    <div class="invalid-feedback"><?= session()->get('errors.alamat') ?></div>
                <?php endif; ?>
            </div>

           

            <hr>
            <h5 class="mb-3">Gambar Hero</h5>
            <div class="mb-3">
                <label for="hero_image" class="form-label">Upload Gambar Hero</label>
                <input type="file" class="form-control <?= isset(session('errors')['hero_image']) ? 'is-invalid' : '' ?>" 
                       id="hero_image" name="hero_image">
                <?php if(isset(session('errors')['hero_image'])): ?>
                    <div class="invalid-feedback"><?= esc(session('errors')['hero_image']) ?></div>
                <?php endif; ?>
                
                <?php if (!empty($settings['hero_image'])): ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/settings/' . $settings['hero_image']) ?>" alt="Current Hero Image" width="200" class="img-thumbnail">
                        <small class="d-block text-muted">Gambar saat ini. Upload file baru untuk mengganti.</small>
                    </div>
                <?php endif; ?>
            </div>
            <hr>
            <h5 class="mb-3">Sosial Media</h5>
            
            <div class="mb-3">
                <label for="ig_link" class="form-label">URL Instagram</label>
                <input type="text" class="form-control <?= (session()->get('errors.ig_link')) ? 'is-invalid' : '' ?>" 
                       id="ig_link" name="ig_link" value="<?= esc($settings['ig_link'] ?? '') ?>" placeholder="https://instagram.com/akun_anda">
                <?php if (session()->get('errors.ig_link')) : ?>
                    <div class="invalid-feedback"><?= session()->get('errors.ig_link') ?></div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="tiktok_link" class="form-label">URL TikTok</label>
                <input type="text" class="form-control <?= (session()->get('errors.tiktok_link')) ? 'is-invalid' : '' ?>" 
                       id="tiktok_link" name="tiktok_link" value="<?= esc($settings['tiktok_link'] ?? '') ?>" placeholder="https://tiktok.com/@akun_anda">
                <?php if (session()->get('errors.tiktok_link')) : ?>
                    <div class="invalid-feedback"><?= session()->get('errors.tiktok_link') ?></div>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>