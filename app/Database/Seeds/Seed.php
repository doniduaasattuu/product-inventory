<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Seed extends Seeder
{
    public function run()
    {
        $db = db_connect();
        $db->table('purchase_details')->emptyTable();
        $db->table('purchases')->emptyTable();
        $db->table('suppliers')->emptyTable();
        $db->table('products')->emptyTable();
        $db->table('categories')->emptyTable();
        $db->table('users')->emptyTable();
        $db->table('roles')->emptyTable();

        // $this->call('RoleSeeder');
        $this->call('UserSeeder');
        $this->call('CategorySeeder');
        $this->call('ProductSeeder');
        $this->call('SupplierSeeder');
        $this->call('PurchaseSeeder');
        $this->call('PurchaseDetailSeeder');
    }
}
