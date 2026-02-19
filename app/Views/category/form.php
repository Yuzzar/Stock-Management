<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0"><?= esc($title) ?></h5>
        <small class="text-muted">Form data kategori</small>
    </div>
    <a href="/categories" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="<?= $category ? '/categories/' . $category['id'] . '/update' : '/categories/store' ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label fw-medium">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="<?= esc(old('name', $category['name'] ?? '')) ?>"
                       placeholder="Contoh: Elektronik"
                       required>
                <div class="form-text">Slug akan dibuat otomatis dari nama kategori.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-medium">Deskripsi</label>
                <textarea name="description"
                          class="form-control"
                          rows="3"
                          placeholder="Deskripsi singkat kategori..."><?= esc(old('description', $category['description'] ?? '')) ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>
                    <?= $category ? 'Perbarui' : 'Simpan' ?>
                </button>
                <a href="/categories" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
