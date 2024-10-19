<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengisiAcara extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_pengisi' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'acara' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'tanggal' => [
                'type'           => 'DATETIME',
            ],
          'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
              'type' => 'datetime',
              'null' => true,
          ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengisi_acara');
    }

    public function down()
    {
        $this->forge->dropTable('pengisi_acara');
    }
}