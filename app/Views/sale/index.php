<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Data Penjualan</h5>
        <small class="text-muted">Riwayat semua transaksi</small>
    </div>
    <a href="/sales/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Transaksi
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th class="text-end">Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($sales)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">
                                <i class="bi bi-receipt fs-2 d-block mb-2"></i>
                                Belum ada transaksi. <a href="/sales/create">Buat sekarang</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($sales as $i => $sale): ?>
                            <tr>
                                <td class="text-muted small"><?= $i + 1 ?></td>
                                <td>
                                    <a href="/sales/<?= $sale['id'] ?>/show"
                                       class="fw-medium text-decoration-none text-primary">
                                        <?= esc($sale['invoice_number']) ?>
                                    </a>
                                </td>
                                <td class="small"><?= esc($sale['customer_name'] ?? 'Umum') ?></td>
                                <td class="small"><?= esc($sale['cashier_name'] ?? '-') ?></td>
                                <td class="text-end fw-semibold">Rp <?= number_format($sale['grand_total'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge bg-secondary"><?= esc(ucfirst($sale['payment_method'])) ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-status-<?= $sale['status'] ?>">
                                        <?= ucfirst($sale['status']) ?>
                                    </span>
                                </td>
                                <td class="small text-muted"><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></td>
                                <td class="text-center">
                                    <a href="/sales/<?= $sale['id'] ?>/show"
                                       class="btn btn-sm btn-outline-primary me-1" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/sales/<?= $sale['id'] ?>/delete"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Hapus"
                                       onclick="return confirm('Yakin hapus transaksi ini?')">
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
