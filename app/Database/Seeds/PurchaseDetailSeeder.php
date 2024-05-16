<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseDetailSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'purchase_id' => 'pc_663f7811645f5',
                'product_id' => '662f1ad9aa70b',
                'product_name' => 'Apple MacBook Air 13 M1 Chip 256GB SSD 8GB',
                'product_category' => 'Computer',
                'product_price' => 14699000,
                'quantity' => 3,
                'sub_total' => 44097000,
            ],
            [
                'purchase_id' => 'pc_663f7811645f5',
                'product_id' => '662f1ad9aa72d',
                'product_name' => 'iPhone 12 Pro 128 GB',
                'product_category' => 'Gadget',
                'product_price' => 18499000,
                'quantity' => 1,
                'sub_total' => 18499000,
            ],
        ];

        $this->db->table('purchase_details')->insertBatch($data);
    }
}
