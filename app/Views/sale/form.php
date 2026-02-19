<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
    .product-row { border: 1px solid #e5e7eb; border-radius: 10px; padding: 1rem; background: #fafafa; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Buat Transaksi Baru</h5>
        <small class="text-muted">Isi data penjualan</small>
    </div>
    <a href="/sales" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form action="/sales/store" method="POST" id="saleForm">
    <?= csrf_field() ?>
    <div class="row g-4">
        <!-- Kiri: Informasi Transaksi -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Informasi Transaksi</h6>

                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama Pelanggan</label>
                        <input type="text" name="customer_name" class="form-control"
                               placeholder="Pelanggan umum" value="<?= esc(old('customer_name')) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Metode Pembayaran <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select" required>
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Diskon (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="discount" id="discountInput"
                                   class="form-control" min="0" value="0"
                                   oninput="updateGrandTotal()">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Catatan</label>
                        <textarea name="note" class="form-control" rows="2"
                                  placeholder="Catatan opsional..."></textarea>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between fw-medium">
                        <span>Subtotal</span>
                        <span id="subtotalDisplay">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between text-danger">
                        <span>Diskon</span>
                        <span id="discountDisplay">Rp 0</span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold fs-5 mt-2 text-primary">
                        <span>Total</span>
                        <span id="grandTotalDisplay">Rp 0</span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3 py-2">
                        <i class="bi bi-check-circle me-1"></i> Simpan Transaksi
                    </button>
                </div>
            </div>
        </div>

        <!-- Kanan: Item Produk -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Item Produk</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addRow()">
                            <i class="bi bi-plus me-1"></i> Tambah Produk
                        </button>
                    </div>

                    <div id="itemsContainer">
                        <!-- rows akan ditambahkan lewat JS -->
                    </div>
                    <div id="emptyMsg" class="text-center py-4 text-muted">
                        <i class="bi bi-cart-plus fs-2 d-block mb-2"></i>
                        Klik "Tambah Produk" untuk memulai.
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
const products = <?= json_encode(array_map(fn($p) => [
    'id'    => $p['id'],
    'name'  => $p['name'],
    'price' => (float) $p['price'],
    'stock' => $p['stock'],
    'unit'  => $p['unit'],
], $products)) ?>;

let rowCount = 0;

function addRow() {
    const container = document.getElementById('itemsContainer');
    document.getElementById('emptyMsg').style.display = 'none';

    const idx  = rowCount++;
    const opts = products.map(p =>
        `<option value="${p.id}" data-price="${p.price}" data-unit="${p.unit}" data-stock="${p.stock}">${p.name} (Stok: ${p.stock})</option>`
    ).join('');

    const row = document.createElement('div');
    row.className = 'product-row mb-3';
    row.id        = `row-${idx}`;
    row.innerHTML = `
        <div class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small fw-medium">Produk</label>
                <select name="items[${idx}][product_id]" class="form-select form-select-sm"
                        onchange="onProductChange(this, ${idx})" required>
                    <option value="">-- Pilih Produk --</option>
                    ${opts}
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-medium">Satuan</label>
                <input type="text" id="unit-${idx}" class="form-control form-control-sm" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-medium">Qty</label>
                <input type="number" name="items[${idx}][quantity]" id="qty-${idx}"
                       class="form-control form-control-sm" min="1" value="1"
                       oninput="calcRow(${idx})" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-medium">Subtotal</label>
                <input type="text" id="sub-${idx}" class="form-control form-control-sm fw-bold" readonly value="Rp 0">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(${idx})">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(row);
}

function onProductChange(sel, idx) {
    const opt   = sel.options[sel.selectedIndex];
    const price = parseFloat(opt.dataset.price) || 0;
    const unit  = opt.dataset.unit || '';
    const stock = parseInt(opt.dataset.stock) || 0;

    document.getElementById(`unit-${idx}`).value = unit;
    const qtyEl = document.getElementById(`qty-${idx}`);
    qtyEl.max = stock;
    calcRow(idx, price);
}

function calcRow(idx, priceOverride) {
    const sel   = document.querySelector(`select[name="items[${idx}][product_id]"]`);
    const opt   = sel ? sel.options[sel.selectedIndex] : null;
    const price = priceOverride !== undefined ? priceOverride : (opt ? parseFloat(opt.dataset.price) || 0 : 0);
    const qty   = parseInt(document.getElementById(`qty-${idx}`)?.value) || 0;
    const sub   = price * qty;

    const subEl = document.getElementById(`sub-${idx}`);
    if (subEl) subEl.value = 'Rp ' + sub.toLocaleString('id-ID');

    updateGrandTotal();
}

function removeRow(idx) {
    document.getElementById(`row-${idx}`)?.remove();
    if (document.getElementById('itemsContainer').children.length === 0) {
        document.getElementById('emptyMsg').style.display = '';
    }
    updateGrandTotal();
}

function updateGrandTotal() {
    let subtotal = 0;
    document.querySelectorAll('[id^="sub-"]').forEach(el => {
        const val = el.value.replace('Rp ', '').replace(/\./g, '').replace(',', '.');
        subtotal += parseFloat(val) || 0;
    });

    const discount   = parseFloat(document.getElementById('discountInput')?.value) || 0;
    const grandTotal = Math.max(0, subtotal - discount);

    document.getElementById('subtotalDisplay').textContent  = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('discountDisplay').textContent  = 'Rp ' + discount.toLocaleString('id-ID');
    document.getElementById('grandTotalDisplay').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
}
</script>

<?= $this->endSection() ?>
