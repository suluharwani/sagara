<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStrukturOrganisasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
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
        $this->forge->createTable('struktur_organisasi');
    }

    public function down()
    {
        $this->forge->dropTable('struktur_organisasi');
    }
}
