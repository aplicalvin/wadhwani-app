<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-3">Pengaturan Informasi Website</h1>

<div class="card shadow-sm">
    <div class="card-body">
        
        <?php if (session()->get('message')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->get('message') ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('admin/settings/update') ?>" method="POST">
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

            <div class="mb-3">
                <label for="maps_url" class="form-label">URL Google Maps</label>
                <input type="text" class="form-control <?= (session()->get('errors.maps_url')) ? 'is-invalid' : '' ?>" 
                       id="maps_url" name="maps_url" value="<?= esc($settings['maps_url'] ?? '') ?>">
                <?php if (session()->get('errors.maps_url')) : ?>
                    <div class="invalid-feedback"><?= session()->get('errors.maps_url') ?></div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>