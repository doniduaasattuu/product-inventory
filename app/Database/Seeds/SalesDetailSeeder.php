<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SalesDetailSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'sales_id' => 'sl_5ece4797eaf5e',
                'product_id' => '662f1ad9aa70b',
                'product_name' => 'Apple MacBook Air 13 M1 Chip 256GB SSD 8GB',
                'product_category' => 'Computer',
                'product_price' => 14699000,
                'quantity' => 1,
                'sub_total' => 14699000,
            ],
            [
                'sales_id' => 'sl_5ece4797eaf5e',
                'product_id' => '662f1ad9aa70e',
                'product_name' => 'Apple MacBook Air M2 Chip 2023 15 Inch 256 GB',
                'product_category' => 'Computer',
                'product_price' => 18002000,
                'quantity' => 1,
                'sub_total' => 18002000,
            ],
            [
                'sales_id' => 'sl_5ece4797eaf5e',
                'product_id' => '662f1ad9aa71b',
                'product_name' => 'Dell Inspiron 3520-i51235U-8-512-U-W11-F-O',
                'product_category' => 'Computer',
                'product_price' => 9799000,
                'quantity' => 1,
                'sub_total' => 9799000,
            ],
        ];

        $this->db->table('sale_details')->insertBatch($data);
    }
}
