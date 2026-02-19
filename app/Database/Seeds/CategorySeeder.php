<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Elektronik',      'slug' => 'elektronik',      'description' => 'Perangkat elektronik dan aksesoris'],
            ['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'description' => 'Produk konsumsi sehari-hari'],
            ['name' => 'Pakaian',          'slug' => 'pakaian',          'description' => 'Pakaian pria, wanita, dan anak'],
            ['name' => 'Alat Tulis',       'slug' => 'alat-tulis',       'description' => 'Perlengkapan kantor dan menulis'],
            ['name' => 'Perawatan Diri',   'slug' => 'perawatan-diri',   'description' => 'Produk kebersihan dan kecantikan'],
        ];

        foreach ($categories as &$cat) {
            $cat['created_at'] = date('Y-m-d H:i:s');
            $cat['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->table('categories')->insertBatch($categories);
    }
}
