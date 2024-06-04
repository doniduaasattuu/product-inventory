<?php

namespace App\Database\Seeds;

use Carbon\Carbon;
use CodeIgniter\Database\Seeder;

class SalesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'sl_5ece4797eaf5e',
                'admin_email' => 'tiaraanggreani@gmail.com',
                'total' => 42500000,
                'created_at' => Carbon::now()->addDays(-7)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-7)->toDateTimeString(),
            ],
            [
                'id' => 'sl_66488eb0d31d2',
                'admin_email' => 'shintiakartikasari22@gmail.com',
                'total' => 56000000,
                'created_at' => Carbon::now()->addDays(-6)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-6)->toDateTimeString(),
            ],
            [
                'id' => 'sl_66488eba663f1',
                'admin_email' => 'shintiakartikasari22@gmail.com',
                'total' => 23000000,
                'created_at' => Carbon::now()->addDays(-5)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-5)->toDateTimeString(),
            ],
            [
                'id' => 'sl_66488ec57e96b',
                'admin_email' => 'anggigitacahyani@gmail.com',
                'total' => 17000000,
                'created_at' => Carbon::now()->addDays(-4)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-4)->toDateTimeString(),
            ],
            [
                'id' => 'sl_66488ecf25f64',
                'admin_email' => 'anggigitacahyani@gmail.com',
                'total' => 26000000,
                'created_at' => Carbon::now()->addDays(-3)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-3)->toDateTimeString(),
            ],
            [
                'id' => 'sl_66488edcbbd1b',
                'admin_email' => 'shintiakartikasari22@gmail.com',
                'total' => 43000000,
                'created_at' => Carbon::now()->addDays(-2)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-2)->toDateTimeString(),
            ],
            [
                'id' => 'sl_66488eeb90134',
                'admin_email' => 'tiaraanggreani@gmail.com',
                'total' => 29000000,
                'created_at' => Carbon::now()->addDays(-1)->toDateTimeString(),
                'updated_at' => Carbon::now()->addDays(-1)->toDateTimeString(),
            ],
        ];

        $this->db->table('sales')->insertBatch($data);
    }
}
