<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= csrf_meta() ?>
  <title>Reel Fresh - Admin Panel</title>

  <link rel="shortcut icon" href="<?= base_url('logo.png') ?>" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    body {
      background-color: #f8f9fa;
      overflow-x: hidden;
    }

    /* === SIDEBAR STYLE === */
    .sidebar {
      width: 260px;
      min-height: 100vh;
      background-color: #212529; /* Bootstrap bg-dark */
      transition: all 0.3s ease;
    }

    .sidebar hr {
      border-color: rgba(255,255,255,0.2);
    }

    .sidebar .nav-link {
      color: #adb5bd !important;
      font-weight: 500;
      border-radius: 6px;
      margin: 2px 0;
      transition: 0.2s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #0d6efd;
      color: #fff !important;
    }

    .sidebar .dropdown-toggle::after {
      filter: invert(1);
    }

    /* === RESPONSIVE BEHAVIOR === */
    @media (max-width: 992px) {
      .sidebar {
        position: fixed;
        top: 0;
        left: -260px;
        height: 100%;
        z-index: 1050;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      }

      .sidebar.show {
        left: 0;
      }

      .content {
        padding-top: 70px;
      }
    }

    /* === TOPBAR STYLE === */
    .topbar {
      background-color: #fff;
      border-bottom: 1px solid #dee2e6;
      position: sticky;
      top: 0;
      z-index: 1040;
    }

    .topbar .navbar-brand {
      font-weight: 700;
      color: #0d6efd !important;
    }

    .topbar .btn-outline-dark {
      border-color: #0d6efd;
      color: #0d6efd;
    }

    .topbar .btn-outline-dark:hover {
      background-color: #0d6efd;
      color: #fff;
    }

  </style>
</head>
<body>

  <!-- === TOPBAR === -->
  <nav class="navbar navbar-expand-lg topbar px-3 shadow-sm">
    <div class="container-fluid">
      <!-- Hamburger (Mobile) -->
      <button class="btn btn-outline-dark d-lg-none me-2" id="toggleSidebar">
        <i class="bi bi-list"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand" href="<?= base_url('/') ?>">Reel Fresh</a>

      <!-- Right section -->
      <div class="ms-auto d-flex align-items-center">
        <span class="me-3 text-secondary small">
          <?= esc(session()->get('name')) ?? 'Admin' ?>
        </span>
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </div>
    </div>
  </nav>

  <div class="d-flex">
    <!-- === SIDEBAR === -->
    <div class="sidebar bg-dark text-white p-3 d-flex flex-column" id="sidebar">
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="<?= site_url('admin') ?>" 
             class="nav-link <?= (uri_string() == 'admin') ? 'active' : 'text-white' ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/categories') ?>" 
             class="nav-link <?= (strpos(uri_string(), 'admin/categories') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-tags me-2"></i> Kategori
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/products') ?>" 
             class="nav-link <?= (strpos(uri_string(), 'admin/products') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-box-seam me-2"></i> Produk
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/testimonials') ?>" 
             class="nav-link <?= (strpos(uri_string(), 'admin/testimonials') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-chat-left-quote me-2"></i> Testimoni
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/users') ?>" 
             class="nav-link <?= (strpos(uri_string(), 'admin/users') !== false) ? 'active' : 'text-white' ?>">
            <i class="bi bi-people-fill me-2"></i> Users
          </a>
        </li>
        <li>
          <a href="<?= site_url('admin/settings') ?>" 
             class="nav-link <?= (strpos(uri_string(), 'admin/settings') !== false) ? 'active' : 'text-white' ?>">
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
          <li>
            <a class="dropdown-item" href="<?= site_url('logout') ?>">
              <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- === CONTENT === -->
    <div class="flex-grow-1 p-4 content">
      <?= $this->renderSection('content') ?>
    </div>
  </div>

  <!-- === SCRIPT === -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleSidebar.addEventListener('click', () => {
      sidebar.classList.toggle('show');
    });
  </script>

  <?= $this->renderSection('scripts') ?>
</body>
</html>
