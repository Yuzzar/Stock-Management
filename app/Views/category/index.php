<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Data Kategori</h5>
        <small class="text-muted">Kelola kategori produk</small>
    </div>
    <a href="/categories/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Jumlah Produk</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada kategori. <a href="/categories/create">Tambah sekarang</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categories as $i => $cat): ?>
                            <tr>
                                <td class="text-muted small"><?= $i + 1 ?></td>
                                <td class="fw-medium"><?= esc($cat['name']) ?></td>
                                <td><code class="text-muted small"><?= esc($cat['slug']) ?></code></td>
                                <td class="text-muted small"><?= esc(substr($cat['description'] ?? '-', 0, 60)) ?>...</td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill"><?= $cat['product_count'] ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="/categories/<?= $cat['id'] ?>/edit"
                                       class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/categories/<?= $cat['id'] ?>/delete"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Hapus"
                                       onclick="return confirm('Yakin hapus kategori ini?')">
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
