<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Stat Cards Row -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-wrap" style="background:#ede9fe;color:#7c3aed;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <div class="text-muted small">Penjualan Hari Ini</div>
                    <div class="fw-bold fs-5">Rp <?= number_format($total_today, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-wrap" style="background:#dbeafe;color:#1d4ed8;">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div>
                    <div class="text-muted small">Penjualan Bulan Ini</div>
                    <div class="fw-bold fs-5">Rp <?= number_format($total_month, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-wrap" style="background:#dcfce7;color:#15803d;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <div class="text-muted small">Transaksi Hari Ini</div>
                    <div class="fw-bold fs-5"><?= $count_today ?> transaksi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-wrap" style="background:#fef9c3;color:#a16207;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Produk</div>
                    <div class="fw-bold fs-5"><?= $total_products ?> item</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart + Top Products -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Grafik Penjualan 7 Hari Terakhir</h6>
                </div>
                <canvas id="salesChart" height="90"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Produk Terlaris</h6>
                <?php if (empty($top_products)): ?>
                    <p class="text-muted small">Belum ada data penjualan.</p>
                <?php else: ?>
                    <?php foreach ($top_products as $idx => $prod): ?>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div style="width:28px;height:28px;background:#4f46e5;color:#fff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;">
                                <?= $idx + 1 ?>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="fw-medium text-truncate small"><?= esc($prod['product_name']) ?></div>
                                <div class="text-muted" style="font-size:.72rem;"><?= $prod['total_qty'] ?> terjual</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold small text-nowrap">Rp <?= number_format($prod['total_revenue'], 0, ',', '.') ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sales + Low Stock -->
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Transaksi Terbaru</h6>
                    <a href="/sales" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Bayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_sales)): ?>
                                <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi</td></tr>
                            <?php else: ?>
                                <?php foreach ($recent_sales as $sale): ?>
                                    <tr>
                                        <td><a href="/sales/<?= $sale['id'] ?>/show" class="fw-medium text-decoration-none"><?= esc($sale['invoice_number']) ?></a></td>
                                        <td class="small"><?= esc($sale['cashier_name'] ?? '-') ?></td>
                                        <td class="small">Rp <?= number_format($sale['grand_total'], 0, ',', '.') ?></td>
                                        <td><span class="badge bg-secondary"><?= esc($sale['payment_method']) ?></span></td>
                                        <td><span class="badge badge-status-<?= $sale['status'] ?>"><?= ucfirst($sale['status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Stok Menipis <span class="badge bg-danger ms-1"><?= count($low_stock) ?></span></h6>
                    <a href="/products" class="btn btn-sm btn-outline-primary">Kelola</a>
                </div>
                <?php if (empty($low_stock)): ?>
                    <p class="text-muted small">Semua stok masih mencukupi.</p>
                <?php else: ?>
                    <?php foreach ($low_stock as $item): ?>
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <div class="fw-medium small"><?= esc($item['name']) ?></div>
                                <div class="text-muted" style="font-size:.72rem;"><?= esc($item['code']) ?></div>
                            </div>
                            <span class="badge <?= $item['stock'] <= 5 ? 'bg-danger' : 'bg-warning text-dark' ?>">
                                <?= $item['stock'] ?> <?= esc($item['unit']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
    const raw   = <?= $chart_data ?>;
    const labels = raw.map(r => r.date);
    const values = raw.map(r => parseFloat(r.total));

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: values,
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79,70,229,.1)',
                fill: true,
                tension: .4,
                pointBackgroundColor: '#4f46e5',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') }
                }
            }
        }
    });
}());
</script>
<?= $this->endSection() ?>
