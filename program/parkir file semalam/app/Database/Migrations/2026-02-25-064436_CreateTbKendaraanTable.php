<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbKendaraanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kendaraan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'plat_nomor' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => false,
            ],
            'jenis_kendaraan' => [
                'type'       => "ENUM('mobil','motor','truk','bus','lainnya')",
                'null'       => false,
            ],
            'warna' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'pemilik' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
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
        $this->forge->addKey('id_kendaraan', true);
        $this->forge->addForeignKey('id_user', 'tb_user', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_kendaraan');
    }

    public function down()
    {
        $this->forge->dropTable('tb_kendaraan');
    }
}
