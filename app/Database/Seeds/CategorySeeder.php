<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category' => 'Food',
            ],
            [
                'category' => 'Gadget',
            ],
            [
                'category' => 'Computer',
            ],
            [
                'category' => 'Book',
            ],
            [
                'category' => 'Electronic',
            ],
            [
                'category' => 'Automotive',
            ],

        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
