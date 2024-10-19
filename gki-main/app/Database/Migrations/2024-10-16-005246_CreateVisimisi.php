<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVisimisi extends Migration
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
            'visi' => [
                'type'           => 'TEXT',
            ],
            'misi' => [
                'type'           => 'TEXT',
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
        $this->forge->createTable('visi_misi');
    }

    public function down()
    {
        $this->forge->dropTable('visi_misi');
    }
}