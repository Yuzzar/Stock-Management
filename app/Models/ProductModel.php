<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id', 'code', 'name', 'description',
        'price', 'cost_price', 'stock', 'unit', 'image', 'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'  => 'required|min_length[2]|max_length[150]',
        'code'  => 'required|is_unique[products.code,id,{id}]',
        'price' => 'required|numeric|greater_than_equal_to[0]',
        'stock' => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'name'  => ['required' => 'Nama produk wajib diisi.'],
        'code'  => ['required' => 'Kode produk wajib diisi.', 'is_unique' => 'Kode produk sudah digunakan.'],
        'price' => ['required' => 'Harga wajib diisi.', 'numeric' => 'Harga harus berupa angka.'],
        'stock' => ['required' => 'Stok wajib diisi.', 'integer' => 'Stok harus berupa angka bulat.'],
    ];

    public function getWithCategory(): array
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->orderBy('products.name', 'ASC')
            ->findAll();
    }

    public function getLowStock(int $threshold = 10): array
    {
        return $this->where('stock <=', $threshold)
            ->where('is_active', 1)
            ->findAll();
    }

    public function searchByKeyword(string $keyword): array
    {
        return $this->like('name', $keyword)
            ->orLike('code', $keyword)
            ->where('is_active', 1)
            ->findAll();
    }
}
