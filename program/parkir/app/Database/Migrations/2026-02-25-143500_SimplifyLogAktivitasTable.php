<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SimplifyLogAktivitasTable extends Migration
{
    public function up()
    {
        // Drop existing table and recreate with simplified structure
        $this->forge->dropTable('tb_log_aktivitas', true);
        
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
                'null'       => true, // Allow NULL for guest activities
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
        ]);
        
        $this->forge->addKey('id_log', true);
        $this->forge->addKey('waktu_aktivitas');
        
        // Add foreign key with SET NULL for when user is deleted
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'SET NULL', 'CASCADE');
        
        $this->forge->createTable('tb_log_aktivitas');
    }

    public function down()
    {
        // Drop the simplified table
        $this->forge->dropTable('tb_log_aktivitas');
        
        // Recreate the original table structure (if needed)
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
                'null'       => true,
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
        $this->forge->addKey('waktu_aktivitas');
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tb_log_aktivitas');
    }
}
