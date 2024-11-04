<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Page extends Migration
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
      ],
      'slug' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'updated_at' => [
        'type' => 'datetime',
        'null' => true,
      ],
      'deleted_at' => [
        'type' => 'datetime',
        'null' => true,
      ],
      'created_at datetime default current_timestamp',
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('page');
  }

  public function down()
  {
    $this->forge->dropTable('page');
  }
}
