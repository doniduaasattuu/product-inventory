<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'role' => 'Admin',
        ];

        $this->db->table('roles')->insert($data);
    }
}
