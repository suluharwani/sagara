<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableOrder extends Migration
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
            'id_order' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_product' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_size' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'ukuran' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'nomor_punggung' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'keterangan' => [
                'type' => 'ENUM',
                'constraint' => ['player', 'keeper'],
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
        $this->forge->createTable('orderTable');
    }

    public function down()
    {
        $this->forge->dropTable('orderTable');
    }
}