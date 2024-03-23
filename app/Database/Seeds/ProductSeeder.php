<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => uniqid(),
                'name' => 'iPhone 14 Pro Max',
                'category' => 'Gadget',
                'price' => 17999000,
                'stock' => 12,
                'created_at' => new RawSql('CURRENT_TIMESTAMP')
            ],
            [
                'id' => uniqid(),
                'name' => 'iPad Pro M2',
                'category' => 'Gadget',
                'price' => 15499000,
                'stock' => 35,
                'created_at' => new RawSql('CURRENT_TIMESTAMP')
            ],
        ];

        $this->db->table('products')->insertBatch($data);
    }
}
