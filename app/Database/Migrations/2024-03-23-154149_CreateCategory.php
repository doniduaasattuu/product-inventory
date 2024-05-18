<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => false,
            ],
        ]);
        $this->forge->addKey('category', true);
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}
