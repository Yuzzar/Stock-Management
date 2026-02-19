<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\SaleService;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class Dashboard extends BaseController
{
    protected SaleService   $saleService;
    protected ProductModel  $productModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->saleService   = new SaleService();
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $stats = $this->saleService->getDashboardStats();

        $data = [
            'title'          => 'Dashboard',
            'total_today'    => $stats['total_today'],
            'total_month'    => $stats['total_this_month'],
            'count_today'    => $stats['count_today'],
            'recent_sales'   => $stats['recent_sales'],
            'top_products'   => $stats['top_products'],
            'chart_data'     => json_encode($stats['chart_data']),
            'total_products' => $this->productModel->countAll(),
            'low_stock'      => $this->productModel->getLowStock(10),
            'total_category' => $this->categoryModel->countAll(),
        ];

        return view('dashboard/index', $data);
    }
}
