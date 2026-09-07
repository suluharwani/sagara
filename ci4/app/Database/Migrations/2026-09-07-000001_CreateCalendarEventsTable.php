<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCalendarEventsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'event_date' => [
                'type' => 'DATE',
            ],
            'event_type' => [
                'type' => 'ENUM',
                'constraint' => ['schedule', 'holiday', 'announcement', 'production', 'deadline'],
                'default' => 'schedule',
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => '#1976d2',
            ],
            'is_all_day' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('calendar_events');
    }

    public function down()
    {
        $this->forge->dropTable('calendar_events');
    }
}