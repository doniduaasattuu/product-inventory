<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Erajaya'
            ],
            [
                'name' => 'iBox Indonesia'
            ],
        ];

        $this->db->table('suppliers')->insertBatch($data);
    }
}
