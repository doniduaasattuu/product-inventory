<?php

namespace App\Database\Seeds;

use Carbon\Carbon;
use CodeIgniter\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'pc_663f7811645f5',
                'supplier' => null,
                'status' => 'Approved',
                'admin_email' => 'anggigitacahyani@gmail.com',
                'total' => 35099000,
                'created_at' => Carbon::now()->addDays(-7)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-7)->toDateTimeString(),
            ],
            [
                'id' => 'pc_663f8abee9204',
                'supplier' => null,
                'status' => 'Done',
                'admin_email' => 'anggigitacahyani@gmail.com',
                'total' => 17000000,
                'created_at' => Carbon::now()->addDays(-6)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-6)->toDateTimeString(),
            ],
            [
                'id' => 'pc_663f8ae006e76',
                'supplier' => null,
                'status' => 'Done',
                'admin_email' => 'shintiakartikasari22@gmail.com',
                'total' => 21000000,
                'created_at' => Carbon::now()->addDays(-5)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-5)->toDateTimeString(),
            ],
            [
                'id' => 'pc_663f8af7d8341',
                'supplier' => null,
                'status' => 'Done',
                'admin_email' => 'tiaraanggreani@gmail.com',
                'total' => 12000000,
                'created_at' => Carbon::now()->addDays(-4)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-4)->toDateTimeString(),
            ],
            [
                'id' => 'pc_663f8af7d85ba',
                'supplier' => null,
                'status' => 'Done',
                'admin_email' => 'tiaraanggreani@gmail.com',
                'total' => 19000000,
                'created_at' => Carbon::now()->addDays(-3)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-3)->toDateTimeString(),
            ],
            [
                'id' => 'pc_663f8b1bd065b',
                'supplier' => null,
                'status' => 'Done',
                'admin_email' => 'shintiakartikasari22@gmail.com',
                'total' => 15000000,
                'created_at' => Carbon::now()->addDays(-2)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-2)->toDateTimeString(),
            ],
            [
                'id' => 'pc_663f8bd74cc38',
                'supplier' => null,
                'status' => 'Done',
                'admin_email' => 'tiaraanggreani@gmail.com',
                'total' => 19000000,
                'created_at' => Carbon::now()->addDays(-1)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-1)->toDateTimeString(),
            ],
        ];

        $this->db->table('purchases')->insertBatch($data);
    }
}
