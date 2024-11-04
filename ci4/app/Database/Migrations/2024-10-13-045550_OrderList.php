<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderList extends Migration
{ public function up()
  {
   $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'constraint' => 10,
        'unsigned' => true,
        'auto_increment' => true,
      ],
      'id_order' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'id_product' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'price' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
       'status' => [
        'type' => 'INT',
        'constraint' => 10,
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
    $this->forge->createTable('order_list');
  }

  public function down()
  {
    $this->forge->dropTable('order_list');
  }
}