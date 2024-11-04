<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Size extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ukuran' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('size');
    }

    public function down()
    {
        $this->forge->dropTable('size');
    }
}