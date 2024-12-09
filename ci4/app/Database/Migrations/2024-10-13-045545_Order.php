<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Order extends Migration
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
      'kode' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'id_client' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'deadline' => [
        'type' => 'datetime',
        'null' => true,
      ],
      'id_order_list' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      
      ],
      'link' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'nama_tim' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'logo_tim' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
      'deskripsi' => [
        'type' => 'text',
        'null' => true,
      ],
      'brand' => [
        'type' => 'VARCHAR',
        'constraint' => 200,
        'null' => true,
      ],
       'status' => [
        'type' => 'INT',
        'constraint' => 10,
        'default'=>0
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
    $this->forge->createTable('order');
  }

  public function down()
  {
    $this->forge->dropTable('order');
  }
}