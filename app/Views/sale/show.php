<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Detail Transaksi</h5>
        <small class="text-muted"><?= esc($sale['invoice_number']) ?></small>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-secondary">
            <i class="bi bi-printer me-1"></i> Cetak
        </button>
        <a href="/sales" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <h6 class="fw-bold text-primary fs-5 mb-0"><?= esc($sale['invoice_number']) ?></h6>
                        <div class="text-muted small"><?= date('d F Y H:i', strtotime($sale['created_at'])) ?></div>
                    </div>
                    <span class="badge badge-status-<?= $sale['status'] ?> px-3 py-2 align-self-start fs-6">
                        <?= ucfirst($sale['status']) ?>
                    </span>
                </div>

                <!-- Items Table -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sale['items'] as $i => $item): ?>
                                <tr>
                                    <td class="text-muted small"><?= $i + 1 ?></td>
                                    <td class="fw-medium"><?= esc($item['product_name']) ?></td>
                                    <td class="text-center"><?= $item['quantity'] ?></td>
                                    <td class="text-end">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                    <td class="text-end fw-semibold">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="4" class="text-end fw-medium">Subtotal</td>
                                <td class="text-end fw-medium">Rp <?= number_format($sale['total_amount'], 0, ',', '.') ?></td>
                            </tr>
                            <?php if ($sale['discount'] > 0): ?>
                                <tr>
                                    <td colspan="4" class="text-end text-danger">Diskon</td>
                                    <td class="text-end text-danger">- Rp <?= number_format($sale['discount'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr class="fw-bold fs-6">
                                <td colspan="4" class="text-end text-primary">Total Bayar</td>
                                <td class="text-end text-primary">Rp <?= number_format($sale['grand_total'], 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <?php if ($sale['note']): ?>
                    <div class="alert alert-light border mt-2">
                        <i class="bi bi-sticky me-1"></i> <strong>Catatan:</strong> <?= esc($sale['note']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Informasi Transaksi</h6>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted">Pelanggan</td>
                        <td class="fw-medium"><?= esc($sale['customer_name'] ?? 'Pelanggan Umum') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Pembayaran</td>
                        <td><span class="badge bg-secondary"><?= esc(ucfirst($sale['payment_method'])) ?></span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tanggal</td>
                        <td><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></td>
                    </tr>
                </table>

                <hr>

                <div class="d-grid gap-2">
                    <a href="/sales/<?= $sale['id'] ?>/delete"
                       class="btn btn-outline-danger"
                       onclick="return confirm('Yakin hapus transaksi ini?')">
                        <i class="bi bi-trash me-1"></i> Hapus Transaksi
                    </a>
                    <a href="/sales" class="btn btn-outline-secondary">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
