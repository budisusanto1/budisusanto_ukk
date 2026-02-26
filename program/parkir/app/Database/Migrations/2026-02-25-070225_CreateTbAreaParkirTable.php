<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbAreaParkirTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_area' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_area' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'kapasitas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'terisi' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_area', true);
        $this->forge->createTable('tb_area_parkir');
    }

    public function down()
    {
        $this->forge->dropTable('tb_area_parkir');
    }
}
