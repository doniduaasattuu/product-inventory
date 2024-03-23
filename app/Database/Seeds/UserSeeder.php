<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'Doni Darmawan',
            'email' => 'doni.duaasattuu@gmail.com',
            'password' => 'rahasia',
            'role' => 'Admin',
            'created_at' => new RawSql('CURRENT_TIMESTAMP'),
        ];

        $this->db->table('users')->insert($data);
    }
}
