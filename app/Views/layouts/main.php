<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'TokoKu') ?> - Sistem Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #4f46e5;
        }
        body { background: #f5f6fa; font-family: 'Segoe UI', sans-serif; }
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: #1e1b4b;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: all .3s;
        }
        #sidebar .brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,.7);
            padding: .6rem 1.25rem;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all .2s;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background: rgba(255,255,255,.15);
            color: #fff;
        }
        #sidebar .nav-link i { margin-right: 8px; font-size: 1rem; }
        #content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: .75rem 1.5rem;
        }
        .stat-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 6px rgba(0,0,0,.07);
        }
        .stat-card .icon-wrap {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .table th { font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; }
        .badge-status-selesai  { background: #d1fae5; color: #065f46; }
        .badge-status-batal    { background: #fee2e2; color: #991b1b; }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

<!-- Sidebar -->
<nav id="sidebar">
    <div class="brand d-flex align-items-center gap-2">
        <div style="background:#6366f1;border-radius:8px;padding:6px 10px;">
            <i class="bi bi-shop text-white fs-5"></i>
        </div>
        <span class="text-white fw-bold fs-5">TokoKu</span>
    </div>

    <div class="mt-3">
        <small class="text-white-50 px-3 text-uppercase" style="font-size:.7rem;letter-spacing:.1em">Menu</small>
        <ul class="nav flex-column mt-1">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link <?= (uri_string() === 'dashboard') ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="/sales" class="nav-link <?= str_starts_with(uri_string(), 'sale') ? 'active' : '' ?>">
                    <i class="bi bi-cart3"></i> Penjualan
                </a>
            </li>
            <li class="nav-item">
                <a href="/products" class="nav-link <?= str_starts_with(uri_string(), 'product') ? 'active' : '' ?>">
                    <i class="bi bi-box-seam"></i> Produk
                </a>
            </li>
            <li class="nav-item">
                <a href="/categories" class="nav-link <?= str_starts_with(uri_string(), 'categor') ? 'active' : '' ?>">
                    <i class="bi bi-tags"></i> Kategori
                </a>
            </li>
        </ul>

        <hr style="border-color:rgba(255,255,255,.1);margin:1rem .75rem;">

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/logout" class="nav-link text-danger">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div id="content">
    <!-- Topbar -->
    <div id="topbar" class="d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold"><?= esc($title ?? 'Halaman') ?></h6>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small"><?= date('l, d M Y') ?></span>
            <div class="d-flex align-items-center gap-2">
                <div style="width:34px;height:34px;background:#4f46e5;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-person-fill text-white"></i>
                </div>
                <div>
                    <div class="fw-semibold small lh-1"><?= esc(session('user_name')) ?></div>
                    <div class="text-muted" style="font-size:.72rem;"><?= esc(ucfirst(session('user_role'))) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="p-4">
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i><?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->has('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i><strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    <?php foreach (session('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
