<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleItemModel extends Model
{
    protected $table            = 'sale_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sale_id', 'product_id', 'product_name',
        'quantity', 'price', 'subtotal',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBySaleId(int $saleId): array
    {
        return $this->where('sale_id', $saleId)->findAll();
    }

    public function getTopProducts(int $limit = 5): array
    {
        return $this->select('product_name, SUM(quantity) as total_qty, SUM(subtotal) as total_revenue')
            ->groupBy('product_id, product_name')
            ->orderBy('total_qty', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
