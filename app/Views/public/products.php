<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<style>
    /* --- THEME COLORS --- */
    :root {
        --primary-color: #2C5F6C;
        --accent-color: #74B3CE;
        --light-color: #E4F0F5;
        --danger-color: #d9534f;
    }

    /* --- HEADER SECTION --- */
    .page-header {
        background: linear-gradient(rgba(44,95,108,0.7), rgba(44,95,108,0.7)), url('https://images.unsplash.com/photo-1528818955841-a7f1425131b5?auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        text-align: center;
        padding: 100px 20px;
        border-radius: 0 0 40px 40px;
        margin-bottom: 3rem;
    }
    .page-header h1 {
        font-weight: 700;
        letter-spacing: 1px;
    }

    /* --- CARD PRODUCT --- */
    .card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
        background-color: white;
    }
    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .card img {
        border-radius: 15px 15px 0 0;
    }
    .card-title {
        font-weight: 600;
        color: var(--primary-color);
    }
    .card-subtitle {
        color: var(--danger-color);
        font-weight: 600;
    }
    .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        font-weight: 600;
    }
    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* --- WHATSAPP CTA SECTION --- */
    .order-section {
        background-color: var(--light-color);
        border-radius: 20px;
        padding: 3rem;
        text-align: center;
        margin-top: 4rem;
    }
    .btn-success {
        background-color: #25D366;
        border: none;
        font-weight: 600;
        padding: 0.75rem 2rem;
    }
    .btn-success:hover {
        background-color: #1ebe5b;
    }

    /* --- MODAL DETAIL --- */
    .modal-content {
        border-radius: 20px;
        border: none;
    }
    .modal-header {
        background-color: var(--primary-color);
        color: white;
        border-radius: 20px 20px 0 0;
    }
    .modal-title {
        font-weight: 600;
    }
    .modal-body h2 {
        color: var(--primary-color);
        font-weight: 700;
    }
</style>

<!-- Header -->
<div class="page-header">
    <h1 class="display-4">Produk Kami</h1>
    <p class="lead">Temukan berbagai ikan segar dan olahan terbaik hasil laut Indonesia.</p>
</div>

<div class="container">
    <div class="row g-4">
        <?php foreach ($products as $product) : ?>
        <div class="col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm">
                <img src="<?= base_url('uploads/products/' . $product->image) ?>" 
                     class="card-img-top" 
                     alt="<?= esc($product->name) ?>" 
                     style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= esc($product->name) ?></h5>
                    <p class="card-text text-muted"><?= esc($product->category_name) ?></p>
                    <h6 class="card-subtitle mb-3 text-danger">Rp <?= number_format($product->price_per_kg, 0, ',', '.') ?> / Kg</h6>

                    <button type="button" 
                            class="btn btn-outline-primary mt-auto btn-detail" 
                            data-bs-toggle="modal" 
                            data-bs-target="#detailModal"
                            data-id="<?= $product->id ?>">
                        <i class="bi bi-eye me-1"></i> Lihat Detail
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- CTA Section -->
    <div class="order-section mt-5">
        <h3 class="fw-bold mb-3">Siap Memesan?</h3>
        <p class="mb-4">Hubungi kami langsung melalui WhatsApp untuk pemesanan cepat dan konsultasi produk.</p>
        <?php 
            $wa = $wa_number;
            if (substr($wa, 0, 1) === '0') { $wa = '62' . substr($wa, 1); }
        ?>
        <a href="https://wa.me/<?= $wa ?>?text=Halo%20Fresh%20Fish,%20saya%20tertarik%20untuk%20memesan%20ikan." 
           class="btn btn-success btn-lg shadow-lg rounded-pill">
            <i class="bi bi-whatsapp me-2"></i> Pesan Sekarang via WhatsApp
        </a>
    </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Detail Produk</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row align-items-center">
            <div class="col-md-5 mb-3 mb-md-0">
                <img id="modal-product-image" src="https://via.placeholder.com/400" class="img-fluid rounded shadow-sm" alt="Produk">
            </div>
            <div class="col-md-7">
                <h2 id="modal-product-name">Nama Produk</h2>
                <h5 id="modal-product-category" class="text-muted">Kategori</h5>
                <h3 id="modal-product-price" class="text-danger my-3">Rp 0 / Kg</h3>
                <p id="modal-product-description" class="lh-lg">Deskripsi produk akan muncul di sini...</p>
            </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const detailModal = document.getElementById('detailModal');

    const modalImage = document.getElementById('modal-product-image');
    const modalName = document.getElementById('modal-product-name');
    const modalCategory = document.getElementById('modal-product-category');
    const modalPrice = document.getElementById('modal-product-price');
    const modalDescription = document.getElementById('modal-product-description');

    const detailUrl = "<?= site_url('product/detail/') ?>";

    detailModal.addEventListener('show.bs.modal', async (event) => {
        const button = event.relatedTarget;
        const productId = button.getAttribute('data-id');

        modalName.textContent = 'Memuat...';
        modalImage.src = 'https://via.placeholder.com/400';

        try {
            const response = await fetch(detailUrl + productId);
            if (!response.ok) throw new Error('Produk tidak ditemukan');
            const product = await response.json();

            modalName.textContent = product.name;
            modalCategory.textContent = product.category_name;
            modalPrice.textContent = `Rp ${Number(product.price_per_kg).toLocaleString('id-ID')} / Kg`;
            modalDescription.textContent = product.description;
            modalImage.src = product.image_url;
        } catch (error) {
            modalName.textContent = 'Gagal memuat data';
            console.error(error);
        }
    });
});
</script>
<?= $this->endSection() ?>
