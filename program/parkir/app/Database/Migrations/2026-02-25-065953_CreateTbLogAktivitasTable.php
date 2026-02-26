<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbLogAktivitasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_log' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'aktivitas' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'waktu_aktivitas' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => true,
            ],
            'user_agent' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_log', true);
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addKey('waktu_aktivitas');
        $this->forge->createTable('tb_log_aktivitas');
    }

    public function down()
    {
        $this->forge->dropTable('tb_log_aktivitas');
    }
}
