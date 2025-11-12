<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fresh Fish</title>
    <link rel="shortcut icon" href="<?= base_url('logo.png') ?>" type="image/x-icon">


    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2C5F6C;
            --secondary-color: #E4F0F5;
            --accent-color: #74B3CE;
        }

        body {
            font-family: 'Raleway', sans-serif;
            color: #1A1A1A;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-color);
            padding: 1rem 0;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 600;
        }
        .navbar-nav .nav-link:hover {
            color: var(--accent-color) !important;
        }

        /* Hero section */
        .hero-section {
            background-size: cover;
            background-position: center;
            color: white;
            text-shadow: 0 3px 6px rgba(0,0,0,0.5);
            background-blend-mode: overlay;
            background-color: rgba(44,95,108,0.6);
        }

        .btn-primary {
            background-color: #fff;
            color: var(--primary-color);
            border: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: var(--accent-color);
            color: white;
        }

        /* Cards & sections */
        .bg-light {
            background-color: var(--secondary-color) !important;
        }
        .card {
            border: none;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        /* Footer */
        footer {
            background-color: var(--primary-color);
            color: white;
        }
        footer a {
            color: #fff;
        }
        footer a:hover {
            color: var(--accent-color);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= site_url('/') ?>">
                <img src="<?= base_url('logo.png') ?>" alt="Logo">
                <span>Fresh Fish</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('/') ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= site_url('products') ?>">Produk Kami</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="pt-5 pb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4">
                    <h5>Fresh Fish</h5>
                    <p><?= esc($settings['alamat'] ?? 'Alamat belum diatur.') ?></p>
                    <p><i class="bi bi-whatsapp me-2"></i><?= esc($settings['telepon'] ?? 'No. WA belum diatur') ?></p>
                    <div>
                        <a href="<?= esc($settings['ig_link'] ?? '#') ?>" class="text-white fs-4 me-3"><i class="bi bi-instagram"></i></a>
                        <a href="<?= esc($settings['tiktok_link'] ?? '#') ?>" class="text-white fs-4"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Lokasi Kami</h5>
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.225673823467!2d110.40648567445166!3d-6.982674068378172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b4ec52229d7%3A0xc791d6abc9236c7!2sUniversitas%20Dian%20Nuswantoro!5e0!3m2!1sid!2sid!4v1762943089343!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
