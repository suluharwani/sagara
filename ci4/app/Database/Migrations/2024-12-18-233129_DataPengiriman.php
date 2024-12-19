<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DataPengiriman extends Migration
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
                'type' => 'INT',
                'constraint' => 10,
            ],
            'from' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'remark' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
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
        $this->forge->createTable('data_pengiriman');
    }

    public function down()
    {
        $this->forge->dropTable('data_pengiriman');
    }
}