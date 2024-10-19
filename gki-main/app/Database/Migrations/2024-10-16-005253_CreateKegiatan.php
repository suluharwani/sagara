<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKegiatan extends Migration
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
            'nama_kegiatan' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'deskripsi' => [
                'type'           => 'TEXT',
            ],
            'tanggal' => [
                'type'           => 'DATE',
            ],
            'lokasi' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
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
        $this->forge->createTable('kegiatan');
    }

    public function down()
    {
        $this->forge->dropTable('kegiatan');
    }
}