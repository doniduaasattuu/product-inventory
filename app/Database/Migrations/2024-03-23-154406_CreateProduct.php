<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateProduct extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'VARCHAR',
                'CONSTRAINT'     => 13,
                'null'           => false,
            ],
            'name' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false,
            ],
            'category' => [
                'type'           => 'VARCHAR',
                'constraint'     => 256,
                'null'           => true,
            ],
            'price' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 0,
                'null'           => true,
            ],
            'stock' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'default'        => 0,
                'null'           => true,
            ],
            'attachment' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true,
            ],
            'admin_email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true,
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
        $this->forge->addForeignKey('category', 'categories', 'category');
        $this->forge->addForeignKey('admin_email', 'users', 'email', onUpdate: 'no action', onDelete: 'no action');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
