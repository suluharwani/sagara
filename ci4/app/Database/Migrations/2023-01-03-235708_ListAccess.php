<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ListAccess extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'auto_increment' => true,
      ],
      'page' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ]
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('list_access');
  }

  public function down()
  {
    $this->forge->dropTable('list_access');
  }
}
