<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomDesigns extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('custom_designs')) {
            return;
        }
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kind' => ['type' => 'VARCHAR', 'constraint' => 20],
            'code' => ['type' => 'VARCHAR', 'constraint' => 64],
            'title' => ['type' => 'VARCHAR', 'constraint' => 100],
            'category' => ['type' => 'VARCHAR', 'constraint' => 80, 'default' => ''],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20],
            'customer_name' => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => ''],
            'customer_phone' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => ''],
            'admin_note' => ['type' => 'TEXT', 'null' => true],
            'document' => ['type' => 'LONGTEXT'],
            'thumbnail' => ['type' => 'MEDIUMTEXT', 'null' => true],
            'revision' => ['type' => 'INT', 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey(['kind', 'status']);
        $this->forge->createTable('custom_designs', true);
    }

    public function down()
    {
        $this->forge->dropTable('custom_designs', true);
    }
}
