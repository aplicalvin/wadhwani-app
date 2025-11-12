<div class="sidebar bg-dark text-white p-3 d-flex flex-column">
    <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <span class="fs-4">Wadhani Iwak</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= site_url('admin') ?>" class="nav-link text-white <?= (uri_string() == 'admin') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= site_url('admin/categories') ?>" class="nav-link text-white <?= (strpos(uri_string(), 'admin/categories') !== false) ? 'active' : '' ?>">
                <i class="bi bi-tags me-2"></i> Kategori
            </a>
        </li>
        <li>
            <a href="<?= site_url('admin/products') ?>" class="nav-link text-white <?= (strpos(uri_string(), 'admin/products') !== false) ? 'active' : '' ?>">
                <i class="bi bi-box-seam me-2"></i> Produk
            </a>
        </li>
        <li>
            <a href="<?= site_url('admin/testimonials') ?>" class="nav-link text-white <?= (strpos(uri_string(), 'admin/testimonials') !== false) ? 'active' : '' ?>">
                <i class="bi bi-chat-left-quote me-2"></i> Testimoni
            </a>
        </li>
        <li>
            <a href="<?= site_url('admin/users') ?>" class="nav-link text-white <?= (strpos(uri_string(), 'admin/testimonials') !== false) ? 'active' : '' ?>">
                <i class="bi bi-chat-left-quote me-2"></i> Users
            </a>
        </li>
        <li>
            <a href="<?= site_url('admin/settings') ?>" class="nav-link text-white <?= (strpos(uri_string(), 'admin/settings') !== false) ? 'active' : '' ?>">
                <i class="bi bi-gear me-2"></i> Pengaturan
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <strong><?= esc(session()->get('name')) ?? 'Admin' ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="<?= site_url('logout') ?>">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a></li>
        </ul>
    </div>
</div>