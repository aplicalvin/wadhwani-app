<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

    <?php 
        $heroImage = $settings['hero_image'] ?? 'https://via.placeholder.com/1920x600';
        if ($heroImage && $heroImage !== 'https://via.placeholder.com/1920x600') {
            $heroImage = base_url('uploads/settings/' . $heroImage);
        }
    ?>
    <div class="hero-section py-5 vh-100 d-flex align-items-center" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('<?= $heroImage ?>');">
        <div class="container text-center">
            <h1 class="display-3 fw-bold">Produk Olahan Ikan Segar dan Bisa Pemesanan Delivery, Kualitas Ikan terjamin segar langsung dari nelayan.</h1>
            <p class="lead">Menyediakan Ikan Segar Langsung dari Nelayan</p>
            <a href="<?= site_url('products') ?>" class="btn btn-primary btn-lg">Lihat Produk Kami</a>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Kategori Pilihan</h2>
        <div class="row g-4">
            <?php foreach ($categories as $category) : ?>
            <div class="col-md-4 col-lg-2">
                <div class="card text-center shadow-sm h-100">
                    <img src="<?= base_url('uploads/categories/' . $category->image) ?>" class="card-img-top p-3" alt="<?= esc($category->name) ?>" style="height: 150px; object-fit: contain;">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($category->name) ?></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4 fw-bold text-primary">Mengapa Pilih Kami?</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <i class="bi bi-water fs-1 text-primary"></i>
                    <h4 class="my-2">Ikan Segar Langsung dari Laut</h4>
                    <p>Kami memastikan kesegaran setiap ikan yang Anda beli, langsung dari nelayan.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="bi bi-truck fs-1 text-primary"></i>
                    <h4 class="my-2">Antar Cepat ke Rumah Anda</h4>
                    <p>Pesanan Anda dikirim dengan cepat dan dikemas higienis.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="bi bi-basket2 fs-1 text-primary"></i>
                    <h4 class="my-2">Produk Siap Masak</h4>
                    <p>Pilih ikan segar dengan bumbu marinasi siap masak — praktis dan lezat.</p>
                </div>
            </div>
        </div>
    </div>


    <div class="container my-5">
        <h2 class="text-center mb-4">Apa Kata Mereka?</h2>
        <div class="row">
            <?php foreach ($testimonials as $item) : ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <!-- Use placeholder if no image is available -->
                        <img src="<?= base_url('uploads/testimonials/' . ($item->image ?? 'https://randomuser.me/api/portraits/lego/1.jpg')) ?>" class="img-thumbnail rounded-circle mb-3" width="100" alt="<?= esc($item->customer_name) ?>">
                        <p class="fst-italic">"<?= esc($item->body) ?>"</p>
                        <h5 class="mt-3">- <?= esc($item->customer_name) ?></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>


<?= $this->endSection() ?>
