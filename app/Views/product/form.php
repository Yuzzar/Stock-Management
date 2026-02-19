<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0"><?= esc($title) ?></h5>
        <small class="text-muted">Form data produk</small>
    </div>
    <a href="/products" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 760px;">
    <div class="card-body">
        <form action="<?= $product ? '/products/' . $product['id'] . '/update' : '/products/store' ?>"
              method="POST"
              enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-medium">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="<?= esc(old('name', $product['name'] ?? '')) ?>"
                           placeholder="Nama produk" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-medium">Kode Produk <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control"
                           value="<?= esc(old('code', $product['code'] ?? '')) ?>"
                           placeholder="PRD-001" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Tanpa Kategori --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= old('category_id', $product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium">Satuan <span class="text-danger">*</span></label>
                    <input type="text" name="unit" class="form-control"
                           value="<?= esc(old('unit', $product['unit'] ?? 'pcs')) ?>"
                           placeholder="pcs / kg / ltr" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-medium">Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control" min="0"
                           value="<?= esc(old('stock', $product['stock'] ?? 0)) ?>"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Harga Jual (Rp) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="price" class="form-control" min="0" step="0.01"
                               value="<?= esc(old('price', $product['price'] ?? 0)) ?>"
                               required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Harga Modal (Rp)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="cost_price" class="form-control" min="0" step="0.01"
                               value="<?= esc(old('cost_price', $product['cost_price'] ?? 0)) ?>">
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-medium">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Deskripsi produk..."><?= esc(old('description', $product['description'] ?? '')) ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-medium">Gambar Produk</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <div class="form-text">Maks. 2MB. Format: JPG, PNG, GIF</div>
                    <?php if ($product && $product['image']): ?>
                        <div class="mt-2">
                            <img src="/<?= esc($product['image']) ?>" height="60"
                                 style="border-radius:8px;object-fit:cover;" alt="Gambar saat ini">
                            <div class="text-muted" style="font-size:.72rem;">Gambar saat ini (kosongkan jika tidak ingin mengganti)</div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($product): ?>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= ($product['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= ($product['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    <?= $product ? 'Perbarui' : 'Simpan' ?>
                </button>
                <a href="/products" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
