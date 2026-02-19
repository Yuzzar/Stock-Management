<?php

namespace App\Services;

use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\ProductModel;

class SaleService
{
    protected SaleModel     $saleModel;
    protected SaleItemModel $saleItemModel;
    protected ProductModel  $productModel;

    public function __construct()
    {
        $this->saleModel     = new SaleModel();
        $this->saleItemModel = new SaleItemModel();
        $this->productModel  = new ProductModel();
    }

    public function getAll(): array
    {
        return $this->saleModel->getRecentSales(100);
    }

    public function findById(int $id): ?array
    {
        $sale = $this->saleModel->find($id);
        if ($sale) {
            $sale['items'] = $this->saleItemModel->getBySaleId($id);
        }

        return $sale;
    }

    public function create(array $data, array $items): bool|int
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $data['invoice_number'] = $this->saleModel->generateInvoiceNumber();
        $data['user_id']        = session()->get('user_id');

        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['subtotal'];
        }

        $data['total_amount'] = $totalAmount;
        $data['grand_total']  = $totalAmount - ($data['discount'] ?? 0);

        $saleId = $this->saleModel->insert($data);

        if (! $saleId) {
            $db->transRollback();

            return false;
        }

        foreach ($items as $item) {
            $item['sale_id'] = $saleId;
            $this->saleItemModel->insert($item);

            // Kurangi stok produk
            $product = $this->productModel->find($item['product_id']);
            if ($product) {
                $this->productModel->update($item['product_id'], [
                    'stock' => max(0, $product['stock'] - $item['quantity']),
                ]);
            }
        }

        $db->transComplete();

        return $db->transStatus() ? $saleId : false;
    }

    public function getDashboardStats(): array
    {
        return [
            'total_today'       => $this->saleModel->getTotalSalesToday(),
            'total_this_month'  => $this->saleModel->getTotalSalesThisMonth(),
            'count_today'       => $this->saleModel->getCountToday(),
            'recent_sales'      => $this->saleModel->getRecentSales(5),
            'top_products'      => $this->saleItemModel->getTopProducts(5),
            'chart_data'        => $this->saleModel->getSalesChartData(7),
        ];
    }
}
