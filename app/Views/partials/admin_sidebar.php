


  <!-- Navbar / Topbar -->
  <!-- <nav class="navbar navbar-expand-lg topbar px-3 shadow-sm">
    <div class="container-fluid">
      <button class="btn btn-outline-dark d-lg-none me-2" id="toggleSidebar">
        <i class="bi bi-list"></i>
      </button>
      <a class="navbar-brand fw-bold text-primary" href="#">Wadhani Iwak</a>
      <div class="ms-auto d-flex align-items-center">
        <span class="me-3 text-secondary"><?= esc(session()->get('name')) ?? 'Admin' ?></span>
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </div>
    </div>
  </nav> -->

  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar text-white p-3 d-flex flex-column" id="sidebar">
      <!-- <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
        <span class="fs-4 fw-bold">Wadhani Iwak</span>
      </a>
      <hr> -->
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="<?= site_url('admin') ?>" class="nav-link <?= (uri_string() == 'admin') ? 'active' : 'text-white' ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/categories') ?>" class="nav-link <?= (strpos(uri_string(), 'admin/categories') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-tags me-2"></i> Kategori
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/products') ?>" class="nav-link <?= (strpos(uri_string(), 'admin/products') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-box-seam me-2"></i> Produk
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/testimonials') ?>" class="nav-link <?= (strpos(uri_string(), 'admin/testimonials') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-chat-left-quote me-2"></i> Testimoni
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/users') ?>" class="nav-link <?= (strpos(uri_string(), 'admin/users') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-people-fill me-2"></i> Users
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/settings') ?>" class="nav-link <?= (strpos(uri_string(), 'admin/settings') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-gear me-2"></i> Pengaturan
          </a>
        </li>
      </ul>
      <hr>
      <div class="dropdown mt-auto">
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


  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleSidebar.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });
  </script>

  <?= $this->renderSection('scripts') ?>

