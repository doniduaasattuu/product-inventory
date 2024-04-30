<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->call('RoleSeeder');

        $data = [
            [
                'name' => 'Doni Darmawan',
                'email' => 'doni.duaasattuu@gmail.com',
                'password' => 'rahasia',
                'role' => 'Manager',
                'created_at' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            [
                'name' => 'Shintia Kartika Sari',
                'email' => 'shintiakartikasari22@gmail.com',
                'password' => 'rahasia',
                'role' => 'Admin',
                'created_at' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            [
                'name' => 'Anggi Gita Cahyani',
                'email' => 'anggigitacahyani@gmail.com',
                'password' => 'rahasia',
                'role' => 'Admin',
                'created_at' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            [
                'name' => 'Tiara Anggreani',
                'email' => 'tiaraanggreani@gmail.com',
                'password' => 'rahasia',
                'role' => 'Admin',
                'created_at' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
