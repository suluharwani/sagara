<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Comments extends Migration
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
      'id_content' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'id_user' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'parent_comment_id' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'comment' => [
        'type' => 'VARCHAR',
        'constraint' => 1000,
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
    $this->forge->createTable('comments');
  }

  public function down()
  {
    $this->forge->dropTable('comments');
  }
}
