<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?= csrf_meta() ?>

    <title>Wadhani Iwak - Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* CSS Sederhana untuk Sidebar */
        .sidebar {
            width: 280px;
            min-height: 100vh;
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <?= $this->include('partials/admin_sidebar') ?>
        
        <div class="flex-grow-1 p-4" style="background-color: #f8f9fa;">
            
            <?= $this->renderSection('content') ?> </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>