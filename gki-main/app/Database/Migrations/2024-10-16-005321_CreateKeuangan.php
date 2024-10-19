<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKeuangan extends Migration
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
            'deskripsi' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'jumlah' => [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
            'tipe' => [
                'type'           => 'ENUM',
                'constraint'     => ['pemasukan', 'pengeluaran'],
            ],
            'tanggal' => [
                'type'           => 'DATE',
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
        $this->forge->createTable('keuangan');
    }

    public function down()
    {
        $this->forge->dropTable('keuangan');
    }
}