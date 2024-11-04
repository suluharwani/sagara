<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GalleryCat extends Migration
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
      'category' => [
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
    $this->forge->createTable('gallery_category');
  }

  public function down()
  {
    $this->forge->dropTable('gallery_category');
  }
}