<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penjualan TokoKu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            width: 420px;
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
        }
        .login-card .card-body { padding: 2.5rem; }
        .brand-icon {
            width: 60px; height: 60px;
            background: #4f46e5;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1rem;
        }
        .form-control:focus { border-color: #4f46e5; box-shadow: 0 0 0 .2rem rgba(79,70,229,.25); }
        .btn-primary { background: #4f46e5; border-color: #4f46e5; }
        .btn-primary:hover { background: #4338ca; border-color: #4338ca; }
        .input-group-text { background: #f9fafb; }
    </style>
</head>
<body>
    <div class="login-card card">
        <div class="card-body">
            <div class="text-center mb-4">
                <div class="brand-icon">
                    <i class="bi bi-shop text-white"></i>
                </div>
                <h4 class="fw-bold mb-1">TokoKu</h4>
                <p class="text-muted small">Sistem Manajemen Penjualan</p>
            </div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger py-2">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    <?= esc(session('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger py-2">
                    <?php foreach (session('errors') as $err): ?>
                        <div><i class="bi bi-dot"></i><?= esc($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-medium">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="username"
                               class="form-control"
                               value="<?= esc(old('username')) ?>"
                               placeholder="admin"
                               required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-medium">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="••••••••"
                               required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-medium">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            <p class="text-center text-muted small mt-4 mb-0">
                &copy; <?= date('Y') ?> TokoKu. All rights reserved.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
