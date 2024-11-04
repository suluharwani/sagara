<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gallery extends Migration
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
      'judul' => [
        'type' => 'VARCHAR',
        'constraint' => 600,
        'null' => true,
      ],
       'picture' => [
        'type' => 'VARCHAR',
        'constraint' => 600,
        'null' => true,
      ],
      'slug' => [
        'type' => 'VARCHAR',
        'constraint' => 600,
        'null' => true,
      ],
      'content' => [
        'type' => 'VARCHAR',
        'constraint' => 50000,
        'null' => true,
      ],
      'id_admin' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'id_cat' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'status' => [
        'type' => 'TINYINT',
        'constraint' => 1,
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
    $this->forge->createTable('gallery');
  }

  public function down()
  {
    $this->forge->dropTable('gallery');
  }
}
