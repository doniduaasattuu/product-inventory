<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRole extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'role' => [
                'type'           => 'VARCHAR',
                'constraint'     => 50,
                'null'           => false,
            ],
        ]);
        $this->forge->addKey('role', true);
        $this->forge->createTable('roles');
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}
