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

    <!-- Kategori Pilihan -->
    <div class="container my-5">
        <h2 class="text-center mb-4 fw-bold text-primary">Kategori Pilihan</h2>
        <div class="row g-4 justify-content-center">
            <?php foreach ($categories as $category): 
                $imagePath = $category->image && file_exists(FCPATH . 'uploads/categories/' . $category->image)
                    ? base_url('uploads/categories/' . $category->image)
                    : 'https://cdn-icons-png.flaticon.com/512/616/616408.png'; // placeholder kategori
            ?>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="card border-0 shadow-sm text-center h-100 rounded-4 hover-shadow transition">
                    <img src="<?= $imagePath ?>" 
                        alt="<?= esc($category->name) ?>" 
                        class="p-3 mx-auto" 
                        style="height: 140px; object-fit: contain;">
                    <div class="card-body py-2">
                        <h6 class="fw-semibold text-dark"><?= esc($category->name) ?></h6>
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


    <!-- Apa Kata Mereka -->
    <div class="container my-5">
        <h2 class="text-center mb-4 fw-bold text-primary">Apa Kata Mereka?</h2>
        <div class="row g-4 justify-content-center">
            <?php foreach ($testimonials as $item): 
                $avatar = $item->image && file_exists(FCPATH . 'uploads/testimonials/' . $item->image)
                    ? base_url('uploads/testimonials/' . $item->image)
                    : 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($item->customer_name);
            ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center">
                        <img src="<?= $avatar ?>" 
                            class="rounded-circle shadow-sm mb-3" 
                            width="90" height="90" 
                            alt="<?= esc($item->customer_name) ?>" 
                            style="object-fit: cover;">
                        <p class="fst-italic text-secondary">"<?= esc($item->body) ?>"</p>
                        <h6 class="fw-semibold mt-3 text-dark">- <?= esc($item->customer_name) ?></h6>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>


<?= $this->endSection() ?>
