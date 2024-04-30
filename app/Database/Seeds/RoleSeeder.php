<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'role' => 'Admin',
            ],
            [
                'role' => 'Manager',
            ],
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
