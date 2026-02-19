<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID kategori yang sudah dibuat
        $cats = $this->db->table('categories')->get()->getResultArray();
        $catMap = array_column($cats, 'id', 'slug');

        $products = [
            // Elektronik
            ['category' => 'elektronik',      'code' => 'ELK-001', 'name' => 'Headphone Bluetooth',   'price' => 250000, 'cost' => 150000, 'stock' => 30],
            ['category' => 'elektronik',      'code' => 'ELK-002', 'name' => 'Charger USB-C 65W',     'price' => 120000, 'cost' => 70000,  'stock' => 50],
            ['category' => 'elektronik',      'code' => 'ELK-003', 'name' => 'Mouse Wireless',        'price' => 150000, 'cost' => 90000,  'stock' => 25],
            // Makanan
            ['category' => 'makanan-minuman', 'code' => 'MKN-001', 'name' => 'Kopi Arabika 200g',     'price' => 45000,  'cost' => 28000,  'stock' => 100],
            ['category' => 'makanan-minuman', 'code' => 'MKN-002', 'name' => 'Teh Hijau Premium',     'price' => 35000,  'cost' => 20000,  'stock' => 80],
            ['category' => 'makanan-minuman', 'code' => 'MKN-003', 'name' => 'Susu Full Cream 1L',   'price' => 22000,  'cost' => 15000,  'stock' => 5],
            // Pakaian
            ['category' => 'pakaian',         'code' => 'PKN-001', 'name' => 'Kaos Polos Cotton',    'price' => 75000,  'cost' => 40000,  'stock' => 60],
            ['category' => 'pakaian',         'code' => 'PKN-002', 'name' => 'Celana Chino',         'price' => 185000, 'cost' => 100000, 'stock' => 3],
            // Alat Tulis
            ['category' => 'alat-tulis',      'code' => 'ALT-001', 'name' => 'Pulpen Gel 0.5mm',     'price' => 8000,   'cost' => 4000,   'stock' => 200],
            ['category' => 'alat-tulis',      'code' => 'ALT-002', 'name' => 'Buku Tulis 58 Lembar', 'price' => 12000,  'cost' => 7000,   'stock' => 150],
            // Perawatan
            ['category' => 'perawatan-diri',  'code' => 'PRW-001', 'name' => 'Sabun Mandi Cair',     'price' => 18000,  'cost' => 10000,  'stock' => 90],
            ['category' => 'perawatan-diri',  'code' => 'PRW-002', 'name' => 'Shampoo 170ml',        'price' => 23000,  'cost' => 13000,  'stock' => 7],
        ];

        $rows = [];
        foreach ($products as $p) {
            $rows[] = [
                'category_id' => $catMap[$p['category']] ?? null,
                'code'        => $p['code'],
                'name'        => $p['name'],
                'price'       => $p['price'],
                'cost_price'  => $p['cost'],
                'stock'       => $p['stock'],
                'unit'        => 'pcs',
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('products')->insertBatch($rows);
    }
}
