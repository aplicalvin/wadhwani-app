<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Wadhani Iwak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-card {
            max-width: 450px;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow-sm login-card w-100">
        <div class="card-body p-4 p-md-5">
            <h3 class="card-title text-center mb-4">Admin Panel Login</h3>

            <?php if (session()->get('error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->get('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('login/attempt') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= isset(session('errors')['email']) ? 'is-invalid' : '' ?>" 
                           id="email" name="email" value="<?= old('email') ?>" required>
                    <?php if(isset(session('errors')['email'])): ?>
                        <div class="invalid-feedback"><?= esc(session('errors')['email']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= isset(session('errors')['password']) ? 'is-invalid' : '' ?>" 
                           id="password" name="password" required>
                    <?php if(isset(session('errors')['password'])): ?>
                        <div class="invalid-feedback"><?= esc(session('errors')['password']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                </div>
            </form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>