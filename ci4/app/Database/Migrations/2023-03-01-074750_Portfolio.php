<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Portfolio extends Migration
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
       'nama' => [
        'type' => 'VARCHAR',
        'constraint' => 500,
        'null' => true,
      ],
      'picture' => [
        'type' => 'VARCHAR',
        'constraint' => 250,
        'null' => true,
      ],
      'id_client' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'id_product' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'link' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
       'delivered_at' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'status' => [
        'type' => 'TINYINT',
        'constraint' => 1,
        'null' => true,
        'default'=>1,
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
    $this->forge->createTable('portfolio');
  }

  public function down()
  {
    $this->forge->dropTable('portfolio');
  }
}
