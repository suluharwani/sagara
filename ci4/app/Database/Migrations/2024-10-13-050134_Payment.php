<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Payment extends Migration
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
      'id_order' => [
        'type' => 'INT',
        'constraint' => 10,
        'null' => true,
      ],
      'price' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'downpayment' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'name' => [
        'type' => 'VARCHAR',
        'constraint' => 50,
        'null' => true,
      ],
      'completion' => [
        'type' => 'INT',
        'constraint' => 20,
        'null' => true,
      ],
      'discount' => [
        'type' => 'float',
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
    $this->forge->createTable('payment');
  }

  public function down()
  {
    $this->forge->dropTable('payment');
  }
}