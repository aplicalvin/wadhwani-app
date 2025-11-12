<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

    <h1 class="h3 mb-3">Dashboard</h1>

    <div class="row">
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-bg-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-uppercase mb-1">Total Kategori</div>
                            <div class="h5 mb-0 fw-bold"><?= $totalCategories ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-tags fs-2 text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-bg-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-uppercase mb-1">Total Produk (Aktif)</div>
                            <div class="h5 mb-0 fw-bold"><?= $totalProducts ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fs-2 text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-bg-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-uppercase mb-1">Jumlah Review (Approved)</div>
                            <div class="h5 mb-0 fw-bold"><?= $totalTestimonials ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-chat-left-quote fs-2 text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card text-bg-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-uppercase mb-1">Rata-rata Rating</div>
                            <div class="h5 mb-0 fw-bold">
                                <?= number_format($averageRating, 1) ?> 
                                <i class="bi bi-star-fill" style="font-size: 0.8em;"></i>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-star-half fs-2 text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?= $this->endSection() ?>