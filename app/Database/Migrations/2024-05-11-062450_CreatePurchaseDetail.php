<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePurchaseDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'null'           => false,
            ],
            'purchase_id' => [
                'type'           => 'VARCHAR',
                'constraint'     => 25,
                'null'           => false,
            ],
            'product_id' => [
                'type'           => 'VARCHAR',
                'constraint'     => 25,
                'null'           => false
            ],
            'product_name' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false,
            ],
            'product_category' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => true,
            ],
            'product_price' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => false,
            ],
            'quantity' => [
                'type'           => 'INT',
                'auto_increment' => false,
                'unsigned'       => true,
                'null'           => false,
            ],
            'sub_total' => [
                'type'           => 'INT',
                'auto_increment' => false,
                'unsigned'       => true,
                'null'           => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('purchase_id', 'purchases', 'id');
        $this->forge->addForeignKey('product_id', 'products', 'id', onUpdate: 'CASCADE', onDelete: 'CASCADE');
        $this->forge->createTable('purchase_details');
    }

    public function down()
    {
        $this->forge->dropTable('purchase_details');
    }
}
