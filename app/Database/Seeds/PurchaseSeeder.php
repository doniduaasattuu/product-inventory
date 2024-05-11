<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'pc_663f7811645f5',
                'supplier' => null,
                'status' => 'Sent',
                'admin_email' => 'doni.duaasattuu@gmail.com',
                'total' => 12000000,
                'created_at' => '2024-05-01 21:47:12',
                'updated_at' => '2024-05-01 21:47:12',
            ],
            [
                'id' => 'pc_663f8abee9204',
                'supplier' => null,
                'status' => 'Sent',
                'admin_email' => 'doni.duaasattuu@gmail.com',
                'total' => 17000000,
                'created_at' => '2024-05-02 22:12:23',
                'updated_at' => '2024-05-02 22:12:23',
            ],
            [
                'id' => 'pc_663f8ae006e76',
                'supplier' => null,
                'status' => 'Sent',
                'admin_email' => 'doni.duaasattuu@gmail.com',
                'total' => 21000000,
                'created_at' => '2024-05-03 22:12:23',
                'updated_at' => '2024-05-03 22:12:23',
            ],
            [
                'id' => 'pc_663f8af7d8341',
                'supplier' => null,
                'status' => 'Sent',
                'admin_email' => 'doni.duaasattuu@gmail.com',
                'total' => 12000000,
                'created_at' => '2024-05-04 22:12:23',
                'updated_at' => '2024-05-04 22:12:23',
            ],
            [
                'id' => 'pc_663f8af7d85ba',
                'supplier' => null,
                'status' => 'Sent',
                'admin_email' => 'doni.duaasattuu@gmail.com',
                'total' => 19000000,
                'created_at' => '2024-05-06 22:12:23',
                'updated_at' => '2024-05-06 22:12:23',
            ],
            [
                'id' => 'pc_663f8b1bd065b',
                'supplier' => null,
                'status' => 'Sent',
                'admin_email' => 'doni.duaasattuu@gmail.com',
                'total' => 15000000,
                'created_at' => '2024-05-07 22:12:23',
                'updated_at' => '2024-05-07 22:12:23',
            ],
            [
                'id' => 'pc_663f8bd74cc38',
                'supplier' => null,
                'status' => 'Sent',
                'admin_email' => 'doni.duaasattuu@gmail.com',
                'total' => 19000000,
                'created_at' => '2024-05-08 22:12:23',
                'updated_at' => '2024-05-08 22:12:23',
            ],
        ];

        $this->db->table('purchases')->insertBatch($data);
    }
}
