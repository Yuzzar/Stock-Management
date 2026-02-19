<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\SaleService;
use App\Models\ProductModel;

class Sale extends BaseController
{
    protected SaleService  $saleService;
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->saleService  = new SaleService();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        return view('sale/index', [
            'title' => 'Data Penjualan',
            'sales' => $this->saleService->getAll(),
        ]);
    }

    public function create()
    {
        return view('sale/form', [
            'title'    => 'Buat Transaksi Baru',
            'products' => $this->productModel->where('is_active', 1)->where('stock >', 0)->findAll(),
        ]);
    }

    public function store()
    {
        $items = $this->request->getPost('items');

        if (empty($items)) {
            return redirect()->back()->with('error', 'Pilih minimal satu produk.');
        }

        $saleData = [
            'customer_name'  => $this->request->getPost('customer_name'),
            'discount'       => $this->request->getPost('discount') ?: 0,
            'payment_method' => $this->request->getPost('payment_method'),
            'note'           => $this->request->getPost('note'),
            'status'         => 'selesai',
        ];

        $saleItems = [];
        foreach ($items as $item) {
            if (empty($item['product_id']) || empty($item['quantity'])) {
                continue;
            }

            $product = $this->productModel->find($item['product_id']);
            if (! $product) {
                continue;
            }

            $qty      = (int) $item['quantity'];
            $price    = (float) $product['price'];
            $subtotal = $qty * $price;

            $saleItems[] = [
                'product_id'   => $product['id'],
                'product_name' => $product['name'],
                'quantity'     => $qty,
                'price'        => $price,
                'subtotal'     => $subtotal,
            ];
        }

        if (empty($saleItems)) {
            return redirect()->back()->with('error', 'Data item tidak valid.');
        }

        $saleId = $this->saleService->create($saleData, $saleItems);

        if (! $saleId) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi.');
        }

        return redirect()->to('/sales/' . $saleId . '/show')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show($id = null)
    {
        $sale = $this->saleService->findById((int) $id);

        if (! $sale) {
            return redirect()->to('/sales')->with('error', 'Transaksi tidak ditemukan.');
        }

        return view('sale/show', [
            'title' => 'Detail Transaksi',
            'sale'  => $sale,
        ]);
    }

    public function delete($id = null)
    {
        $sale = $this->saleService->findById((int) $id);

        if (! $sale) {
            return redirect()->to('/sales')->with('error', 'Transaksi tidak ditemukan.');
        }

        (new \App\Models\SaleModel())->delete($id);

        return redirect()->to('/sales')->with('success', 'Transaksi berhasil dihapus.');
    }
}
