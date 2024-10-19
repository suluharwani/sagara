<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwal extends Migration
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
            'tanggal' => [
                'type'           => 'DATE',
            ],
            'waktu_mulai' => [
                'type'           => 'TIME',
            ],
            'waktu_selesai' => [
                'type'           => 'TIME',
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
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}
