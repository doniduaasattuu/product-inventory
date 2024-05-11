<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePurchase extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'VARCHAR',
                'constraint'     => 25,
                'null'           => false,
            ],
            'supplier' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'null'           => true,
            ],
            'status' => [
                'type'           => 'ENUM',
                'constraint'     => ['Pending', 'Sent'],
                'null'           => true,
            ],
            'admin_email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false,
            ],
            'total' => [
                'type'           => 'INT',
                'auto_increment' => false,
                'unsigned'       => true,
                'null'           => false,
            ],
            'created_at' => [
                'type'           => 'TIMESTAMP',
                'default'        => new RawSql('CURRENT_TIMESTAMP'),
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'TIMESTAMP',
                'default'        => new RawSql('CURRENT_TIMESTAMP'),
                'null'           => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('supplier', 'suppliers', 'id', onUpdate: 'no action', onDelete: 'no action');
        $this->forge->addForeignKey('admin_email', 'users', 'email', onUpdate: 'no action', onDelete: 'no action');
        $this->forge->createTable('purchases');
    }

    public function down()
    {
        $this->forge->dropTable('purchases');
    }
}
