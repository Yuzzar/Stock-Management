<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Data Produk</h5>
        <small class="text-muted">Kelola semua produk</small>
    </div>
    <a href="/products/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Produk
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Produk</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                                Belum ada produk. <a href="/products/create">Tambah sekarang</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $i => $prod): ?>
                            <tr>
                                <td class="text-muted small"><?= $i + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if ($prod['image']): ?>
                                            <img src="/<?= esc($prod['image']) ?>" width="36" height="36"
                                                 style="border-radius:8px;object-fit:cover;" alt="img">
                                        <?php else: ?>
                                            <div style="width:36px;height:36px;background:#e5e7eb;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-medium"><?= esc($prod['name']) ?></div>
                                            <div class="text-muted" style="font-size:.72rem;"><?= esc($prod['unit']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><code class="text-muted small"><?= esc($prod['code']) ?></code></td>
                                <td class="small"><?= esc($prod['category_name'] ?? '<span class="text-muted">-</span>') ?></td>
                                <td class="text-end fw-medium">Rp <?= number_format($prod['price'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $prod['stock'] <= 10 ? 'bg-danger' : 'bg-success' ?>">
                                        <?= $prod['stock'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($prod['is_active']): ?>
                                        <span class="badge" style="background:#d1fae5;color:#065f46;">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge" style="background:#fee2e2;color:#991b1b;">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="/products/<?= $prod['id'] ?>/edit"
                                       class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/products/<?= $prod['id'] ?>/delete"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Hapus"
                                       onclick="return confirm('Yakin hapus produk ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
